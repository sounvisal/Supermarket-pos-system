@extends('master.index')

@section('title', 'Receipt Details')

@section('content')
<div class="content-wrapper">
    <div class="receipt">
        <div class="receipt-header">
            <div class="invoice-number">
                <span class="label">Invoice</span>
                <h2>#{{ $sale->invoice_number }}</h2>
            </div>
            
            <div class="cashier-info">
                <div class="cashier-avatar">
                    <img src="{{ asset('images/faces/face1.jpg') }}" alt="Cashier">
                </div>
                <div class="cashier-details">
                    <h4>{{ $sale->cashier_name }}</h4>
                    <span class="role">Cashier</span>
                </div>
            </div>
        </div>
        
        <div class="receipt-meta">
            <div class="date">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                <span>{{ $sale->created_at->setTimezone('Asia/Phnom_Penh')->format('Y-m-d H:i:s') }}</span>
            </div>
        </div>

        <div class="receipt-items">
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $item)
                    <tr>
                        <td class="item-name">{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->unit_price, 2) }}</td>
                        <td class="item-total">${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="receipt-summary">
            <div class="summary-row">
                <span>Subtotal</span>
                <span>${{ number_format($sale->subtotal, 2) }}</span>
            </div>
            <div class="summary-row">
                <span>Tax (6%)</span>
                <span>${{ number_format($sale->tax_amount, 2) }}</span>
            </div>
            @if($sale->discount_amount > 0)
            <div class="summary-row discount">
                <span>Discount</span>
                <span>-${{ number_format($sale->discount_amount, 2) }}</span>
            </div>
            @endif
            <div class="summary-row total">
                <span>Total</span>
                <span>${{ number_format($sale->grand_total, 2) }}</span>
            </div>
        </div>
        
        <div class="payment-info">
            <div class="payment-method {{ strtolower($sale->payment_method) }}">
                <span>{{ $sale->payment_method }} Payment</span>
            </div>
        </div>

        <div class="receipt-actions">
            <button onclick="window.print()" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                Print Receipt
            </button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Back to Sales
            </a>
        </div>
    </div>
</div>

<style>
    :root {
        --color-primary: #5469d4;
        --color-success: #0ca678;
        --color-info: #3498db;
        --color-warning: #f39c12;
        --color-light: #f8f9fa;
        --color-dark: #212529;
        --color-gray: #6c757d;
        --color-gray-light: #e9ecef;
        --border-radius: 8px;
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.1);
        --font-main: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    .content-wrapper {
        background-color: #f7fafc;
        padding: 2rem 1rem;
        min-height: 100vh;
        font-family: var(--font-main);
        color: var(--color-dark);
    }

    .receipt {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .receipt-header {
        padding: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--color-gray-light);
    }

    .invoice-number .label {
        font-size: 0.875rem;
        color: var(--color-gray);
        display: block;
        margin-bottom: 0.25rem;
    }

    .invoice-number h2 {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--color-primary);
    }

    .cashier-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .cashier-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        overflow: hidden;
        background: var(--color-gray-light);
    }

    .cashier-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cashier-details h4 {
        margin: 0;
        font-weight: 600;
        font-size: 1rem;
    }

    .cashier-details .role {
        font-size: 0.825rem;
        color: var(--color-gray);
    }

    .receipt-meta {
        padding: 1rem 2rem;
        border-bottom: 1px solid var(--color-gray-light);
    }

    .date {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: var(--color-gray);
    }

    .receipt-items {
        padding: 1.5rem 2rem;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
    }

    .items-table th {
        text-align: left;
        padding: 0.75rem 0;
        font-weight: 500;
        font-size: 0.875rem;
        color: var(--color-gray);
        border-bottom: 1px solid var(--color-gray-light);
    }

    .items-table td {
        padding: 1rem 0;
        font-size: 0.9375rem;
        border-bottom: 1px solid var(--color-gray-light);
    }

    .items-table tr:last-child td {
        border-bottom: none;
    }

    .item-name {
        font-weight: 500;
    }

    .item-total {
        font-weight: 500;
    }

    .receipt-summary {
        background-color: var(--color-light);
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--color-gray-light);
        border-bottom: 1px solid var(--color-gray-light);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        font-size: 0.9375rem;
    }

    .summary-row.total {
        margin-top: 0.5rem;
        padding-top: 0.75rem;
        border-top: 1px solid var(--color-gray-light);
        font-weight: 600;
        font-size: 1.125rem;
    }

    .summary-row.discount span:last-child {
        color: #e53e3e;
    }

    .payment-info {
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: flex-end;
    }

    .payment-method {
        display: inline-flex;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .payment-method.cash {
        background-color: rgba(12, 166, 120, 0.1);
        color: var(--color-success);
    }

    .payment-method.card {
        background-color: rgba(52, 152, 219, 0.1);
        color: var(--color-info);
    }

    .payment-method.mobile {
        background-color: rgba(156, 39, 176, 0.1);
        color: #9C27B0;
    }

    .receipt-actions {
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: center;
        gap: 1rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 500;
        font-size: 0.9375rem;
        transition: all 0.2s;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary {
        background-color: var(--color-primary);
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background-color: #4559b9;
    }

    .btn-secondary {
        background-color: var(--color-gray);
        color: white;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    @media print {
        .content-wrapper {
            background: none;
            padding: 0;
        }
        
        .receipt {
            box-shadow: none;
            max-width: 100%;
        }
        
        .receipt-actions {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .receipt-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1.5rem;
        }
        
        .items-table {
            font-size: 0.875rem;
        }
        
        .receipt-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection