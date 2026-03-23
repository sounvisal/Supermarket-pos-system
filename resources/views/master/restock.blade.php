@extends('master.index')

@section('title', 'Restock Product')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h1 class="page-title">Restock Product</h1>
            <a href="{{ url('master/product') }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
        </div>

        <div class="restock-card">
            <div class="product-info">
                <div class="product-image">
                    <img src="{{ asset('images/products/' . $result->image) }}" alt="{{ $result->product_name }}">
                </div>
                <div class="product-details">
                    <h2>{{ $result->product_name }}</h2>
                    <p class="category">{{ $result->category }}</p>
                    <p class="current-stock">Current Stock: <span class="stock-value">{{ $result->qty }}</span></p>
                </div>
            </div>

            <form action="{{ url('/master/product/restock') }}" method="POST" class="restock-form">
                @csrf
                <input type="hidden" name="id" value="{{ $result->id }}">
                <input type="hidden" name="product_name" value="{{ $result->product_name }}">
                <input type="hidden" name="price" value="{{ $result->price }}">
                <input type="hidden" name="category" value="{{ $result->category }}">

                <div class="form-group">
                    <label for="qty">Add Stock Quantity</label>
                    <div class="quantity-input">
                        <button type="button" class="quantity-btn minus" onclick="decrementQuantity()">-</button>
                        <input type="number" id="qty" name="qty" class="form-input" min="1" value="1" required>
                        <button type="button" class="quantity-btn plus" onclick="incrementQuantity()">+</button>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Update Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .content-wrapper {
        padding: var(--padding-large);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--padding-medium);
    }

    .back-button {
        color: var(--text-secondary);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .back-button:hover {
        color: var(--primary-red);
    }

    .restock-card {
        background: var(--surface-white);
        border-radius: var(--border-radius-medium);
        padding: var(--padding-large);
        box-shadow: var(--shadow-subtle);
        max-width: 600px;
        margin: 0 auto;
    }

    .product-info {
        display: flex;
        gap: var(--padding-medium);
        margin-bottom: var(--padding-large);
        padding-bottom: var(--padding-medium);
        border-bottom: 1px solid var(--border-color);
    }

    .product-image {
        width: 120px;
        height: 120px;
        border-radius: var(--border-radius-medium);
        overflow: hidden;
        background: var(--light-red);
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-details {
        flex: 1;
    }

    .product-details h2 {
        margin: 0 0 8px 0;
        color: var(--text-primary);
        font-size: 24px;
    }

    .category {
        color: var(--text-secondary);
        margin: 0 0 16px 0;
        font-size: 14px;
    }

    .current-stock {
        margin: 0;
        font-size: 16px;
        color: var(--text-primary);
    }

    .stock-value {
        font-weight: 600;
        color: var(--primary-red);
    }

    .quantity-input {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 8px;
    }

    .quantity-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid var(--border-color);
        background: var(--surface-white);
        color: var(--text-primary);
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .quantity-btn:hover {
        background: var(--light-red);
        color: var(--primary-red);
        border-color: var(--primary-red);
    }

    .form-input {
        width: 100px;
        text-align: center;
        font-size: 18px;
        font-weight: 600;
        padding: 8px;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-medium);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-red);
        box-shadow: 0 0 0 2px rgba(185, 69, 23, 0.1);
    }

    .form-actions {
        margin-top: var(--padding-large);
        display: flex;
        justify-content: flex-end;
    }

    .btn {
        padding: 12px 24px;
        border-radius: var(--border-radius-pill);
        border: none;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: var(--primary-red);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-red-dark);
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    @media (max-width: 768px) {
        .product-info {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .product-image {
            width: 160px;
            height: 160px;
        }

        .restock-card {
            padding: var(--padding-medium);
        }
    }
</style>
@endpush
