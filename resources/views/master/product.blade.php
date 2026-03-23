@extends('master.index')

@section('title', 'Product Management')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <div class="header-content">
                <h1 class="page-title">Product Management</h1>
                <div class="total-products">
                    <span class="total-count">{{ $pro->total() }}</span>
                    <span class="total-label">Total Products</span>
                </div>
            </div>
            <a href="{{url('master/addproduct')}}" class="add-product-button">
                <i class="fas fa-plus-circle"></i> Add New Product
            </a>
        </div>
        <form action="{{url('master/searchproduct')}}" method="get" class="search-form">
            <div class="search-container">
                <div class="search-input-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="search" placeholder="Search product" class="search-input" value="{{ request('search') }}">
                </div>
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </form>

        <div class="stock-summary">
            <div class="stock-card high-stock">
                <div class="stock-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stock-info">
                    <span class="stock-count">{{ App\Models\Products::where('status', 1)->where('qty', '>', 50)->count() }}</span>
                    <span class="stock-label">In Stock</span>
                </div>
            </div>
            <div class="stock-card medium-stock">
                <div class="stock-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stock-info">
                    <span class="stock-count">{{ App\Models\Products::where('status', 1)->where('qty', '>', 30)->where('qty', '<=', 50)->count() }}</span>
                    <span class="stock-label">Medium Stock</span>
                </div>
            </div>
            <div class="stock-card low-stock">
                <div class="stock-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stock-info">
                    <span class="stock-count">{{ App\Models\Products::where('status', 1)->where('qty', '<=', 30)->count() }}</span>
                    <span class="stock-label">Low Stock</span>
                </div>
            </div>
        </div>

        <div class="product-list-card">
            <table class="product-table">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pro as $product)
                    <tr>
                        <td>{{ ($pro->currentPage() - 1) * $pro->perPage() + $loop->iteration }}</td>
                        <td>
                            <div class="product-image">
                                <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->product_name }}">
                            </div>
                        </td>
                        <td>
                            <div class="product-cell-name">
                                <div class="product-image-placeholder">
                                    <i class="fas fa-box"></i>
                                </div>
                                {{ $product->product_name }}
                            </div>
                        </td>
                        <td>{{ $product->category }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->qty }}</td>
                        <td>
                            @if($product->qty > 50)
                                <span class="stock-status status-high">In Stock</span>
                            @elseif($product->qty > 30)
                                <span class="stock-status status-medium">Medium Stock</span>
                            @else
                                <span class="stock-status status-low">Low Stock</span>
                            @endif
                        </td>
                        <td class="product-actions">
                            <a href="{{ url('master/editproduct/' . $product->id) }}" class="action-icon-button edit-button" title="Edit Product">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="{{ url('master/deleteproduct/' . $product->id) }}" 
                               class="action-icon-button delete-button" 
                               title="Delete Product"
                               onclick="return confirm('Are you sure you want to delete this product?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            <a href="{{ url('master/restock/' . $product->id) }}" class="add-stock-button">
                                <i class="fa-solid fa-cart-plus"></i> Add Stock
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            <i class="fas fa-box-open"></i>
                            No products found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Pagination Navigation -->
            <div class="pagination-container">
                {{ $pro->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    :root {
        --primary-red: #B94517; /* Main brand rust-red color from logo */
        --primary-red-dark: #8A3211; /* Darker accent for hover states */
        --light-red: #FFF1EC; /* Very light background with red tint */
        --accent-orange: #E66E24; /* Warm orange accent from logo */
        --accent-orange-dark: #C55E20; /* Darker orange for hover states */
        --accent-brown: #70280B; /* Deep brown for contrast */
        --background-light: #FEF8F5; /* Warmer, cream background */
        --surface-white: #FFFFFF; /* Pure white for cards */
        --text-primary: #3D2217; /* Dark brown for text */
        --text-secondary: #7A6158; /* Muted brown for labels/descriptions */
        --border-color: #F0E6E2; /* Light, warm border color */
        --hover-light: #F7EAE5;

        --spacing-unit: 8px;
        --padding-small: calc(var(--spacing-unit) * 1.5);
        --padding-medium: calc(var(--spacing-unit) * 2.5);
        --padding-large: calc(var(--spacing-unit) * 4);

        --border-radius-small: 4px;
        --border-radius-medium: 8px;
        --border-radius-large: 12px;
        --border-radius-pill: 50px;

        --shadow-subtle: 0 2px 5px rgba(122, 60, 25, 0.05);
        --shadow-medium: 0 5px 15px rgba(122, 60, 25, 0.08);

        --transition-duration: 0.2s;
        --transition-ease: ease-in-out;

        --touch-target-min: 40px;
    }

    body {
        background-color: var(--background-light);
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        line-height: 1.6;
    }

    .content-wrapper {
        padding: var(--padding-large);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--padding-medium);
        flex-wrap: wrap;
        gap: var(--spacing-unit);
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .add-product-button {
        background-color: var(--primary-red);
        color: var(--surface-white);
        padding: var(--spacing-unit) calc(var(--spacing-unit) * 2);
        border: none;
        border-radius: var(--border-radius-pill);
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: background-color var(--transition-duration) var(--transition-ease);
        min-height: var(--touch-target-min);
    }

    .add-product-button i {
        margin-right: var(--spacing-unit);
    }

    .add-product-button:hover {
        background-color: var(--primary-red-dark);
    }

    .product-list-card {
        background: var(--surface-white);
        border-radius: var(--border-radius-medium);
        padding: var(--padding-medium);
        box-shadow: var(--shadow-subtle);
        overflow-x: auto;
    }

    .product-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 var(--spacing-unit);
        margin-top: var(--spacing-unit);
    }

    .product-table thead th {
        text-align: left;
        padding: var(--spacing-unit) var(--spacing-unit);
        font-size: 12px;
        font-weight: 600;
        color: var(--text-secondary);
        border-bottom: 1px solid var(--border-color);
        text-transform: uppercase;
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        .product-table thead {
            display: none;
        }
        .product-list-card {
            padding: var(--padding-small);
        }
        .product-table {
            border-spacing: 0 var(--padding-small);
        }
    }

    .product-table tbody tr {
        background-color: var(--background-light);
        border-radius: var(--border-radius-small);
        overflow: hidden;
        transition: background-color var(--transition-duration) var(--transition-ease);
    }

    .product-table tbody tr:hover {
        background-color: var(--hover-light);
    }

    .product-table td {
        padding: var(--padding-small);
        font-size: 14px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-table tbody tr td:first-child {
        border-top-left-radius: var(--border-radius-small);
        border-bottom-left-radius: var(--border-radius-small);
    }

    .product-table tbody tr td:last-child {
        border-top-right-radius: var(--border-radius-small);
        border-bottom-right-radius: var(--border-radius-small);
        border-right: 1px solid var(--border-color);
    }

    .product-table tbody tr td:first-child {
        border-left: 1px solid var(--border-color);
    }

    @media (max-width: 768px) {
        .product-table td {
            border: none;
            padding: var(--spacing-unit) var(--padding-small);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--text-secondary);
            margin-right: var(--padding-small);
            font-size: 12px;
            flex-shrink: 0;
        }

        .product-table tbody tr td:first-child,
        .product-table tbody tr td:last-child {
            border-radius: var(--border-radius-medium);
            border: 1px solid var(--border-color);
        }

        .product-table tbody tr td:last-child {
            border-right: 1px solid var(--border-color);
        }

        .product-table tbody tr td:first-child {
            border-left: 1px solid var(--border-color);
        }

        .product-table tbody tr {
            margin-bottom: var(--spacing-unit);
            display: block;
            padding: var(--padding-small) 0;
        }

        .product-table tbody tr td:first-child::before {
            content: none;
        }

        .product-table tbody tr td:first-child {
            padding-bottom: var(--spacing-unit);
            font-weight: 600;
        }

        .product-table td.product-cell {
            white-space: normal;
            overflow: visible;
            text-overflow: clip;
        }
    }

    .product-cell-name {
        display: flex;
        align-items: center;
        font-weight: 500;
        color: var(--text-primary);
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media (max-width: 768px) {
        .product-cell-name {
            max-width: none;
            font-weight: 600;
            white-space: normal;
        }
    }

    .product-image-placeholder {
        width: 36px;
        height: 36px;
        border-radius: var(--border-radius-small);
        background-color: var(--light-red);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-red-dark);
        margin-right: var(--spacing-unit);
    }

    .product-image {
        width: 50px;
        height: 50px;
        border-radius: var(--border-radius-small);
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-table td[data-label="No:"] {
        font-weight: 500;
        color: var(--text-secondary);
        width: 50px;
    }

    .product-table td[data-label="Image:"] {
        width: 70px;
    }

    @media (max-width: 768px) {
        .product-image {
            width: 40px;
            height: 40px;
        }
    }

    .stock-status {
        font-size: 12px;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: var(--border-radius-pill);
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-high {
        background-color: #E8F5E9;
        color: #2E7D32;
        border: 1px solid #A5D6A7;
    }

    .status-medium {
        background-color: #FFF3E0;
        color: #E65100;
        border: 1px solid #FFCC80;
    }

    .status-low {
        background-color: #FFEBEE;
        color: #C62828;
        border: 1px solid #FFCDD2;
    }

    .product-actions {
        display: flex;
        align-items: center;
        gap: var(--spacing-unit);
        white-space: nowrap;
    }

    .action-icon-button {
        min-width: var(--touch-target-min);
        height: var(--touch-target-min);
        border-radius: 50%;
        background-color: var(--surface-white);
        border: 1px solid var(--border-color);
        cursor: pointer;
        color: var(--text-secondary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all var(--transition-duration) var(--transition-ease);
        box-shadow: var(--shadow-subtle);
    }

    .action-icon-button:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .action-icon-button.edit-button {
        color: #1976D2;
        border-color: #BBDEFB;
    }

    .action-icon-button.edit-button:hover {
        background-color: #E3F2FD;
        color: #1565C0;
    }

    .action-icon-button.delete-button {
        color: #D32F2F;
        border-color: #FFCDD2;
    }

    .action-icon-button.delete-button:hover {
        background-color: #FFEBEE;
        color: #C62828;
    }

    .add-stock-button {
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: var(--border-radius-pill);
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        margin-left: var(--spacing-unit);
        transition: all var(--transition-duration) var(--transition-ease);
        box-shadow: var(--shadow-subtle);
        text-decoration: none;
    }

    .add-stock-button i {
        margin-right: 6px;
        font-size: 12px;
    }

    .add-stock-button:hover {
        background-color: #43A047;
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .empty-state {
        text-align: center;
        color: var(--text-secondary);
        padding: var(--padding-large);
        font-size: 18px;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: var(--padding-small);
        color: var(--border-color);
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 20px;
        }

        .add-product-button {
            font-size: 14px;
            padding: var(--spacing-unit) var(--padding-small);
        }

        .product-table td {
            font-size: 13px;
            padding: var(--spacing-unit);
        }

        .product-cell-name {
            font-size: 14px;
        }

        .product-image-placeholder {
            width: 30px;
            height: 30px;
            font-size: 14px;
        }

        .stock-status {
            font-size: 10px;
            padding: 3px 8px;
        }

        .action-icon-button {
            font-size: 14px;
            min-width: 36px;
            min-height: 36px;
            padding: 0;
        }

        .add-stock-button {
            font-size: 12px;
            padding: var(--spacing-unit) / 2 calc(var(--spacing-unit) * 1);
        }
    }

    .category-filter {
        display: flex;
        gap: var(--spacing-unit);
        margin-bottom: var(--padding-medium);
        flex-wrap: wrap;
    }

    .category-btn {
        padding: 8px 16px;
        border-radius: var(--border-radius-pill);
        background-color: var(--surface-white);
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        border: 1px solid var(--border-color);
        transition: all var(--transition-duration) var(--transition-ease);
    }

    .category-btn:hover {
        background-color: var(--light-red);
        color: var(--primary-red);
        border-color: var(--primary-red);
    }

    .category-btn.active {
        background-color: var(--primary-red);
        color: white;
        border-color: var(--primary-red);
    }

    .pagination-container {
        margin-top: var(--padding-medium);
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        gap: 8px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination li {
        display: inline-block;
    }

    .pagination a,
    .pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border-radius: var(--border-radius-small);
        background-color: var(--surface-white);
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 14px;
        border: 1px solid var(--border-color);
        transition: all var(--transition-duration) var(--transition-ease);
    }

    .pagination a:hover {
        background-color: var(--light-red);
        color: var(--primary-red);
        border-color: var(--primary-red);
    }

    .pagination .active span {
        background-color: var(--primary-red);
        color: white;
        border-color: var(--primary-red);
    }

    .pagination .disabled span {
        background-color: var(--background-light);
        color: var(--text-secondary);
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .category-filter {
            gap: 8px;
        }

        .category-btn {
            padding: 6px 12px;
            font-size: 13px;
        }
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: var(--padding-medium);
    }

    .total-products {
        display: flex;
        align-items: baseline;
        gap: 8px;
        padding: 6px 12px;
        background-color: var(--light-red);
        border-radius: var(--border-radius-pill);
        border: 1px solid var(--border-color);
    }

    .total-count {
        font-size: 20px;
        font-weight: 700;
        color: var(--primary-red);
    }

    .total-label {
        font-size: 14px;
        color: var(--text-secondary);
    }

    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            align-items: flex-start;
            gap: var(--spacing-unit);
        }

        .total-products {
            padding: 4px 10px;
        }

        .total-count {
            font-size: 18px;
        }

        .total-label {
            font-size: 13px;
        }
    }

    .stock-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--padding-medium);
        margin-bottom: var(--padding-medium);
    }

    .stock-card {
        background: var(--surface-white);
        border-radius: var(--border-radius-medium);
        padding: var(--padding-medium);
        display: flex;
        align-items: center;
        gap: var(--padding-medium);
        box-shadow: var(--shadow-subtle);
        border: 1px solid var(--border-color);
    }

    .stock-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--border-radius-medium);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .high-stock .stock-icon {
        background-color: #E8F5E9;
        color: #2E7D32;
    }

    .medium-stock .stock-icon {
        background-color: #FFF3E0;
        color: #E65100;
    }

    .low-stock .stock-icon {
        background-color: #FFEBEE;
        color: #C62828;
    }

    .stock-info {
        display: flex;
        flex-direction: column;
    }

    .stock-count {
        font-size: 24px;
        font-weight: 700;
        line-height: 1;
    }

    .high-stock .stock-count {
        color: #2E7D32;
    }

    .medium-stock .stock-count {
        color: #E65100;
    }

    .low-stock .stock-count {
        color: #C62828;
    }

    .stock-label {
        font-size: 14px;
        color: var(--text-secondary);
        margin-top: 4px;
    }

    .search-form {
        margin-bottom: var(--padding-medium);
    }
    .search-container {
        display: flex;
        gap: var(--spacing-unit);
        max-width: 600px;
    }
    .search-input-wrapper {
        position: relative;
        flex: 1;
    }
    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
        font-size: 16px;
    }
    .search-input {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-pill);
        font-size: 14px;
        color: var(--text-primary);
        background-color: var(--surface-white);
        transition: all var(--transition-duration) var(--transition-ease);
    }
    .search-input:focus {
        outline: none;
        border-color: var(--primary-red);
        box-shadow: 0 0 0 2px rgba(185, 69, 23, 0.1);
    }
    .search-input::placeholder {
        color: var(--text-secondary);
    }
    .search-button {
        padding: 12px 24px;
        background-color: var(--primary-red);
        color: white;
        border: none;
        border-radius: var(--border-radius-pill);
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all var(--transition-duration) var(--transition-ease);
    }
    .search-button:hover {
        background-color: var(--primary-red-dark);
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }
    .search-button i {
        font-size: 14px;
    }
    @media (max-width: 768px) {
        .search-container {
            flex-direction: column;
        }
        .search-button {
            width: 100%;
            justify-content: center;
        }
    }

</style>
@endpush

@push('scripts')
<!-- Add Bootstrap CSS if not already included -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush