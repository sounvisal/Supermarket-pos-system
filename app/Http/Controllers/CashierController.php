<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Discount;
use App\Models\TaxRate;

class CashierController extends Controller
{
    public function searchProduct(Request $request)
    {
        $query = $request->input('search');
        $category = $request->input('category');
        
        // Get products from database based on search query
        $productsQuery = DB::table('products')->where('status', 1);
        
        // If search query is provided, filter by it
        if ($query) {
            $productsQuery->where(function($q) use ($query) {
                $q->where('product_name', 'like', '%' . $query . '%')
                  ->orWhere('category', 'like', '%' . $query . '%');
            });
        }
        
        // If category is provided, filter by exact category
        if ($category) {
            $productsQuery->where('category', $category);
        }
        
        // Get the products with ordering
        $products = $productsQuery->orderBy('id', 'desc')->get();
        
        // Get the current tax rate to pass to the view
        $currentTaxRate = $this->getCurrentTaxRate();
        
        // Share the current tax rate with all views in the current request
        app()->singleton('current_tax_rate', function () use ($currentTaxRate) {
            return $currentTaxRate;
        });
        
        // For AJAX requests, return JSON response
        if ($request->ajax() || $request->has('ajax')) {
            return response()->json([
                'success' => true,
                
                'products' => $products,
                'count' => count($products),
                'query' => $query,
                'category' => $category,
                'current_tax_rate' => $currentTaxRate
            ]);
        }
        
        // For regular requests, return view with data
        return view('home.charge', [

            'products' => $products,
            'query' => $query,
            'category' => $category,
            'currentTaxRate' => $currentTaxRate
        ]);
    }

    public function confirmProduct(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $product = Products::findOrFail($productId);
            
            // Initialize the cart session if it doesn't exist
            if (!Session::has('cart')) {
                Session::put('cart', []);
            }
            
            $cart = Session::get('cart');
            
            // Check if the product is already in the cart
            $itemExists = false;
            foreach ($cart as $key => $item) {
                if ($item['id'] == $productId) {
                    // Increment quantity if product already exists
                    $cart[$key]['quantity'] += 1;
                    $cart[$key]['subtotal'] = $cart[$key]['quantity'] * $cart[$key]['price'];
                    
                    // Apply discount if applicable
                    if (isset($cart[$key]['discount']) && $cart[$key]['discount'] > 0) {
                        $discountAmount = ($cart[$key]['subtotal'] * $cart[$key]['discount']) / 100;
                        $cart[$key]['subtotal'] -= $discountAmount;
                    }
                    
                    $itemExists = true;
                    break;
                }
            }
            
            // Add product to cart if it doesn't exist
            if (!$itemExists) {
                // Check for applicable discount
                $applicableDiscount = $this->getApplicableDiscount($productId);
                $discountPercentage = 0;
                
                // Calculate price with discount if applicable
                $originalPrice = $product->price;
                $finalPrice = $originalPrice;
                
                if ($applicableDiscount) {
                    $discountPercentage = $applicableDiscount->discount_percentage;
                    $finalPrice = $this->applyDiscount($originalPrice, $discountPercentage);
                }
                
                $cart[] = [
                    'id' => $product->id,
                    'name' => $product->product_name,
                    'code' => $product->product_code,
                    'price' => $originalPrice,
                    'quantity' => 1,
                    'discount' => $discountPercentage,
                    'subtotal' => $finalPrice,
                    'category' => $product->category
                ];
            }
            
            // Update cart in session
            Session::put('cart', $cart);
            
            // Check if it's an AJAX request
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product added to cart',
                    'cart_count' => count($cart),
                    'cart' => $cart // Return cart data for debugging
                ]);
            }
            
            return redirect()->back()->with('success', 'Product added to cart');
        } catch (\Exception $e) {
            Log::error('Error adding product to cart: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error adding product to cart: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error adding product to cart');
        }
    }

    public function removeFromCart(Request $request)
    {
        try {
            $index = $request->input('index');
            
            if (Session::has('cart')) {
                $cart = Session::get('cart');
                
                if (isset($cart[$index])) {
                    // Remove the item from the cart
                    array_splice($cart, $index, 1);
                    Session::put('cart', $cart);
                    
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Item removed from cart',
                            'cart' => $cart
                        ]);
                    }
                    
                    return redirect()->back()->with('success', 'Item removed from cart');
                }
            }
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart'
                ], 404);
            }
            
            return redirect()->back()->with('error', 'Item not found in cart');
        } catch (\Exception $e) {
            Log::error('Error removing item from cart: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error removing item from cart: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error removing item from cart');
        }
    }

    public function updateQuantity(Request $request)
    {
        $index = $request->input('index');
        $action = $request->input('action');
        
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            
            if (isset($cart[$index])) {
                if ($action === 'increase') {
                    // Check stock availability
                    $product = Products::find($cart[$index]['id']);
                    if ($product && $cart[$index]['quantity'] < $product->qty) {
                        $cart[$index]['quantity'] += 1;
                    } else {
                        return response()->json(['success' => false, 'message' => 'Not enough stock available']);
                    }
                } else if ($action === 'decrease') {
                    if ($cart[$index]['quantity'] > 1) {
                        $cart[$index]['quantity'] -= 1;
                    } else {
                        // Remove item if quantity would be 0
                        array_splice($cart, $index, 1);
                        Session::put('cart', $cart);
                        return response()->json(['success' => true]);
                    }
                }
                
                // Update subtotal
                if (isset($cart[$index])) {
                    $cart[$index]['subtotal'] = $cart[$index]['quantity'] * $cart[$index]['price'];
                }
                
                Session::put('cart', $cart);
                return response()->json(['success' => true]);
            }
        }
        
        return response()->json(['success' => false, 'message' => 'Item not found in cart']);
    }

    public function updateDiscount(Request $request)
    {
        try {
            $index = $request->input('index');
            $discountPercent = $request->input('discount');
            
            if (Session::has('cart')) {
                $cart = Session::get('cart');
                
                if (isset($cart[$index])) {
                    // Store discount percentage
                    $cart[$index]['discount'] = $discountPercent;
                    
                    // Calculate discounted price
                    $originalPrice = $cart[$index]['price'];
                    $quantity = $cart[$index]['quantity'];
                    
                    if ($discountPercent > 0) {
                        $discountAmount = ($originalPrice * $discountPercent) / 100;
                        $discountedPrice = $originalPrice - $discountAmount;
                        $cart[$index]['subtotal'] = $quantity * $discountedPrice;
                    } else {
                        // No discount
                        $cart[$index]['subtotal'] = $quantity * $originalPrice;
                    }
                    
                    Session::put('cart', $cart);
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Discount applied successfully',
                        'item' => $cart[$index],
                        'cart' => $cart
                    ]);
                }
                
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart'
                ], 404);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error applying discount: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error applying discount: ' . $e->getMessage()
            ], 500);
        }
    }

    public function completeSale(Request $request)
    {
        try {
            // Check if cart exists and has items
            if (!Session::has('cart') || empty(Session::get('cart'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot complete sale: Cart is empty'
                ], 400);
            }
            
            DB::beginTransaction();
            
            $cart = Session::get('cart');
            $paymentMethod = $request->input('payment_method', 'Cash');
            $customerName = $request->input('customer_name');
            $notes = $request->input('notes');
            
            // Calculate totals
            $subtotal = collect($cart)->sum('subtotal');
            
            // Get current tax rate from database
            $taxRate = $this->getCurrentTaxRate() / 100; // Convert percentage to decimal
            $taxAmount = $subtotal * $taxRate;
            
            // Calculate total discount amount
            $totalDiscount = 0;
            foreach ($cart as $item) {
                if (isset($item['discount']) && $item['discount'] > 0) {
                    $originalSubtotal = $item['quantity'] * $item['price'];
                    $discountedSubtotal = $item['subtotal'];
                    $totalDiscount += ($originalSubtotal - $discountedSubtotal);
                }
            }
            
            $grandTotal = $subtotal + $taxAmount;
            
            // Create the sale record
            $sale = Sale::create([
                'invoice_number' => Sale::generateInvoiceNumber(),
                'user_id' => Auth::check() ? Auth::id() : null, // If user is authenticated
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $totalDiscount,
                'grand_total' => $grandTotal,
                'payment_method' => $paymentMethod,
                'cashier_name' => Auth::check() ? Auth::user()->name : 'John Doe', // Use actual cashier name if authenticated
                'customer_name' => $customerName,
                'notes' => $notes,
                'status' => 'completed'
            ]);
            
            // Create sale items
            foreach ($cart as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'product_code' => $item['code'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'discount_percent' => $item['discount'] ?? 0,
                    'subtotal' => $item['subtotal']
                ]);
                
                // Update product inventory (reduce quantity)
                $product = Products::find($item['id']);
                if ($product) {
                    $product->qty = max(0, $product->qty - $item['quantity']);
                    $product->save();
                }
            }
            
            // Clear the cart
            Session::forget('cart');
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Sale completed successfully',
                'invoice_number' => $sale->invoice_number,
                'sale_id' => $sale->id,
                'sale_data' => [
                    'subtotal' => $subtotal,
                    'tax_amount' => $taxAmount,
                    'discount_amount' => $totalDiscount,
                    'grand_total' => $grandTotal,
                    'payment_method' => $paymentMethod
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error completing sale: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error completing sale: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get applicable discount for a product
     */
    public function getApplicableDiscount($productId)
    {
        try {
            $product = Products::findOrFail($productId);
            
            // Look for product-specific discounts first (they take precedence)
            $productDiscount = Discount::active()
                                ->forProduct($productId)
                                ->orderBy('discount_percentage', 'desc') // Get highest discount
                                ->first();
            
            if ($productDiscount) {
                return $productDiscount;
            }
            
            // If no product-specific discount, look for category discount
            $categoryDiscount = Discount::active()
                                ->forCategory($product->category)
                                ->orderBy('discount_percentage', 'desc') // Get highest discount
                                ->first();
            
            return $categoryDiscount;
        } catch (\Exception $e) {
            Log::error('Error getting applicable discount: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Apply discount to a product price
     */
    public function applyDiscount($price, $discountPercentage)
    {
        if ($discountPercentage <= 0) {
            return $price;
        }
        
        $discountAmount = ($price * $discountPercentage) / 100;
        return $price - $discountAmount;
    }

    /**
     * Get current tax rate
     */
    public function getCurrentTaxRate()
    {
        try {
            $defaultTaxRate = TaxRate::getDefault();
            
            if ($defaultTaxRate) {
                return $defaultTaxRate->rate;
            }
            
            // Default to 6% if no tax rate is configured
            return 6.0;
        } catch (\Exception $e) {
            Log::error('Error getting current tax rate: ' . $e->getMessage());
            return 6.0; // Default to 6% on error
        }
    }
}
