@extends('master.index')

@section('title', 'Receipt Details')

@section('content')
<div class="content-wrapper">
    <div class="receipt-container">
        <div class="receipt-header">
            <div class="company-info">
                <h1>Supermarket Receipt</h1>
                <p>123 Market Street</p>
                <p>City, State 12345</p>
                <p>Tel: (555) 123-4567</p>
            </div>
            <div class="receipt-info">
                <h2>Invoice #{{ $sale->invoice_number }}</h2>                <p>Date: {{ $sale->created_at->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i:s A') }}</p>            </div>
        </div>

        <div class="receipt-body">
            <div class="cashier-info">
                <div class="cashier-details">
                    <img src="{{ asset('images/faces/face1.jpg') }}" alt="Cashier" class="cashier-avatar">
                    <div class="cashier-text">
                        <h3>{{ $sale->cashier_name }}</h3>
                        <p>Cashier</p>
                    </div>
                </div>
            </div>

            <div class="items-section">
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $item)
                        <tr>
                            <td>
                                <div class="item-details">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}" class="item-image">
                                    @endif
                                    <span>{{ $item->product_name }}</span>
                                </div>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->unit_price, 2) }}</td>
                            <td>${{ number_format($item->subtotal, 2) }}</td>
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

            <div class="payment-details">
                <div class="payment-method">
                    <span class="method-label">Payment Method:</span>
                    <span class="method-value {{ strtolower($sale->payment_method) }}">
                        {{ $sale->payment_method }}
                    </span>
                </div>
                @if($sale->payment_method === 'Card')
                <div class="card-details">
                    <p>Card ending in: **** **** **** {{ substr($sale->card_number, -4) }}</p>
                    <p>Transaction ID: {{ $sale->transaction_id }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .content-wrapper {
        padding: 30px;
        background: #f8f9fa;
    }

    .receipt-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
        padding: 40px;
    }

    .receipt-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .company-info h1 {
        font-size: 24px;
        color: var(--primary-red);
        margin: 0 0 10px 0;
    }

    .company-info p {
        margin: 0;
        color: #666;
        font-size: 14px;
        line-height: 1.4;
    }

    .receipt-info h2 {
        font-size: 20px;
        color: #333;
        margin: 0 0 10px 0;
    }

    .receipt-info p {
        margin: 0;
        color: #666;
        font-size: 14px;
    }

    .cashier-info {
        margin-bottom: 30px;
    }

    .cashier-details {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .cashier-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .cashier-text h3 {
        margin: 0;
        font-size: 16px;
        color: #333;
    }

    .cashier-text p {
        margin: 5px 0 0 0;
        color: #666;
        font-size: 14px;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    .items-table th {
        background: #f8f9fa;
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .items-table td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        color: #444;
        font-size: 14px;
    }

    .item-details {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .item-image {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 6px;
    }

    .receipt-summary {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        color: #444;
        font-size: 14px;
    }

    .summary-row.discount {
        color: #dc3545;
    }

    .summary-row.total {
        border-top: 2px solid #ddd;
        margin-top: 10px;
        padding-top: 15px;
        font-weight: 600;
        font-size: 16px;
        color: #333;
    }

    .payment-details {
        margin-bottom: 30px;
        padding: 20px;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
    }

    .payment-method {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .method-label {
        font-weight: 500;
        color: #444;
    }

    .method-value {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
    }

    .method-value.cash {
        background: rgba(76, 175, 80, 0.1);
        color: #4CAF50;
    }

    .method-value.card {
        background: rgba(33, 150, 243, 0.1);
        color: #2196F3;
    }

    .method-value.mobile {
        background: rgba(156, 39, 176, 0.1);
        color: #9C27B0;
    }

    .card-details {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #eee;
    }

    .card-details p {
        margin: 5px 0;
        font-size: 14px;
        color: #666;
    }

    .receipt-footer {
        text-align: center;
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .barcode {
        text-align: center;
        margin-bottom: 20px;
    }

    .barcode-container {
        display: inline-flex;
        gap: 2px;
        background: white;
        padding: 10px 15px;
        border-radius: 4px;
    }

    .barcode-line {
        position: relative;
        font-size: 0;
        min-width: 2px;
        height: 60px;
        background: #333;
    }

    .barcode-line::after {
        content: attr(data-digit);
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 12px;
        color: #333;
    }

    .barcode-number {
        margin: 25px 0 0 0;
        font-size: 14px;
        color: #666;
        font-family: monospace;
        letter-spacing: 2px;
    }

    .thank-you {
        font-size: 16px;
        color: #666;
        font-style: italic;
    }

    .receipt-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 30px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
    }

    .btn-primary {
        background: var(--primary-red);
        color: white;
    }

    .btn-secondary {
        background: var(--light-red);
        color: var(--primary-red);
    }

    .btn-outline {
        background: transparent;
        border: 1px solid #ddd;
        color: #666;
        text-decoration: none;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    @media print {
        .content-wrapper {
            padding: 0;
            background: white;
        }

        .receipt-container {
            box-shadow: none;
            padding: 20px;
        }

        .receipt-actions {
            display: none;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Print functionality
        document.getElementById('printReceipt').addEventListener('click', function() {
            window.print();
        });

        // Download PDF functionality
        document.getElementById('downloadPDF').addEventListener('click', function() {
            // You'll need to implement the PDF download functionality
            // This could be done using a library like html2pdf.js or by making an AJAX call to a backend endpoint
            alert('PDF download functionality will be implemented');
        });
    });
</script>
@endpush
