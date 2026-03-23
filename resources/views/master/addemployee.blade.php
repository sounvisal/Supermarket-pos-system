@extends('master.index')

@section('title', 'Add New Employee')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add New Employee</h3>
                    <div class="card-tools">
                        <a href="{{ url('/master/employees') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Employees
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle alert-icon"></i>
                            <div>
                                <strong>Please correct the following errors:</strong>
                                <ul class="error-list">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle alert-icon"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('master.saveemployee') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-user-tie"></i>
                                    <h3>Employee Information</h3>
                                </div>
                                
                                <div class="profile-photo-upload">
                                    <label>Profile Photo</label>
                                    <div class="photo-preview-container">
                                        <div class="photo-preview" id="photo-preview">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="photo-upload-controls">
                                            <label for="profile_image" class="upload-btn">
                                                <i class="fas fa-camera"></i> 
                                                Choose Photo
                                            </label>
                                            <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*" style="display: none;">
                                            <small class="form-text text-muted">
                                                Upload a professional photo (optional). Max size: 2MB.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-user"></i>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter employee's full name" value="{{ old('name') }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-envelope"></i>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter employee's email address" value="{{ old('email') }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="employee_id">Employee ID</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-id-card"></i>
                                        <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="Enter unique employee ID (e.g. C002, M002)" value="{{ old('employee_id') }}" required>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> 
                                        Employee IDs should start with C for Cashiers, S for Stock Staff, and M for Managers.
                                    </small>
                                </div>
                            </div>

                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-lock"></i>
                                    <h3>Account Security</h3>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-key"></i>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-lock"></i>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-user-tag"></i>
                                    <h3>Role Assignment</h3>
                                </div>
                                
                                <div class="form-group">
                                    <label for="role">Employee Role</label>
                                    <div class="input-with-icon">
                                        <i class="fas fa-user-shield"></i>
                                        <select class="form-control" id="role" name="role" required>
                                            <option value="">Select a role</option>
                                            <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>Cashier</option>
                                            <option value="stock" {{ old('role') == 'stock' ? 'selected' : '' }}>Stock Staff</option>
                                            <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                                        </select>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        Each role has different access levels within the system.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Reset Form
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Add Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
    --primary-red: #e74c3c;
    --primary-red-dark: #c0392b;
    --primary-red-light: #fef5f3;
    --accent-orange: #f39c12;
    --accent-blue: #3498db;
    --accent-green: #2ecc71;
    --surface-white: #ffffff;
    --background-light: #f8f9fa;
    --background-lighter: #f1f3f5;
    --text-primary: #343a40;
    --text-secondary: #6c757d;
    --border-color: #e9ecef;
    --border-radius-small: 4px;
    --border-radius-medium: 8px;
    --border-radius-large: 16px;
    --padding-small: 0.5rem;
    --padding-medium: 1rem;
    --padding-large: 1.5rem;
    --shadow-subtle: 0 2px 10px rgba(0, 0, 0, 0.05);
    --shadow-medium: 0 4px 20px rgba(0, 0, 0, 0.08);
    --transition-duration: 0.25s;
    --transition-ease: cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Layout & Container */
    .container-fluid {
    padding: var(--padding-large);
    max-width: 1400px;
    margin: 0 auto;
    }

    /* Card Styling */
    .card {
    background: var(--surface-white);
    border-radius: var(--border-radius-large);
    box-shadow: var(--shadow-medium);
    margin-bottom: var(--padding-large);
    border: none;
    transition: all var(--transition-duration) var(--transition-ease);
    overflow: hidden;
    }

    .card:hover {
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .card-header {
    background: var(--surface-white);
    border-bottom: 1px solid var(--border-color);
    padding: var(--padding-medium) var(--padding-large);
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: var(--border-radius-large) var(--border-radius-large) 0 0 !important;
    }

    .card-title {
    color: var(--text-primary);
    font-weight: 700;
    font-size: 20px;
    margin: 0;
    position: relative;
    padding-left: 15px;
    }

    .card-title::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    height: 70%;
    width: 4px;
    background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
    border-radius: 2px;
    }

    .card-body {
    padding: var(--padding-large);
    }

    .form-row {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .form-section {
        background: var(--background-light);
        border-radius: var(--border-radius-medium);
        padding: 1.75rem;
        border: 1px solid var(--border-color);
        transition: all var(--transition-duration) var(--transition-ease);
    }

    .form-section:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
        border-color: rgba(231, 76, 60, 0.2);
    }

    .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border-color);
    }

    .section-header i {
        font-size: 1.5rem;
        color: var(--primary-red);
        margin-right: 1rem;
    }

    .section-header h3 {
        font-size: 1.2rem;
        color: var(--text-primary);
        margin: 0;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-group label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.9rem;
    }

    .input-with-icon {
        position: relative;
    }

    .input-with-icon i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
        font-size: 1rem;
    }

    .input-with-icon .form-control {
        padding-left: 2.75rem;
    }

    .form-control {
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-medium);
        padding: 0.85rem 1rem;
        height: auto;
        font-size: 0.95rem;
        color: var(--text-primary);
        background-color: var(--surface-white);
        transition: all 0.2s ease-in-out;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    .form-control:focus {
        border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.15);
        outline: none;
    }

    .form-control::placeholder {
        color: var(--text-secondary);
        opacity: 0.7;
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%237A6158'%3E%3Cpath fill-rule='evenodd' d='M4.22 6.03a.75.75 0 0 1 1.06 0L8 8.74l2.72-2.71a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.09a.75.75 0 0 1 0-1.06Z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 16px;
        padding-right: 2.5rem;
    }

    .form-text {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-top: 0.6rem;
        display: flex;
        align-items: center;
        gap: 5px;
        line-height: 1.4;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        justify-content: flex-end;
    }

    /* Profile Photo Upload */
    .profile-photo-upload {
        margin-bottom: 1.5rem;
    }

    .photo-preview-container {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-top: 0.5rem;
    }

    .photo-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: var(--background-lighter);
        border: 2px dashed var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .photo-preview i {
        font-size: 2.5rem;
        color: var(--text-secondary);
    }

    .photo-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-upload-controls {
        flex: 1;
    }

    .upload-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        background-color: var(--background-light);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-medium);
        color: var(--text-primary);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .upload-btn:hover {
        background-color: var(--background-lighter);
        border-color: var(--text-secondary);
    }

    .upload-btn i {
        font-size: 1rem;
        color: var(--primary-red);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: var(--border-radius-medium);
        transition: all 0.2s ease-in-out;
        font-size: 0.95rem;
        text-decoration: none !important;
    }

    .btn i {
        font-size: 1rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
        border: none;
        color: var(--surface-white);
        box-shadow: 0 4px 10px rgba(231, 76, 60, 0.2);
    }

    .btn-primary:hover {
        background-color: var(--primary-red-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(231, 76, 60, 0.3);
    }

    .btn-secondary {
        background-color: var(--background-light);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
    }

    .btn-secondary:hover {
        background-color: var(--background-lighter);
        border-color: var(--text-secondary);
        color: var(--text-primary);
        transform: translateY(-2px);
    }

    /* Alert Styling */
    .alert {
        border-radius: var(--border-radius-medium);
        padding: 16px 20px;
        margin-bottom: var(--padding-large);
        border-left: 4px solid transparent;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        animation: fadeIn 0.5s ease;
    }

    .alert-icon {
        font-size: 18px;
        margin-top: 2px;
    }

    .alert-success {
        background-color: #d4edda;
        border-left-color: var(--accent-green);
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        border-left-color: var(--primary-red);
        color: #721c24;
    }

    .error-list {
        margin: 0.5rem 0 0 1rem;
        padding: 0;
    }

    .error-list li {
        margin-bottom: 0.25rem;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .form-section {
            padding: 1.25rem;
        }

        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .card-tools {
            width: 100%;
        }

        .card-tools .btn {
            width: 100%;
            justify-content: center;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .section-header {
            margin-bottom: 1rem;
        }

        .section-header i {
            font-size: 1.2rem;
        }

        .section-header h3 {
            font-size: 1.1rem;
        }

        .photo-preview-container {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const photoInput = document.getElementById('profile_image');
        const photoPreview = document.getElementById('photo-preview');
        
        photoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Clear the preview
                    photoPreview.innerHTML = '';
                    
                    // Create image element
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Profile Preview';
                    
                    // Add to preview container
                    photoPreview.appendChild(img);
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endpush