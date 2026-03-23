@extends('master.index')

@section('title', 'Edit Employee')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Employee</h3>
                    <div class="card-tools">
                        <a href="{{ url('/master/employees') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Back to Employees
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle alert-icon"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle alert-icon"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif
                    
                    <form action="{{ url('/master/updateemployee/' . $employee->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $employee->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $employee->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="employee_id">Employee ID <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" value="{{ old('employee_id', $employee->employee_id) }}" required>
                                    @error('employee_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">Role <span class="text-danger">*</span></label>
                                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="manager" {{ old('role', $employee->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                                        <option value="cashier" {{ old('role', $employee->role) == 'cashier' ? 'selected' : '' }}>Cashier</option>
                                        <option value="stock" {{ old('role', $employee->role) == 'stock' ? 'selected' : '' }}>Stock Staff</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="profile_image">Profile Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image">
                                        <label class="custom-file-label" for="profile_image">Choose file</label>
                                        @error('profile_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    @if($employee->profile_image)
                                        <div class="mt-2">
                                            <img src="{{ asset('images/profiles/' . $employee->profile_image) }}" class="img-preview" alt="{{ $employee->name }}">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password <small class="text-muted">(Leave blank to keep current password)</small></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update Employee
                            </button>
                            <a href="{{ url('/master/employees') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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

    /* Form Styling */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.95rem;
    }

    .form-control {
        display: block;
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        line-height: 1.5;
        color: var(--text-primary);
        background-color: var(--surface-white);
        background-clip: padding-box;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-medium);
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: var(--primary-red);
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.25);
    }

    .form-control.is-invalid {
        border-color: var(--primary-red);
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: var(--primary-red);
    }

    .custom-file {
        position: relative;
        display: inline-block;
        width: 100%;
        height: calc(1.5em + 1.5rem + 2px);
        margin-bottom: 0;
    }

    .custom-file-input {
        position: relative;
        z-index: 2;
        width: 100%;
        height: calc(1.5em + 1.5rem + 2px);
        margin: 0;
        opacity: 0;
    }

    .custom-file-label {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1;
        height: calc(1.5em + 1.5rem + 2px);
        padding: 0.75rem 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: var(--text-secondary);
        background-color: var(--surface-white);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-medium);
        display: flex;
        align-items: center;
    }

    .custom-file-label::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        display: block;
        height: calc(1.5em + 1.5rem);
        padding: 0.75rem 1rem;
        line-height: 1.5;
        color: var(--text-primary);
        content: "Browse";
        background-color: var(--background-light);
        border-left: inherit;
        border-radius: 0 var(--border-radius-medium) var(--border-radius-medium) 0;
        display: flex;
        align-items: center;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: var(--border-radius-medium);
        transition: all 0.2s ease-in-out;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
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
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(231, 76, 60, 0.3);
    }

    .btn-success {
        background: linear-gradient(135deg, var(--accent-green) 0%, #27ae60 100%);
        border: none;
        color: var(--surface-white);
        box-shadow: 0 4px 10px rgba(46, 204, 113, 0.2);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(46, 204, 113, 0.3);
    }

    .btn-secondary {
        background: var(--background-light);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
    }

    .btn-secondary:hover {
        background: var(--background-lighter);
        transform: translateY(-2px);
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    /* Alert Styling */
    .alert {
        border-radius: var(--border-radius-medium);
        padding: 16px 20px;
        margin-bottom: var(--padding-medium);
        border-left: 4px solid transparent;
        display: flex;
        align-items: center;
        animation: fadeIn 0.5s ease;
    }

    .alert-icon {
        font-size: 18px;
        margin-right: 12px;
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

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Image Preview */
    .img-preview {
        max-width: 100px;
        max-height: 100px;
        border-radius: var(--border-radius-medium);
        border: 2px solid var(--border-color);
        box-shadow: var(--shadow-subtle);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .card-tools {
            width: 100%;
        }
        
        .btn-primary {
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
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Show filename when file is selected
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
            
            // Preview image
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    if ($('.img-preview').length) {
                        $('.img-preview').attr('src', e.target.result);
                    } else {
                        $('<div class="mt-2"><img src="' + e.target.result + '" class="img-preview" alt="Preview"></div>').insertAfter('.custom-file');
                    }
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endsection
