@extends('master.index')

@section('title', 'Sales History')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h1 class="page-title">Sales History</h1>
        </div>

        <!-- Sales Summary Cards -->
        <div class="sales-summary">
            <div class="summary-card total-sales">
                <div class="summary-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="summary-details">
                    <h3>Total Sales</h3>
                    <p class="amount">${{ number_format(\App\Models\Sale::sum('grand_total'), 2) }}</p>
                    <p class="period">{{ \App\Models\Sale::count() }} transactions</p>
                </div>
            </div>

            <div class="summary-card average-sale">
                <div class="summary-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="summary-details">
                    <h3>Average Sale</h3>
                    <p class="amount">${{ \App\Models\Sale::count() > 0 ? number_format(\App\Models\Sale::sum('grand_total') / \App\Models\Sale::count(), 2) : '0.00' }}</p>
                    <p class="period">per transaction</p>
                </div>
            </div>

            <div class="summary-card total-items">
                <div class="summary-icon">
                    <i class="fas fa-shopping-basket"></i>
                </div>
                <div class="summary-details">
                    <h3>Total Items</h3>
                    <p class="amount">{{ \App\Models\SaleItem::count() }}</p>
                    <p class="period">items sold</p>
                </div>
            </div>

            <div class="summary-card payment-methods">
                <div class="summary-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="summary-details">
                    <h3>Payment Methods</h3>
                    <div class="payment-breakdown">
                        @php
                            $paymentMethods = \App\Models\Sale::selectRaw('payment_method, COUNT(*) as count')
                                ->groupBy('payment_method')
                                ->get();
                            $total = \App\Models\Sale::count();
                        @endphp
                        @foreach($paymentMethods as $method)
                            <div class="payment-method-item">
                                <span class="method">{{ $method->payment_method }}</span>
                                <span class="percentage">{{ $total > 0 ? number_format(($method->count / $total) * 100, 1) : 0 }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="sales-card">
            <!-- <div class="sales-header">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search receipts..." class="form-control">
                </div>
                <div class="filter-buttons">
                    <button class="filter-btn active">All</button>
                    <button class="filter-btn">Today</button>
                    <button class="filter-btn">This Week</button>
                    <button class="filter-btn">This Month</button>
                </div>
            </div> -->

            <div class="sales-table-container">
                <table class="sales-table">
                    <thead>
                        <tr>
                            <th>Receipt Code</th>
                            <th>Cashier</th>
                            <th>Date & Time</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Payment Method</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td>{{ $sale->invoice_number }}</td>
                            <td>
                                <div class="cashier-info">
                                    <img src="{{ asset('images/faces/face1.jpg') }}" alt="Cashier" class="cashier-avatar">
                                    <span>{{ $sale->cashier_name }}</span>
                                </div>
                            </td>
                            <td>{{ $sale->created_at->setTimezone('Asia/Phnom_Penh')->format('Y-m-d H:i') }}</td>
                            <td>{{ $sale->items->count() }} items</td>
                            <td>${{ number_format($sale->grand_total, 2) }}</td>
                            <td>
                                @php
                                    $methodClass = strtolower($sale->payment_method) === 'cash' ? 'cash' : 
                                                 (strtolower($sale->payment_method) === 'card' ? 'card' : 'mobile');
                                @endphp
                                <span class="payment-method {{ $methodClass }}">{{ $sale->payment_method }}</span>
                            </td>
                            <td>
                                <a href="{{ route('sales.details', $sale->id) }}" class="btn-view-receipt">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No sales records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-container">
                {{ $sales->links() }}
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Sales Page Styles */
    .content-wrapper {
        padding: 20px 30px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .date-filter {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .date-filter input {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
    }

    .sales-card {
        background: var(--surface-white);
        border-radius: 12px;
        box-shadow: var(--shadow-subtle);
        padding: 25px;
    }

    .sales-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .search-box {
        position: relative;
        width: 300px;
    }

    .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
    }

    .search-box input {
        width: 100%;
        padding: 10px 15px 10px 35px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
    }

    .filter-buttons {
        display: flex;
        gap: 10px;
    }

    .filter-btn {
        padding: 8px 16px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--surface-white);
        color: var(--text-secondary);
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-btn:hover {
        background: var(--light-red);
        color: var(--primary-red);
    }

    .filter-btn.active {
        background: var(--primary-red);
        color: white;
        border-color: var(--primary-red);
    }

    .sales-table-container {
        overflow-x: auto;
        margin-bottom: 20px;
        max-height: calc(100vh - 400px);
        overflow-y: auto;
    }

    .sales-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .sales-table th {
        background: var(--light-red);
        color: var(--text-primary);
        font-weight: 600;
        text-align: left;
        padding: 10px 15px;
        font-size: 13px;
        text-transform: uppercase;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .sales-table td {
        padding: 8px 15px;
        border-bottom: 1px solid var(--border-color);
        font-size: 14px;
    }

    .sales-table tr:hover {
        background-color: var(--light-red);
    }

    .cashier-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .cashier-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
    }

    .payment-method {
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
    }

    .payment-method.cash {
        background: rgba(76, 175, 80, 0.1);
        color: #4CAF50;
    }

    .payment-method.card {
        background: rgba(33, 150, 243, 0.1);
        color: #2196F3;
    }

    .payment-method.mobile {
        background: rgba(156, 39, 176, 0.1);
        color: #9C27B0;
    }

    .btn-view-receipt {
        padding: 6px 12px;
        background: var(--light-red);
        color: var(--primary-red);
        border: none;
        border-radius: 6px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-view-receipt:hover {
        background: var(--primary-red);
        color: white;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: var(--surface-white);
        border-radius: 12px;
        width: 100%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        font-size: 18px;
        color: var(--text-primary);
        margin: 0;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 20px;
        color: var(--text-secondary);
        cursor: pointer;
    }

    .modal-body {
        padding: 20px;
    }

    .receipt-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .receipt-info h4 {
        margin: 0 0 5px 0;
        color: var(--text-primary);
    }

    .receipt-info p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 14px;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .items-table th {
        background: var(--light-red);
        padding: 10px;
        text-align: left;
        font-size: 13px;
        color: var(--text-primary);
    }

    .items-table td {
        padding: 10px;
        border-bottom: 1px solid var(--border-color);
        font-size: 14px;
    }

    .receipt-summary {
        background: var(--light-red);
        padding: 15px;
        border-radius: 8px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .summary-row.total {
        font-weight: 600;
        font-size: 16px;
        color: var(--primary-red);
        border-top: 1px solid var(--border-color);
        padding-top: 10px;
        margin-top: 10px;
    }

    .payment-info {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid var(--border-color);
    }

    .payment-info span {
        display: block;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .modal-footer {
        padding: 15px 20px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .content-wrapper {
            padding: 15px;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .header-actions {
            flex-direction: column;
        }

        .date-filter {
            width: 100%;
        }

        .date-filter input {
            flex: 1;
        }

        .search-box {
            width: 100%;
        }

        .filter-buttons {
            width: 100%;
            overflow-x: auto;
            padding-bottom: 5px;
        }

        .sales-table th,
        .sales-table td {
            padding: 10px;
            font-size: 13px;
        }

        .modal-content {
            margin: 15px;
            max-height: calc(100vh - 30px);
        }
    }

    .btn,
    .btn-primary,
    .btn-secondary,
    .export-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        outline: none;
        box-shadow: none;
    }

    .btn-primary,
    .export-btn {
        background: var(--primary-red);
        color: #fff;
        border: 1px solid var(--primary-red);
    }
    .btn-primary:hover,
    .export-btn:hover {
        background: var(--primary-red-dark);
        color: #fff;
    }

    .btn-secondary {
        background: var(--light-red);
        color: var(--primary-red);
        border: 1px solid var(--primary-red);
    }
    .btn-secondary:hover {
        background: var(--primary-red);
        color: #fff;
    }

    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        padding: 10px 0;
        background: var(--surface-white);
        border-top: 1px solid var(--border-color);
    }

    .pagination-container nav {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
    }

    .pagination-container .relative {
        padding: 5px 12px;
        font-size: 14px;
        margin: 0 2px;
    }

    .pagination-container span[aria-current="page"] .relative {
        background: var(--primary-red);
        color: white;
    }

    /* Loading Spinner */
    .loading-spinner {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px;
        color: var(--primary-red);
        font-size: 16px;
    }
    
    .loading-spinner i {
        margin-right: 10px;
        font-size: 24px;
    }
    
    .text-center {
        text-align: center;
    }

    /* Sales Summary Styles */
    .sales-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }

    .summary-card {
        background: var(--surface-white);
        border-radius: 12px;
        padding: 20px;
        box-shadow: var(--shadow-subtle);
        display: flex;
        align-items: flex-start;
        gap: 15px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .summary-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .total-sales .summary-icon {
        background: rgba(76, 175, 80, 0.1);
        color: #4CAF50;
    }

    .average-sale .summary-icon {
        background: rgba(33, 150, 243, 0.1);
        color: #2196F3;
    }

    .total-items .summary-icon {
        background: rgba(156, 39, 176, 0.1);
        color: #9C27B0;
    }

    .payment-methods .summary-icon {
        background: rgba(255, 152, 0, 0.1);
        color: #FF9800;
    }

    .summary-details {
        flex: 1;
    }

    .summary-details h3 {
        margin: 0 0 8px 0;
        font-size: 14px;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .summary-details .amount {
        margin: 0 0 4px 0;
        font-size: 24px;
        font-weight: 600;
        color: var(--text-primary);
    }

    .summary-details .period {
        margin: 0;
        font-size: 13px;
        color: var(--text-secondary);
    }

    .payment-breakdown {
        margin-top: 8px;
    }

    .payment-method-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        color: var(--text-secondary);
        margin-bottom: 4px;
    }

    .payment-method-item .method {
        font-weight: 500;
    }

    .payment-method-item .percentage {
        color: var(--primary-red);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter buttons functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Apply filtering logic here based on the button clicked
                const filterType = this.textContent.trim().toLowerCase();
                filterSales(filterType);
            });
        });
        
        // Function to filter sales based on time period
        function filterSales(filterType) {
            const rows = document.querySelectorAll('.sales-table tbody tr');
            const now = new Date();
            let totalSales = 0;
            let totalItems = 0;
            let transactionCount = 0;
            let paymentMethods = {};
            
            rows.forEach(row => {
                // Skip the "No sales records found" row
                if (row.cells.length === 1) return;
                
                const dateCell = row.cells[2];
                const dateStr = dateCell.textContent.trim();
                const date = new Date(dateStr);
                
                let showRow = true;
                
                if (filterType === 'today') {
                    showRow = date.toDateString() === now.toDateString();
                } else if (filterType === 'this week') {
                    const weekStart = new Date(now);
                    weekStart.setDate(now.getDate() - now.getDay());
                    const weekEnd = new Date(weekStart);
                    weekEnd.setDate(weekStart.getDate() + 6);
                    
                    showRow = date >= weekStart && date <= weekEnd;
                } else if (filterType === 'this month') {
                    showRow = date.getMonth() === now.getMonth() && 
                             date.getFullYear() === now.getFullYear();
                }
                
                row.style.display = showRow || filterType === 'all' ? '' : 'none';

                // Calculate totals for visible rows
                if (showRow || filterType === 'all') {
                    const amount = parseFloat(row.cells[4].textContent.replace('$', '').replace(',', ''));
                    const items = parseInt(row.cells[3].textContent);
                    const paymentMethod = row.cells[5].querySelector('.payment-method').textContent.trim();

                    totalSales += amount;
                    totalItems += items;
                    transactionCount++;

                    // Count payment methods
                    paymentMethods[paymentMethod] = (paymentMethods[paymentMethod] || 0) + 1;
                }
            });
            
            // Update summary cards
            updateSummaryCards(totalSales, totalItems, transactionCount, paymentMethods);
            
            // Show "No results" message if all rows are hidden
            let allHidden = true;
            rows.forEach(row => {
                if (row.style.display !== 'none' && row.cells.length > 1) {
                    allHidden = false;
                }
            });
            
            // Get or create the no results row
            let noResultsRow = document.querySelector('.no-results-row');
            if (!noResultsRow) {
                noResultsRow = document.createElement('tr');
                noResultsRow.className = 'no-results-row';
                noResultsRow.innerHTML = '<td colspan="7" class="text-center">No sales found for the selected period</td>';
                document.querySelector('.sales-table tbody').appendChild(noResultsRow);
            }
            
            noResultsRow.style.display = allHidden ? '' : 'none';
        }

        // Function to update summary cards
        function updateSummaryCards(totalSales, totalItems, transactionCount, paymentMethods) {
            // Update total sales
            const totalSalesAmount = document.querySelector('.total-sales .amount');
            const totalSalesPeriod = document.querySelector('.total-sales .period');
            totalSalesAmount.textContent = `$${totalSales.toFixed(2)}`;
            totalSalesPeriod.textContent = `${transactionCount} transactions`;

            // Update average sale
            const averageSaleAmount = document.querySelector('.average-sale .amount');
            averageSaleAmount.textContent = transactionCount > 0 ? 
                `$${(totalSales / transactionCount).toFixed(2)}` : '$0.00';

            // Update total items
            const totalItemsAmount = document.querySelector('.total-items .amount');
            totalItemsAmount.textContent = totalItems;

            // Update payment methods breakdown
            const paymentBreakdown = document.querySelector('.payment-breakdown');
            let paymentMethodsHtml = '';
            
            for (const [method, count] of Object.entries(paymentMethods)) {
                const percentage = ((count / transactionCount) * 100).toFixed(1);
                paymentMethodsHtml += `
                    <div class="payment-method-item">
                        <span class="method">${method}</span>
                        <span class="percentage">${percentage}%</span>
                    </div>
                `;
            }
            
            paymentBreakdown.innerHTML = paymentMethodsHtml;
        }

        // Date filter functionality
        const startDate = document.getElementById('start-date');
        const endDate = document.getElementById('end-date');

        function filterByDateRange() {
            const start = startDate.value ? new Date(startDate.value) : null;
            const end = endDate.value ? new Date(endDate.value) : null;
            
            if (!start || !end) return;

            const rows = document.querySelectorAll('.sales-table tbody tr');
            let totalSales = 0;
            let totalItems = 0;
            let transactionCount = 0;
            let paymentMethods = {};

            rows.forEach(row => {
                if (row.cells.length === 1) return;

                const dateCell = row.cells[2];
                const dateStr = dateCell.textContent.trim();
                const date = new Date(dateStr);

                const showRow = (!start || date >= start) && (!end || date <= end);
                row.style.display = showRow ? '' : 'none';

                if (showRow) {
                    const amount = parseFloat(row.cells[4].textContent.replace('$', '').replace(',', ''));
                    const items = parseInt(row.cells[3].textContent);
                    const paymentMethod = row.cells[5].querySelector('.payment-method').textContent.trim();

                    totalSales += amount;
                    totalItems += items;
                    transactionCount++;
                    paymentMethods[paymentMethod] = (paymentMethods[paymentMethod] || 0) + 1;
                }
            });

            updateSummaryCards(totalSales, totalItems, transactionCount, paymentMethods);
        }

        if (startDate && endDate) {
            startDate.addEventListener('change', filterByDateRange);
            endDate.addEventListener('change', filterByDateRange);
        }

        // Export functionality
        document.querySelector('.export-btn')?.addEventListener('click', function() {
            const visibleRows = Array.from(document.querySelectorAll('.sales-table tbody tr'))
                .filter(row => row.style.display !== 'none' && row.cells.length > 1);

            if (visibleRows.length === 0) {
                alert('No data to export');
                return;
            }

            let csv = 'Receipt Code,Cashier,Date & Time,Items,Total Amount,Payment Method\n';
            
            visibleRows.forEach(row => {
                const cells = row.cells;
                const receiptCode = cells[0].textContent.trim();
                const cashier = cells[1].querySelector('.cashier-info span').textContent.trim();
                const dateTime = cells[2].textContent.trim();
                const items = cells[3].textContent.trim();
                const amount = cells[4].textContent.trim();
                const paymentMethod = cells[5].querySelector('.payment-method').textContent.trim();

                csv += `${receiptCode},"${cashier}",${dateTime},${items},${amount},${paymentMethod}\n`;
            });

            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `sales_report_${new Date().toISOString().split('T')[0]}.csv`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        });
    });
</script>
@endpush
