@extends('layouts.admin')

@section('title', 'Customers')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-user-friends"></i> Customers</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Customers</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Customer
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card primary">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>{{ $customers->total() }}</h3>
                    <p>Total Customers</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stats-card success">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>{{ $customers->where('is_active', true)->count() }}</h3>
                    <p>Active Customers</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stats-card warning">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>{{ $customers->where('is_active', false)->count() }}</h3>
                    <p>Inactive Customers</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-user-slash"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stats-card info">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>{{ $customers->sum('sales_count') }}</h3>
                    <p>Total Orders</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Customers Table -->
<div class="custom-table">
    <div class="p-3 border-bottom">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0">All Customers</h5>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end gap-2">
                    <input type="text" class="form-control" placeholder="Search customers..." 
                           style="max-width: 300px;" id="searchInput">
                    <select class="form-select" style="max-width: 150px;" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0" id="customersTable">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th>Customer Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Total Purchases</th>
                    <th>Orders</th>
                    <th>Status</th>
                    <th width="200" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $index => $customer)
                <tr>
                    <td>{{ $customers->firstItem() + $index }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-avatar bg-primary text-white me-2" style="width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                            <strong>{{ $customer->name }}</strong>
                        </div>
                    </td>
                    <td>
                        <i class="fas fa-phone text-primary"></i> {{ $customer->phone }}
                    </td>
                    <td>
                        @if($customer->email)
                            <i class="fas fa-envelope text-info"></i> {{ $customer->email }}
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td>
                        <strong class="text-success">₹{{ number_format($customer->totalSalesAmount(), 2) }}</strong>
                    </td>
                    <td>
                        <span class="badge bg-info">{{ $customer->sales_count }} Orders</span>
                    </td>
                    <td>
                        @if($customer->is_active)
                            <span class="badge bg-success">
                                <i class="fas fa-check"></i> Active
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                <i class="fas fa-times"></i> Inactive
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.customers.show', $customer->id) }}" 
                               class="btn btn-sm btn-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.customers.edit', $customer->id) }}" 
                               class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" 
                                    onclick="deleteCustomer({{ $customer->id }})" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No customers found</p>
                        <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add First Customer
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($customers->hasPages())
    <div class="p-3 border-top">
        {{ $customers->links() }}
    </div>
    @endif
</div>

<!-- Delete Form (Hidden) -->
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        filterTable();
    });

    // Status filter
    document.getElementById('statusFilter').addEventListener('change', function() {
        filterTable();
    });

    function filterTable() {
        let searchValue = document.getElementById('searchInput').value.toLowerCase();
        let statusValue = document.getElementById('statusFilter').value.toLowerCase();
        let rows = document.querySelectorAll('#customersTable tbody tr');
        
        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            let matchesSearch = text.includes(searchValue);
            let matchesStatus = true;

            if (statusValue) {
                let statusBadge = row.querySelector('.badge');
                if (statusBadge) {
                    let status = statusBadge.textContent.toLowerCase();
                    matchesStatus = status.includes(statusValue);
                }
            }

            row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
        });
    }

    // Delete customer function
    function deleteCustomer(id) {
        if (confirm('Are you sure you want to delete this customer? This action cannot be undone.')) {
            let form = document.getElementById('delete-form');
            form.action = '/admin/customers/' + id;
            form.submit();
        }
    }
</script>
@endpush