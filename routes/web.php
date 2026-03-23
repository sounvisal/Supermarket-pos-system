<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\TaxRateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

// Language switching removed per user request

// Debug language settings
Route::get('/debug/language', function() {
    return [
        'session_locale' => session('locale'),
        'app_locale' => app()->getLocale(),
        'cookie_locale' => request()->cookie('locale')
    ];
});

// Profile routes
Route::middleware(['auth'])->group(function() {
    Route::get('/profile', function() {
        return view('profile.edit');
    })->name('profile.edit');
    
    Route::post('/profile/update', function(Request $request) {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/profiles'), $imageName);
            
            // Delete old image if exists
            if ($user->profile_image && file_exists(public_path('images/profiles/' . $user->profile_image))) {
                unlink(public_path('images/profiles/' . $user->profile_image));
            }
            
            $user->profile_image = $imageName;
        }
        
        // Update the user model in the database
        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'profile_image' => $user->profile_image,
            ]);
        
        return redirect()->back()->with('success', 'Profile updated successfully!');
    })->name('profile.update');
});

// Welcome/Login page
Route::get('/', function () {
    return view('welcome');
})->name('login');

// Authentication routes
Route::post('/login', [AuthController::class, 'login'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes that require authentication
Route::middleware(['auth'])->group(function () {
    
    // Cashier routes - login redirects to charge page
    Route::get('/home/charge', function () {
        if (Auth::user()->role !== 'cashier' && Auth::user()->role !== 'manager') {
            return redirect('/');
        }
        return view('home.charge');
    });
    
    

    // Cashier functions
    Route::prefix('home')->group(function () {
        Route::get('/cashier/search', [CashierController::class, 'searchProduct'])->name('cashier.search');
        Route::get('/cashier/search-product', [CashierController::class, 'searchProduct'])->name('cashier.search-product');
        Route::post('/cashier/confirm-product', [CashierController::class, 'confirmProduct'])->name('cashier.confirm-product');
        Route::post('/cashier/remove-from-cart', [CashierController::class, 'removeFromCart'])->name('cashier.remove-from-cart');
        Route::post('/cashier/update-quantity', [CashierController::class, 'updateQuantity'])->name('cashier.update-quantity');
        Route::post('/cashier/update-discount', [CashierController::class, 'updateDiscount'])->name('cashier.update-discount');
        Route::post('/cashier/complete-sale', [CashierController::class, 'completeSale'])->name('cashier.complete-sale');
    });
    
    // Master routes
    Route::prefix('master')->group(function () {
        // Dashboard routes
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::get('/index', [DashboardController::class, 'index']);
        
        // Product routes - accessible by stock staff and managers
        Route::get('/product', [ProductController::class, 'showproduct']);
        Route::get('/addproduct', function() {
            if (Auth::user()->role !== 'stock' && Auth::user()->role !== 'manager') {
                return redirect('/');
            }
            return view('master.addproduct');
        });
        Route::post('/product/save', [ProductController::class, 'addproduct']);
        Route::get('/editproduct/{id}', [ProductController::class, 'editproduct']);
        Route::post('/product/update', [ProductController::class, 'updateproduct']);
        Route::get('/deleteproduct/{id}', [ProductController::class, 'deleteproduct']);
        Route::get('/restock/{id}', [ProductController::class, 'restock']);
        Route::post('/product/restock', [ProductController::class, 'restockproduct']);
        Route::get('/searchproduct', [ProductController::class, 'searchproduct']);
        
        // Manager-only routes
        Route::get('/sitting', function() {
            if (Auth::user()->role !== 'manager') {
                return redirect('/');
            }
            return app(DiscountController::class)->index();
        });
        
        // Employee management - managers only
        Route::get('/employees', function() {
            if (Auth::user()->role !== 'manager') {
                return redirect('/');
            }
            return app(EmployeeController::class)->showEmployees();
        })->name('master.employees');
        
        Route::get('/addemployee', function() {
            if (Auth::user()->role !== 'manager') {
                return redirect('/');
            }
            return view('master.addemployee');
        });
        
        Route::post('/saveemployee', function(Request $request) {
            if (Auth::user()->role !== 'manager') {
                return redirect('/');
            }
            return app(EmployeeController::class)->saveEmployee($request);
        })->name('master.saveemployee');
        
        // New routes for employee management
        Route::get('/editemployee/{id}', function($id) {
            if (Auth::user()->role !== 'manager') {
                return redirect('/');
            }
            return app(EmployeeController::class)->editEmployee($id);
        })->name('master.editemployee');
        
        Route::post('/updateemployee/{id}', function(Request $request, $id) {
            if (Auth::user()->role !== 'manager') {
                return redirect('/');
            }
            return app(EmployeeController::class)->updateEmployee($request, $id);
        })->name('master.updateemployee');
        
        Route::get('/deleteemployee/{id}', function($id) {
            if (Auth::user()->role !== 'manager') {
                return redirect('/');
            }
            return app(EmployeeController::class)->deleteEmployee($id);
        })->name('master.deleteemployee');
        
        // Sales routes
        Route::get('/sale', [SaleController::class, 'index'])->name('sales.index');
        Route::get('/viewreceipt/{id}', [SaleController::class, 'viewReceipt'])->name('sales.receipt');
        
        Route::get('/report', function () {
            if (Auth::user()->role !== 'manager') {
                return redirect('/');
            }
            return view('master.report');
        });

        // Route for viewing sale details
        Route::get('/sale-details/{id}', [SaleController::class, 'viewSaleDetails'])
        ->name('sales.details');
        
        // Discount management routes - managers only
        Route::get('/discounts', [DiscountController::class, 'index'])->name('discounts.index');
        Route::post('/discounts/store', [DiscountController::class, 'store'])->name('discounts.store');
        Route::get('/discounts/product/{productId}', [DiscountController::class, 'getDiscountsForProduct'])->name('discounts.product');
        Route::get('/discounts/{id}', [DiscountController::class, 'show'])->name('discounts.show');
        Route::put('/discounts/{id}', [DiscountController::class, 'update'])->name('discounts.update');
        Route::delete('/discounts/{id}', [DiscountController::class, 'destroy'])->name('discounts.destroy');
        Route::put('/discounts/{id}/stop', [DiscountController::class, 'stopDiscount'])->name('discounts.stop');
        
        // Tax rate management routes - managers only
        Route::get('/tax-rates', [TaxRateController::class, 'index'])->name('tax.index');
        Route::post('/tax-rates/store', [TaxRateController::class, 'store'])->name('tax.store');
        Route::put('/tax-rates/{id}', [TaxRateController::class, 'update'])->name('tax.update');
        Route::delete('/tax-rates/{id}', [TaxRateController::class, 'destroy'])->name('tax.destroy');
        Route::get('/tax-rates/default', [TaxRateController::class, 'getDefaultTaxRate'])->name('tax.default');
    });
});
