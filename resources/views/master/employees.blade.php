@extends('master.index')

@section('title', 'Employee Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Employee Management</h3>
                    <div class="card-tools">
                        <a href="{{ url('/master/addemployee') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Employee
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
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Profile</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $employee->id }}</td>
                                    <td>
                                        @if($employee->profile_image)
                                            <img src="{{ asset('images/profiles/' . $employee->profile_image) }}" class="employee-avatar" alt="{{ $employee->name }}">
                                        @else
                                            <div class="employee-avatar-text">
                                                {{ substr($employee->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $employee->employee_id }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>
                                        <span class="badge 
                                            @if ($employee->role == 'manager') 
                                                badge-primary
                                            @elseif ($employee->role == 'cashier')
                                                badge-success
                                            @else
                                                badge-info
                                            @endif
                                        ">
                                            {{ ucfirst($employee->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $employee->created_at->setTimezone('Asia/Phnom_Penh')->format('M d, Y') }}</td>
                                    <td class="action-buttons">
                                        <a href="{{ url('/master/editemployee/' . $employee->id) }}" class="btn btn-info btn-action" title="Edit Employee">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ url('/master/deleteemployee/' . $employee->id) }}" class="btn btn-danger btn-action" title="Deactivate Employee" onclick="return confirm('Are you sure you want to deactivate this employee? They will no longer be able to access the system.');">
                                            <i class="fas fa-user-slash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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

    .btn-action {
    width: 40px;
    height: 40px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--border-radius-medium);
    transition: all 0.2s ease;
    }

    .btn-action i {
    font-size: 1rem;
    }

    .btn-info {
    background: var(--accent-blue);
    color: white;
    box-shadow: 0 4px 10px rgba(52, 152, 219, 0.2);
    }

    .btn-info:hover {
    background: #2980b9;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(52, 152, 219, 0.3);
    }

    .btn-danger {
    background: var(--primary-red);
    color: white;
    box-shadow: 0 4px 10px rgba(231, 76, 60, 0.2);
    }

    .btn-danger:hover {
    background: var(--primary-red-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(231, 76, 60, 0.3);
    }

    /* Employee Avatars */
    .employee-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--border-color);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .employee-avatar-text {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--primary-red-light);
        color: var(--primary-red);
        font-weight: bold;
        border: 2px solid var(--border-color);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        font-size: 16px;
    }

    /* Table Styling */
    .table-responsive {
    border-radius: var(--border-radius-medium);
    overflow: hidden;
    box-shadow: 0 0 0 1px var(--border-color);
    }

    .table {
    color: var(--text-primary);
    margin-bottom: 0;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    }

    .table th {
    background-color: var(--background-light);
    color: var(--text-primary);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
    padding: 16px;
    border: none;
    border-bottom: 2px solid var(--border-color);
    white-space: nowrap;
    }

    .table td {
    padding: 16px;
    border: none;
    border-bottom: 1px solid var(--border-color);
    vertical-align: middle;
    transition: background-color 0.15s ease;
    }

    .table tr:last-child td {
    border-bottom: none;
    }

    .table-striped tbody tr:nth-of-type(odd) {
    background-color: var(--background-lighter);
    }

    .table tbody tr:hover {
    background-color: var(--primary-red-light);
    }

    /* Employee styling */
    .employee-id {
    font-family: 'Roboto Mono', monospace;
    font-weight: 500;
    color: var(--accent-blue);
    padding: 3px 6px;
    background-color: rgba(52, 152, 219, 0.1);
    border-radius: 4px;
    }

    .employee-name {
    font-weight: 600;
    color: var(--text-primary);
    }

    /* Badge Styling */
    .badge {
    padding: 7px 12px;
    border-radius: 30px;
    font-weight: 500;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    }

    .badge-primary {
    background-color: var(--primary-red);
    background-image: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    color: white;
    }

    .badge-success {
    background-color: var(--accent-green);
    background-image: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
    color: white;
    }

    .badge-info {
    background-color: var(--accent-orange);
    background-image: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    color: white;
    }

    /* Action Buttons */
    .action-buttons {
    display: flex;
    gap: 8px;
    justify-content: flex-start;
    align-items: center;
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

    @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
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
    
    .table-responsive {
        overflow-x: auto;
    }
    
    .table th, .table td {
        padding: 12px;
    }
    
    .action-buttons {
        flex-direction: row;
        width: auto;
    }

    .btn-action {
        width: 36px;
        height: 36px;
    }
    }
</style> 

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Set up delete modal
        $('#deleteModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const name = button.data('name');
            
            const modal = $(this);
            modal.find('#employeeName').text(name);
            modal.find('#deleteForm').attr('action', '{{ url("/master/deleteemployee") }}/' + id);
        });
    });
</script>
@endsection