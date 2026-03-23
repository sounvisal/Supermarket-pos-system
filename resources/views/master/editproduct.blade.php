@extends('master.index')

@section('title', 'Edit Product')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Edit Product</h1>
    </div>
    <div class="settings-card" style="max-width: 500px; margin: 0 auto;">
        <form action="{{ url('/master/product/update') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $result->id }}">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name" value="{{ $result->product_name }}"class="form-input" required>
            </div>
            <div class="form-row">
                <div class="form-group half">
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price"value="{{ $result->price }}" class="form-input" min="0" step="0.01" required>
                </div>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-select">
                    <option value="">Select Category</option>
                    <option value="fruits" {{ $result->category == 'fruits' ? 'selected' : '' }}>Fruits</option>
                    <option value="vegetables" {{ $result->category == 'vegetables' ? 'selected' : '' }}>Vegetables</option>
                    <option value="dairy" {{ $result->category == 'dairy' ? 'selected' : '' }}>Dairy</option>
                    <option value="meat" {{ $result->category == 'meat' ? 'selected' : '' }}>Meat</option>
                    <option value="bakery" {{ $result->category == 'bakery' ? 'selected' : '' }}>Bakery</option>
                    <option value="beverages" {{ $result->category == 'beverages' ? 'selected' : '' }}>Beverages</option>
                    <option value="snacks" {{ $result->category == 'snacks' ? 'selected' : '' }}>Snacks</option>
                    <option value="household" {{ $result->category == 'household' ? 'selected' : '' }}>Household</option>
                    <option value="electronics" {{ $result->category == 'electronics' ? 'selected' : '' }}>Electronics</option>
                    <option value="other" {{ $result->category == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="qty">Quantity</label>
                <input type="number" id="qty" name="qty" value="{{ $result->qty }}"class="form-input">
            </div>
            <div class="form-actions" style="margin-top: 24px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .settings-card {
        background: var(--surface-white);
        border-radius: var(--border-radius-medium);
        padding: var(--padding-large);
        box-shadow: var(--shadow-subtle);
        margin-top: var(--padding-large);
        max-width: 600px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-row {
        display: flex;
        gap: 24px;
        margin-bottom: 24px;
    }

    .form-group.half {
        flex: 1;
    }

    label {
        display: block;
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-input, .form-select {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-small);
        font-size: 15px;
        background: var(--surface-white);
        color: var(--text-primary);
        transition: all 0.2s ease;
    }

    .form-input:hover, .form-select:hover {
        border-color: var(--primary-red);
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(185, 69, 23, 0.1);
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23B94517' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
        padding-right: 40px;
        cursor: pointer;
    }

    .form-select:hover {
        border-color: var(--primary-red);
    }

    .form-select option {
        padding: 12px;
        font-size: 15px;
        background-color: var(--surface-white);
        color: var(--text-primary);
    }

    .form-select option:checked {
        background-color: var(--light-red);
        color: var(--primary-red);
        font-weight: 500;
    }

    .form-select option:hover {
        background-color: var(--light-red);
    }

    .form-actions {
        margin-top: 32px;
        display: flex;
        justify-content: flex-end;
        gap: 16px;
    }

    .btn {
        padding: 12px 24px;
        border-radius: var(--border-radius-pill);
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 120px;
    }

    .btn i {
        margin-right: 8px;
    }

    .btn-primary {
        background-color: var(--primary-red);
        color: var(--surface-white);
        border: none;
    }

    .btn-primary:hover {
        background-color: var(--primary-red-dark);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: var(--light-red);
        color: var(--primary-red);
        border: 1px solid var(--primary-red);
    }

    .btn-secondary:hover {
        background-color: var(--primary-red);
        color: var(--surface-white);
    }

    @media (max-width: 768px) {
        .settings-card {
            padding: var(--padding-medium);
            margin: var(--padding-medium);
        }

        .form-row {
            flex-direction: column;
            gap: 16px;
        }

        .form-group.half {
            width: 100%;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endpush
