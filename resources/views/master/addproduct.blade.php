@extends('master.index')

@section('title', 'Add Product')


@section('content')
@if(session('success'))
    <div id="success-alert" class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('success-alert');
        if(alert) {
            setTimeout(function() {
                alert.classList.add('fade-out');
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 500);
            }, 5000);
        }
    });
</script>
    <div class="page-header">
        <h1 class="page-title">Add New Product</h1>
    </div>
    <div class="settings-card" style="max-width: 500px; margin: 0 auto;">
        <form action="{{ url('/master/product/save') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name" class="form-input" required>
            </div>
            <div class="form-row">
                <div class="form-group half">
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" class="form-input" min="0" step="0.01" required>
                </div>
                <div class="form-group half">
                    <label for="qty">Quantity</label>
                    <input type="number" id="qty" name="qty" class="form-input" min="0" required>
                </div>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-select" required>
                    <option value="">Select Category</option>
                    <option value="fruits">Fruits</option>
                    <option value="vegetables">Vegetables</option>
                    <option value="dairy">Dairy</option>
                    <option value="meat">Meat</option>
                    <option value="bakery">Bakery</option>
                    <option value="beverages">Beverages</option>
                    <option value="snacks">Snacks</option>
                    <option value="household">Household</option>
                    <option value="electronics">Electronics</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Product Image</label>
                <div class="image-upload-container">
                    <div class="image-preview" id="imagePreview">
                        <img src="{{ asset('images/products/default.jpg') }}" alt="Preview" id="previewImage">
                        <div class="image-placeholder">
                            <i class="fas fa-image"></i>
                            <span>No image selected</span>
                        </div>
                    </div>
                    <input type="file" id="image" name="image" class="form-input" accept="image/*" onchange="previewImage(this)">
                </div>
            </div>
            <div class="form-actions" style="margin-top: 24px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Product
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

    .image-upload-container {
        margin-top: 8px;
    }

    .image-preview {
        width: 200px;
        height: 200px;
        border: 2px dashed var(--border-color);
        border-radius: var(--border-radius-medium);
        margin-bottom: 16px;
        overflow: hidden;
        position: relative;
        background: var(--background-light);
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
    }

    .image-placeholder {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
    }

    .image-placeholder i {
        font-size: 48px;
        margin-bottom: 8px;
    }

    .image-placeholder span {
        font-size: 14px;
    }

    input[type="file"].form-input {
        padding: 8px;
        background: var(--light-red);
        cursor: pointer;
    }

    input[type="file"].form-input::-webkit-file-upload-button {
        background: var(--primary-red);
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: var(--border-radius-small);
        cursor: pointer;
        font-weight: 500;
        margin-right: 12px;
    }

    input[type="file"].form-input::-webkit-file-upload-button:hover {
        background: var(--primary-red-dark);
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

    .alert {
        padding: 15px 20px;
        border-radius: 6px;
        font-size: 15px;
        margin-bottom: 20px;
        font-weight: 500;
    }
    .alert-success {
        background: #e6f9ed;
        color: #1a7f37;
        border: 1px solid #b6e2cc;
    }
    .alert-danger {
        background: #ffeaea;
        color: #b91c1c;
        border: 1px solid #f5c2c7;
    }
</style>
@endpush

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('previewImage');
    const placeholder = document.querySelector('.image-placeholder');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
        placeholder.style.display = 'flex';
    }
}
</script>
@endpush

