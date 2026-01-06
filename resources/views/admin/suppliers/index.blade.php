@extends('layouts.admin')

@section('title', 'Suppliers')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-truck"></i> Suppliers</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Suppliers</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Supplier
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
                    <h3>{{ $suppliers->total() }}</h3>
                    <p>Total Suppliers</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-truck"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stats-card success">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>{{ $suppliers->where('is_active', true)->count() }}</h3>
                    <p>Active Suppliers</p>
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
                    <h3>{{ $suppliers->where('is_active', false)->count() }}</h3>
                    <p>Inactive Suppliers</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stats-card info">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>{{ $suppliers->sum('purchases_count') }}</h3>
                    <p>Total Purchases</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Suppliers Table -->
<div class="custom-table">
    <div class="p-3 border-bottom">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0">All Suppliers</h5>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    <input type="text" class="form-control" placeholder="Search suppliers..." 
                           style="max-width: 300px;" id="searchInput">
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0" id="suppliersTable">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th>Supplier Name</th>
                    <th>Company</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Purchases</th>
                    <th>Status</th>
                    <th width="200" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $index => $supplier)
                <tr>
                    <td>{{ $suppliers->firstItem() + $index }}</td>
                    <td>
                        <strong>{{ $supplier->name }}</strong>
                    </td>
                    <td>
                        <span class="text-muted">{{ $supplier->company ?: 'N/A' }}</span>
                    </td>
                    <td>
                        <i class="fas fa-phone text-primary"></i> {{ $supplier->phone }}
                    </td>
                    <td>
                        @if($supplier->email)
                            <i class="fas fa-envelope text-info"></i> {{ $supplier->email }}
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-info">{{ $supplier->purchases_count }} Orders</span>
                    </td>
                    <td>
                        @if($supplier->is_active)
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
                            <a href="{{ route('admin.suppliers.show', $supplier->id) }}" 
                               class="btn btn-sm btn-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" 
                               class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" 
                                    onclick="deleteSupplier({{ $supplier->id }})" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No suppliers found</p>
                        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add First Supplier
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($suppliers->hasPages())
    <div class="p-3 border-top">
        {{ $suppliers->links() }}
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
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#suppliersTable tbody tr');
        
        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    // Delete supplier function
    function deleteSupplier(id) {
        if (confirm('Are you sure you want to delete this supplier? This action cannot be undone.')) {
            let form = document.getElementById('delete-form');
            form.action = '/admin/suppliers/' + id;
            form.submit();
        }
    }
</script>
@endpush