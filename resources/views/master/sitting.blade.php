@extends('master.index')

@section('title', 'Discount Management')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h1 class="page-title">Discount Management</h1>
        </div>

        <div class="settings-content">
            <!-- Section 1: Products with Discount -->
            <div class="settings-card">
                <div class="card-title">
                    <h3>Products with Discount</h3>
                    <div class="card-actions">
                        <input type="text" class="search-input" placeholder="Search products...">
                    </div>
                </div>
                
                <div class="product-discount-grid">
                    @foreach($discounts ?? [] as $discount)
                    <div class="product-discount-card">
                        <div class="discount-badge">-{{ $discount->discount_percentage }}%</div>
                        <div class="product-image">
                            <i class="fas {{ $discount->product ? 'fa-box' : 'fa-tags' }}"></i>
                        </div>
                        <div class="product-details">
                            <h4 class="product-name">
                                @if($discount->product)
                                    {{ $discount->product->product_name }}
                                @else
                                    {{ $discount->category }} (Category)
                                @endif
                            </h4>
                            <div class="price-container">
                                @if($discount->product)
                                    <span class="original-price">${{ number_format($discount->product->price, 2) }}</span>
                                    <span class="discounted-price">${{ number_format($discount->product->price * (1 - $discount->discount_percentage/100), 2) }}</span>
                                @else
                                    <span class="category-discount">{{ $discount->discount_percentage }}% off all {{ $discount->category }} products</span>
                                @endif
                            </div>
                            <div class="discount-dates">
                                <span>Valid: {{ $discount->start_date->format('M d, Y') }} - 
                                    @if($discount->end_date)
                                        {{ $discount->end_date->format('M d, Y') }}
                                    @else
                                        No End Date
                                    @endif
                                </span>
                            </div>
                            <div class="product-actions">
                                <button class="btn-icon edit-discount-btn" data-discount-id="{{ $discount->id }}"><i class="fas fa-edit"></i></button>
                                <button class="btn-icon delete-discount-btn" data-discount-id="{{ $discount->id }}"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="pagination">
                    {{ $discounts ?? '' }}
                </div>
            </div>
            
            <!-- Section 2: Add New Discount Product -->
            <div class="settings-card">
                <div class="card-title">
                    <h3>Add New Discount Product</h3>
                </div>
                
                <form id="add-discount-form" action="{{ route('discounts.store') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="discount-type">Discount Type</label>
                            <select id="discount-type" name="discount_type" class="form-select" required>
                                <option value="product" selected>Product Specific</option>
                                <option value="category">Category Wide</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row product-selection">
                        <div class="form-group flex-2">
                            <label for="product-search">Search Product</label>
                            <div class="search-input-container">
                                <input type="text" id="product-search" class="form-input" placeholder="Type to search products...">
                                <input type="hidden" id="product-select" name="product_id" required>
                                <div class="search-results-dropdown" id="product-search-results"></div>
                            </div>
                            <div id="selected-product-display" class="selected-product-display"></div>
                        </div>
                    </div>
                    
                    <div class="form-row category-selection" style="display: none;">
                        <div class="form-group flex-2">
                            <label for="category-select">Select Category</label>
                            <select id="category-select" name="category" class="form-select">
                                @if(isset($categories) && count($categories) > 0)
                                    @foreach($categories as $key => $category)
                                        <option value="{{ $category }}" {{ $key === 0 ? 'selected' : '' }}>{{ $category }}</option>
                                    @endforeach
                                @else
                                    <option value="" disabled>No categories available</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="discount-percent">Discount Percentage (%)</label>
                            <input type="number" id="discount-percent" name="discount_percentage" class="form-input" min="0" max="100" step="0.1" value="10" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group half">
                            <label for="start-date">Start Date</label>
                            <input type="date" id="start-date" name="start_date" class="form-input" value="{{ now()->setTimezone('Asia/Phnom_Penh')->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group half">
                            <label for="end-date">End Date</label>
                            <input type="date" id="end-date" name="end_date" class="form-input">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description (Optional)</label>
                        <textarea id="description" name="description" class="form-input" rows="2"></textarea>
                    </div>
                    
                    <div class="form-group switch-group">
                        <label for="discount-active-switch">Active</label>
                        <label class="switch">
                            <input type="checkbox" id="discount-active-switch" name="is_active" checked>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Discount
                        </button>
                    </div>
                </form>
            </div>

            <!-- Global Tax Settings -->
            <div class="settings-card">
                <div class="card-title">
                    <h3>Global Tax Settings</h3>
                </div>
                <form id="tax-form" action="{{ route('tax.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="default-tax">Default Tax Rate (%)</label>
                        <input type="number" id="default-tax" name="rate" class="form-input" min="0" max="100" step="0.01" value="{{ $defaultTaxRate->rate ?? 10.00 }}">
                    </div>
                    <div class="form-group">
                        <label for="tax-name">Tax Name</label>
                        <input type="text" id="tax-name" name="name" class="form-input" value="{{ $defaultTaxRate->name ?? 'Default Tax Rate' }}" required>
                    </div>
                    <div class="form-group switch-group">
                        <label for="apply-tax-default">Apply tax to all products by default</label>
                        <label class="switch">
                            <input type="checkbox" id="apply-tax-default" name="apply_to_all_products" {{ isset($defaultTaxRate) && $defaultTaxRate->apply_to_all_products ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="form-group switch-group">
                        <label for="is-default">Set as default tax rate</label>
                        <label class="switch">
                            <input type="checkbox" id="is-default" name="is_default" checked>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Tax Settings
                        </button>
                    </div>
                </form>
            </div>

            <!-- Edit Discount Modal -->
            <div class="modal" id="edit-discount-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Edit Product Discount</h3>
                        <button class="close-modal"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-discount-form">
                            <input type="hidden" id="edit-discount-id" name="discount_id">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Product/Category</label>
                                <p class="product-name-display" id="edit-product-name"></p>
                            </div>
                            <div class="form-group">
                                <label for="edit-discount-percentage">Discount Percentage (%)</label>
                                <input type="number" id="edit-discount-percentage" name="discount_percentage" class="form-input" min="0" max="100" step="0.1" value="15">
                            </div>
                            <div class="form-row">
                                <div class="form-group half">
                                    <label for="edit-start-date">Start Date</label>
                                    <input type="date" id="edit-start-date" name="start_date" class="form-input">
                                </div>
                                <div class="form-group half">
                                    <label for="edit-end-date">End Date</label>
                                    <input type="date" id="edit-end-date" name="end_date" class="form-input">
                                </div>
                            </div>
                            <div class="form-group switch-group">
                                <label for="edit-discount-active">Active</label>
                                <label class="switch">
                                    <input type="checkbox" id="edit-discount-active" name="is_active" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" id="cancel-edit">Cancel</button>
                        <button class="btn btn-primary" id="save-edit">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Product Search Styles */
    .search-input-container {
        position: relative;
    }
    
    .search-results-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        max-height: 250px;
        overflow-y: auto;
        background-color: #fff;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-small);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        z-index: 100;
        display: none;
    }
    
    .search-results-dropdown.active {
        display: block;
    }
    
    .search-result-item {
        padding: 10px 15px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
        transition: background-color 0.2s;
    }
    
    .search-result-item:hover {
        background-color: #f5f5f5;
    }
    
    .search-result-item:last-child {
        border-bottom: none;
    }
    
    .search-result-name {
        font-weight: 500;
        margin-bottom: 3px;
    }
    
    .search-result-price {
        font-size: 12px;
        color: var(--primary-red);
    }
    
    .selected-product-display {
        margin-top: 10px;
        padding: 10px 15px;
        background-color: #f8f9fa;
        border-radius: var(--border-radius-small);
        border: 1px solid #e9ecef;
        font-weight: 500;
        display: none;
    }
    
    .selected-product-display.active {
        display: block;
    }
    
    /* Settings Page Styles */
    .content-wrapper {
        padding: 20px 30px;
    }
    
    .page-header {
        margin-bottom: 25px;
    }
    
    .settings-content {
        background-color: var(--background-light);
    }
    
    /* Settings Sections */
    .settings-section {
        display: block;
    }
    
    /* Cards */
    .settings-card {
        background-color: var(--surface-white);
        border-radius: var(--border-radius-medium);
        box-shadow: var(--shadow-subtle);
        padding: 25px;
        margin-bottom: 25px;
    }
    
    .card-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .card-title h3 {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-primary);
    }
    
    /* Forms */
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .form-group.half {
        flex: 1;
    }
    
    .form-group.flex-2 {
        flex: 2;
    }
    
    label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 8px;
        color: var(--text-primary);
    }
    
    .form-input, .form-select {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-small);
        font-size: 14px;
        color: var(--text-primary);
        background-color: var(--surface-white);
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    
    .form-input:focus, .form-select:focus {
        border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(185, 69, 23, 0.2);
        outline: none;
    }
    
    /* Search Input */
    .search-input {
        padding: 8px 15px;
        border: 1px solid var(--border-color);
        border-radius: 20px;
        font-size: 14px;
        width: 250px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%237A6158' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        padding-right: 40px;
    }
    
    /* Product Discount Grid */
    .product-discount-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .product-discount-card {
        position: relative;
        background-color: var(--surface-white);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-medium);
        overflow: hidden;
        box-shadow: var(--shadow-subtle);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .product-discount-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-medium);
    }
    
    .discount-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: var(--accent-orange);
        color: white;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 14px;
    }
    
    .product-image {
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--light-red);
        color: var(--primary-red-dark);
        font-size: 50px;
    }
    
    .product-details {
        padding: 15px;
    }
    
    .product-name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--text-primary);
    }
    
    .price-container {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }
    
    .original-price {
        text-decoration: line-through;
        color: var(--text-secondary);
        font-size: 14px;
    }
    
    .discounted-price {
        font-weight: 600;
        color: var(--primary-red-dark);
        font-size: 18px;
    }
    
    .discount-dates {
        font-size: 12px;
        color: var(--text-secondary);
        margin-bottom: 12px;
    }
    
    .product-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }
    
    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-top: 20px;
    }
    
    .pagination-btn {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-color);
        background-color: var(--surface-white);
        border-radius: var(--border-radius-small);
        color: var(--text-secondary);
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .pagination-btn.active {
        background-color: var(--primary-red);
        color: white;
        border-color: var(--primary-red);
    }
    
    .pagination-btn:hover:not(.active):not([disabled]) {
        background-color: var(--light-red);
        color: var(--primary-red-dark);
    }
    
    .pagination-btn[disabled] {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Buttons */
    .btn {
        padding: 10px 20px;
        border-radius: var(--border-radius-small);
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        border: none;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn i {
        margin-right: 8px;
    }
    
    .btn-primary {
        background-color: var(--primary-red);
        color: white;
    }
    
    .btn-primary:hover {
        background-color: var(--primary-red-dark);
    }
    
    .btn-secondary {
        background-color: var(--border-color);
        color: var(--text-secondary);
    }
    
    .btn-secondary:hover {
        background-color: #dfe3e7;
    }
    
    .btn-sm {
        padding: 6px 12px;
        font-size: 13px;
    }
    
    .form-actions {
        margin-top: 25px;
        display: flex;
        justify-content: flex-end;
    }
    
    /* Toggle Switch */
    .switch-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }
    
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
    }
    
    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
    }
    
    input:checked + .slider {
        background-color: var(--primary-red);
    }
    
    input:focus + .slider {
        box-shadow: 0 0 1px var(--primary-red);
    }
    
    input:checked + .slider:before {
        transform: translateX(26px);
    }
    
    .slider.round {
        border-radius: 34px;
    }
    
    .slider.round:before {
        border-radius: 50%;
    }
    
    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    
    .modal.active {
        display: flex;
    }
    
    .modal-content {
        background-color: var(--surface-white);
        border-radius: var(--border-radius-medium);
        width: 100%;
        max-width: 500px;
        box-shadow: var(--shadow-medium);
        animation: modalFadeIn 0.3s;
    }
    
    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        border-bottom: 1px solid var(--border-color);
    }
    
    .modal-header h3 {
        font-size: 18px;
        color: var(--text-primary);
        font-weight: 600;
    }
    
    .close-modal {
        background: none;
        border: none;
        font-size: 18px;
        color: var(--text-secondary);
        cursor: pointer;
    }
    
    .modal-body {
        padding: 25px;
    }
    
    .modal-footer {
        padding: 15px 25px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    
    .product-name-display {
        font-weight: 600;
        font-size: 16px;
        color: var(--text-primary);
        padding: 10px 0;
    }
    
    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        background-color: transparent;
        cursor: pointer;
        transition: all 0.3s;
        color: var(--text-secondary);
    }
    
    .edit-discount-btn:hover {
        background-color: rgba(33, 150, 243, 0.1);
        color: var(--accent-orange);
    }
    
    .delete-discount-btn:hover {
        background-color: rgba(244, 67, 54, 0.1);
        color: #f44336;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .content-wrapper {
            padding: 15px;
        }
        
        .product-discount-grid {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        }
        
        .form-row {
            flex-direction: column;
            gap: 0;
        }
        
        .search-input {
            width: 100%;
            max-width: 250px;
        }
    }
    
    @media (max-width: 576px) {
        .product-discount-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Product search functionality
        const productSearchInput = document.getElementById('product-search');
        const productSearchResults = document.getElementById('product-search-results');
        const selectedProductInput = document.getElementById('product-select');
        const selectedProductDisplay = document.getElementById('selected-product-display');
        let searchTimeout;
        
        if (productSearchInput) {
            productSearchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();
                
                if (query.length < 2) {
                    productSearchResults.innerHTML = '';
                    productSearchResults.classList.remove('active');
                    return;
                }
                
                // Add a small delay to prevent excessive requests
                searchTimeout = setTimeout(() => {
                    fetch(`/cashier/search-product?search=${encodeURIComponent(query)}&ajax=1`)
                        .then(response => response.json())
                        .then(data => {
                            productSearchResults.innerHTML = '';
                            
                            if (data.success && data.products && data.products.length > 0) {
                                data.products.forEach(product => {
                                    const resultItem = document.createElement('div');
                                    resultItem.className = 'search-result-item';
                                    resultItem.dataset.id = product.id;
                                    resultItem.dataset.name = product.product_name;
                                    resultItem.dataset.price = product.price;
                                    
                                    resultItem.innerHTML = `
                                        <div class="search-result-name">${product.product_name}</div>
                                        <div class="search-result-price">$${parseFloat(product.price).toFixed(2)} - ${product.category}</div>
                                    `;
                                    
                                    resultItem.addEventListener('click', function() {
                                        const id = this.dataset.id;
                                        const name = this.dataset.name;
                                        const price = this.dataset.price;
                                        
                                        // Set the hidden input value
                                        selectedProductInput.value = id;
                                        
                                        // Update the display
                                        selectedProductDisplay.innerHTML = `
                                            <div>${name}</div>
                                            <div style="font-size: 12px; color: var(--primary-red);">$${parseFloat(price).toFixed(2)}</div>
                                        `;
                                        selectedProductDisplay.classList.add('active');
                                        
                                        // Clear search and hide results
                                        productSearchInput.value = '';
                                        productSearchResults.classList.remove('active');
                                    });
                                    
                                    productSearchResults.appendChild(resultItem);
                                });
                                
                                productSearchResults.classList.add('active');
                            } else {
                                productSearchResults.innerHTML = '<div class="search-result-item">No products found</div>';
                                productSearchResults.classList.add('active');
                            }
                        })
                        .catch(error => {
                            console.error('Error searching products:', error);
                            productSearchResults.innerHTML = '<div class="search-result-item">Error searching products</div>';
                            productSearchResults.classList.add('active');
                        });
                }, 300);
            });
            
            // Close search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!productSearchInput.contains(e.target) && !productSearchResults.contains(e.target)) {
                    productSearchResults.classList.remove('active');
                }
            });
        }
        
        // Toggle between product and category selection
        const discountTypeSelect = document.getElementById('discount-type');
        const productSelection = document.querySelector('.product-selection');
        const categorySelection = document.querySelector('.category-selection');
        const productSelect = document.getElementById('product-select');
        const categorySelect = document.getElementById('category-select');
        
        function toggleDiscountType() {
            if (discountTypeSelect.value === 'product') {
                productSelection.style.display = 'flex';
                categorySelection.style.display = 'none';
                categorySelect.removeAttribute('required');
                selectedProductInput.setAttribute('required', 'required');
                selectedProductInput.disabled = false;
                categorySelect.disabled = true;
                
                if (selectedProductDisplay) {
                    selectedProductDisplay.innerHTML = '';
                    selectedProductDisplay.classList.remove('active');
                }
                selectedProductInput.value = '';
            } else {
                productSelection.style.display = 'none';
                categorySelection.style.display = 'flex';
                selectedProductInput.removeAttribute('required');
                categorySelect.setAttribute('required', 'required');
                categorySelect.disabled = false;
                selectedProductInput.disabled = true;
            }
        }
        
        // Set initial state
        toggleDiscountType();
        
        // Add event listener for changes
        discountTypeSelect.addEventListener('change', toggleDiscountType);
        
        // Edit discount functionality
        const editButtons = document.querySelectorAll('.edit-discount-btn');
        const editModal = document.getElementById('edit-discount-modal');
        const closeModalBtn = document.querySelector('.close-modal');
        const cancelEditBtn = document.getElementById('cancel-edit');
        
        function openEditModal(discountId) {
            // Fetch discount data
            fetch(`/master/discounts/${discountId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const discount = data.discount;
                        
                        // Populate form fields
                        document.getElementById('edit-discount-id').value = discount.id;
                        document.getElementById('edit-product-name').textContent = discount.product ? 
                            discount.product.product_name : `${discount.category} (Category)`;
                        document.getElementById('edit-discount-percentage').value = discount.discount_percentage;
                        document.getElementById('edit-start-date').value = discount.start_date;
                        document.getElementById('edit-end-date').value = discount.end_date || '';
                        document.getElementById('edit-discount-active').checked = discount.is_active;
                        
                        // Show modal
                        editModal.classList.add('active');
                    } else {
                        alert('Error loading discount data');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading discount data');
                });
        }
        
        function closeEditModal() {
            editModal.classList.remove('active');
        }
        
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const discountId = this.dataset.discountId;
                openEditModal(discountId);
            });
        });
        
        closeModalBtn.addEventListener('click', closeEditModal);
        cancelEditBtn.addEventListener('click', closeEditModal);
        
        // Save edited discount
        const saveEditBtn = document.getElementById('save-edit');
        saveEditBtn.addEventListener('click', function() {
            const form = document.getElementById('edit-discount-form');
            const discountId = document.getElementById('edit-discount-id').value;
            const formData = new FormData(form);
            
            fetch(`/master/discounts/${discountId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Discount updated successfully!');
                    closeEditModal();
                    window.location.reload();
                } else {
                    alert('Error updating discount: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating discount');
            });
        });
        
        // Delete discount functionality
        const deleteButtons = document.querySelectorAll('.delete-discount-btn');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const discountId = this.dataset.discountId;
                
                if (confirm('Are you sure you want to delete this discount?')) {
                    fetch(`/master/discounts/${discountId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Discount deleted successfully!');
                            window.location.reload();
                        } else {
                            alert('Error deleting discount: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting discount');
                    });
                }
            });
        });
        
        // Tax form submission
        const taxForm = document.getElementById('tax-form');
        if (taxForm) {
            taxForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(taxForm);
                
                // Add checkbox values explicitly (they're only included when checked)
                if (!formData.has('apply_to_all_products')) {
                    formData.append('apply_to_all_products', '0');
                }
                
                if (!formData.has('is_default')) {
                    formData.append('is_default', '0');
                }
                
                fetch('/master/tax-rates/store', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Tax settings saved successfully!');
                        window.location.reload();
                    } else {
                        let errorMsg = 'Error saving tax settings';
                        if (data.errors) {
                            errorMsg += ': ' + Object.values(data.errors).flat().join('\n');
                        } else if (data.message) {
                            errorMsg += ': ' + data.message;
                        }
                        alert(errorMsg);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error saving tax settings');
                });
            });
        }
    });
</script>
@endpush