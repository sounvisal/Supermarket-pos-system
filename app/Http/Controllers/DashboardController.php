<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Products;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get today's date range
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // Today's sales
        $todaySales = Sale::whereDate('created_at', $today)->sum('grand_total');
        $yesterdaySales = Sale::whereDate('created_at', $yesterday)->sum('grand_total');
        $salesChange = $yesterdaySales != 0 ? (($todaySales - $yesterdaySales) / $yesterdaySales) * 100 : 100;

        // Total products and new products today
        $totalProducts = Products::count();
        $newProductsToday = Products::whereDate('created_at', $today)->count();

        // Low stock products
        $lowStockProducts = Products::where('qty', '<=', 30)->count();
        $previousLowStock = Products::where('qty', '<=', 30)
            ->whereDate('updated_at', '<', $today)->count();
        $lowStockChange = $previousLowStock != 0 ? (($lowStockProducts - $previousLowStock) / $previousLowStock) * 100 : 0;

        // Monthly revenue
        $monthlyRevenue = Sale::whereMonth('created_at', now()->month)->sum('grand_total');
        $lastMonthRevenue = Sale::whereMonth('created_at', now()->subMonth()->month)->sum('grand_total');
        $revenueChange = $lastMonthRevenue != 0 ? (($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 100;

        // Get low stock items for table
        $lowStockItems = Products::where('qty', '<=', 30)
            ->select('product_name', 'category', 'qty')
            ->orderBy('qty')
            ->limit(4)
            ->get();

        // Get recent sales for table
        $recentSales = Sale::with(['user'])
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // Get employee count
        $totalStaff = User::count();

        // Get cashier performance for today
        $cashierPerformance = Sale::whereDate('created_at', $today)
            ->select(
                'cashier_name',
                DB::raw('COUNT(*) as transactions'),
                DB::raw('SUM(grand_total) as total_sales'),
                DB::raw('AVG(grand_total) as average_sale')
            )
            ->groupBy('cashier_name')
            ->orderBy('total_sales', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($cashier) {
                // Calculate performance level based on total sales
                $performance = 'medium';
                if ($cashier->total_sales > 3000) {
                    $performance = 'high';
                } elseif ($cashier->total_sales < 2000) {
                    $performance = 'low';
                }
                
                return [
                    'name' => $cashier->cashier_name,
                    'transactions' => $cashier->transactions,
                    'total_sales' => $cashier->total_sales,
                    'average_sale' => $cashier->average_sale,
                    'performance' => $performance
                ];
            });

        // Get weekly revenue data for chart
        $weeklyRevenue = Sale::whereBetween('created_at', [now()->subDays(6), now()])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(grand_total) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('D'),
                    'total' => $item->total
                ];
            });

        // Get payment method statistics
        $paymentStats = Sale::select('payment_method', DB::raw('COUNT(*) as count'))
            ->whereMonth('created_at', now()->month)
            ->groupBy('payment_method')
            ->get()
            ->map(function ($item) use ($monthlyRevenue) {
                return [
                    'method' => $item->payment_method,
                    'count' => $item->count,
                    'percentage' => round(($item->count / Sale::whereMonth('created_at', now()->month)->count()) * 100, 1)
                ];
            });

        // Get staff grouped by roles
        $staffByRole = [
            'managers' => User::where('role', 'manager')->get(),
            'cashiers' => User::where('role', 'cashier')->get(),
            'stock' => User::where('role', 'stock')->get()
        ];

        return view('master.index', compact(
            'todaySales',
            'salesChange',
            'totalProducts',
            'newProductsToday',
            'lowStockProducts',
            'lowStockChange',
            'monthlyRevenue',
            'revenueChange',
            'lowStockItems',
            'recentSales',
            'totalStaff',
            'cashierPerformance',
            'weeklyRevenue',
            'paymentStats',
            'staffByRole'
        ));
    }
} 