<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with('items')->orderBy('created_at', 'desc');

        // Apply date filters if present
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date . ' 00:00:00';
            $endDate = $request->end_date . ' 23:59:59';
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $sales = $query->paginate(20);
        return view('master.sale', compact('sales'));
    }

    /**
     * Display the receipt for a specific sale.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function viewReceipt($id)
    {
        $sale = Sale::with(['items.product'])->findOrFail($id);
        return view('master.viewreceipt', compact('sale'));
    }

    /**
     * Display the details for a specific sale.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function viewSaleDetails($id)
    {
        $sale = Sale::with('items')->findOrFail($id);
        return view('master.sale-details', compact('sale'));
    }
} 