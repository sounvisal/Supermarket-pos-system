@extends('master.index')

@section('title', 'Customer Feedback Report')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h1 class="page-title">Customer Feedback</h1>
        <div class="header-actions">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search feedback..." class="form-control" id="feedback-search">
            </div>
        </div>
    </div>

    <div class="feedback-card">
        <table class="feedback-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Feedback</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Jane Doe</td>
                    <td>2024-02-20 13:45</td>
                    <td>Great service and friendly staff!</td>
                    <td>jane.doe@email.com</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Anonymous</td>
                    <td>2024-02-19 17:22</td>
                    <td>The checkout process was a bit slow.</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Michael Smith</td>
                    <td>2024-02-18 09:10</td>
                    <td>Loved the fresh produce section!</td>
                    <td>m.smith@email.com</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Sarah Lee</td>
                    <td>2024-02-17 15:05</td>
                    <td>Could you add more vegan options?</td>
                    <td>sarah.lee@email.com</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<style>
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
.feedback-card {
    background: var(--surface-white);
    border-radius: 12px;
    box-shadow: var(--shadow-subtle);
    padding: 25px;
    overflow-x: auto;
}
.feedback-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.feedback-table th {
    background: var(--light-red);
    color: var(--text-primary);
    font-weight: 600;
    text-align: left;
    padding: 12px 15px;
    font-size: 13px;
    text-transform: uppercase;
}
.feedback-table td {
    padding: 15px;
    border-bottom: 1px solid var(--border-color);
    font-size: 14px;
    vertical-align: top;
}
.feedback-table tbody tr:last-child td {
    border-bottom: none;
}
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
    .search-box {
        width: 100%;
    }
    .feedback-card {
        padding: 10px;
    }
    .feedback-table th, .feedback-table td {
        padding: 10px;
        font-size: 13px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('feedback-search');
    const tableRows = document.querySelectorAll('.feedback-table tbody tr');
    searchInput.addEventListener('input', function() {
        const value = this.value.toLowerCase();
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });
});
</script>
@endpush
