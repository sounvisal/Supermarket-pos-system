<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\TaxRate;

class DiscountController extends Controller
{
    /**
     * Display a listing of the discounts.
     */
    public function index()
    {
        // Get discounts with their related products
        $discounts = Discount::with('product')->orderBy('created_at', 'desc')->paginate(10);
        
        // Get all active products
        $products = Products::where('status', 1)->orderBy('product_name')->get();
        
        // Get unique categories from products
        $categories = Products::select('category')
                      ->where('status', 1)
                      ->distinct()
                      ->orderBy('category')
                      ->pluck('category');
        
        // Get the default tax rate
        $defaultTaxRate = TaxRate::getDefault();
        
        // Return the view with all necessary data
        return view('master.sitting', compact('discounts', 'products', 'categories', 'defaultTaxRate'));
    }

    /**
     * Store a newly created discount.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'discount_percentage' => 'required|numeric|min:0|max:100',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after:start_date',
                'description' => 'nullable|string|max:255',
            ]);
            
            // Add conditional validation based on discount type
            if ($request->discount_type === 'product') {
                $validator->addRules(['product_id' => 'required|exists:products,id']);
            } elseif ($request->discount_type === 'category') {
                $validator->addRules(['category' => 'required|string']);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid discount type'
                ], 422);
            }
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            // Start transaction
            DB::beginTransaction();
            
            $discountData = [
                'discount_percentage' => $request->discount_percentage,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => $request->has('is_active') ? true : false,
                'description' => $request->description,
            ];
            
            // Add either product_id or category based on discount type
            if ($request->discount_type === 'product') {
                $discountData['product_id'] = $request->product_id;
                $discountData['category'] = null;
            } else {
                $discountData['category'] = $request->category;
                $discountData['product_id'] = null;
            }
            
            $discount = Discount::create($discountData);
            
            DB::commit();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Discount created successfully',
                    'discount' => $discount
                ]);
            }
            
            return redirect()->back()->with('success', 'Discount created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating discount: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating discount: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error creating discount');
        }
    }

    /**
     * Update the specified discount.
     */
    public function update(Request $request, $id)
    {
        try {
            $discount = Discount::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                'discount_percentage' => 'required|numeric|min:0|max:100',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after:start_date',
                'description' => 'nullable|string|max:255',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            // Update discount
            $discount->discount_percentage = $request->discount_percentage;
            $discount->start_date = $request->start_date;
            $discount->end_date = $request->end_date;
            $discount->is_active = $request->has('is_active') ? true : false;
            $discount->description = $request->description;
            
            $discount->save();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Discount updated successfully',
                    'discount' => $discount
                ]);
            }
            
            return redirect()->back()->with('success', 'Discount updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating discount: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating discount: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error updating discount');
        }
    }

    /**
     * Remove the specified discount.
     */
    public function destroy($id)
    {
        try {
            $discount = Discount::findOrFail($id);
            $discount->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Discount deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting discount: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error deleting discount: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Immediately stop a discount
     */
    public function stopDiscount($id)
    {
        try {
            $discount = Discount::findOrFail($id);
            $discount->is_active = false;
            $discount->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Discount stopped successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error stopping discount: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error stopping discount: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get a specific discount for editing
     */
    public function show($id)
    {
        try {
            $discount = Discount::with('product')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'discount' => $discount
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting discount: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error getting discount: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get discounts for a product
     */
    public function getDiscountsForProduct($productId)
    {
        try {
            $product = Products::findOrFail($productId);
            
            // Get product-specific discounts
            $productDiscounts = Discount::active()->forProduct($productId)->get();
            
            // Get category discounts for this product's category
            $categoryDiscounts = Discount::active()->forCategory($product->category)->get();
            
            // Combine all applicable discounts
            $allDiscounts = $productDiscounts->merge($categoryDiscounts);
            
            return response()->json([
                'success' => true,
                'discounts' => $allDiscounts
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting discounts for product: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error getting discounts for product: ' . $e->getMessage()
            ], 500);
        }
    }
}
