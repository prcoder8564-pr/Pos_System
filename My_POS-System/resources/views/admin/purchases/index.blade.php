@extends('layouts.admin')

@section('title', 'Purchases')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Purchase Management</h2>
    <a href="{{ route('admin.purchases.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> New Purchase
    </a>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-left-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Purchases</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $purchases->total() }}</div>
                    </div>
                    <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Amount</div>
                        <div class="h5 mb-0 font-weight-bold">₹{{ number_format($purchases->sum('total_amount'), 2) }}</div>
                    </div>
                    <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Paid</div>
                        <div class="h5 mb-0 font-weight-bold">₹{{ number_format($purchases->sum('paid_amount'), 2) }}</div>
                    </div>
                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Due</div>
                        <div class="h5 mb-0 font-weight-bold">₹{{ number_format($purchases->sum('due_amount'), 2) }}</div>
                    </div>
                    <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.purchases.index') }}" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search reference or supplier..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="supplier_id" class="form-select">
                    <option value="">All Suppliers</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="payment_status" class="form-select">
                    <option value="">All Status</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                    <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From Date">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="To Date">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Purchases Table -->
<div class="card">
    <div class="card-body">
        @if($purchases->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Date</th>
                            <th>Supplier</th>
                            <th>Total Amount</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Status</th>
                            <th>Items</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchases as $purchase)
                            <tr>
                                <td><code>{{ $purchase->reference_number }}</code></td>
                                <td>{{ $purchase->purchase_date->format('d M Y') }}</td>
                                <td>
                                    <strong>{{ $purchase->supplier->name }}</strong><br>
                                    <small class="text-muted">{{ $purchase->supplier->company }}</small>
                                </td>
                                <td>₹{{ number_format($purchase->total_amount, 2) }}</td>
                                <td>₹{{ number_format($purchase->paid_amount, 2) }}</td>
                                <td>
                                    @if($purchase->due_amount > 0)
                                        <span class="text-danger">₹{{ number_format($purchase->due_amount, 2) }}</span>
                                    @else
                                        <span class="text-success">₹0.00</span>
                                    @endif
                                </td>
                                <td>
    @if ($purchase->due_amount == 0)
        <span class="badge bg-success">Paid</span>
    @elseif ($purchase->paid_amount == 0)
        <span class="badge bg-danger">Unpaid</span>
    @else
        <span class="badge bg-warning">Partial</span>
    @endif
</td>
                                <td>
                                    <span class="badge bg-info">{{ $purchase->items->count() }} items</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.purchases.show', $purchase) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.purchases.edit', $purchase) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.purchases.destroy', $purchase) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure? This will reverse stock changes!');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $purchases->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <p class="text-muted">No purchases found.</p>
                <a href="{{ route('admin.purchases.create') }}" class="btn btn-primary">Create Your First Purchase</a>
            </div>
        @endif
    </div>
</div>
@endsection