@extends('layouts.admin')

@section('title', 'View Supplier')

@section('content')
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-eye"></i> View Supplier</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.suppliers.index') }}">Suppliers</a></li>
                        <li class="breadcrumb-item active">{{ $supplier->name }}</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Supplier Information Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Supplier Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Name:</th>
                            <td><strong>{{ $supplier->name }}</strong></td>
                        </tr>
                        <tr>
                            <th>Company:</th>
                            <td>{{ $supplier->company ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>
                                <i class="fas fa-phone text-primary"></i> {{ $supplier->phone }}
                            </td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>
                                @if($supplier->email)
                                    <i class="fas fa-envelope text-info"></i> {{ $supplier->email }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $supplier->address ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($supplier->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created:</th>
                            <td>{{ $supplier->created_at->format('d M, Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Purchase Statistics -->
            <div class="card mt-3">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> Purchase Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Total Purchases</small>
                        <h4 class="mb-0">{{ $supplier->purchases->count() }} Orders</h4>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Total Amount</small>
                        <h4 class="mb-0 text-success">₹{{ number_format($supplier->totalPurchaseAmount(), 2) }}</h4>
                    </div>
                    <div>
                        <small class="text-muted">Due Amount</small>
                        <h4 class="mb-0 text-danger">₹{{ number_format($supplier->totalDueAmount(), 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purchase History Table -->
        <div class="col-md-8">
            <div class="custom-table">
                <div class="p-3 border-bottom">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Purchase History</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supplier->purchases as $index => $purchase)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $purchase->invoice_number }}</strong></td>
                                    <td>{{ $purchase->purchase_date->format('d M, Y') }}</td>
                                    <td>₹{{ number_format($purchase->total, 2) }}</td>
                                    <td>
                                        <span class="badge bg-success">₹{{ number_format($purchase->paid_amount, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">₹{{ number_format($purchase->due_amount, 2) }}</span>
                                    </td>
                                    <td>
                                        @if($purchase->status == 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($purchase->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-secondary">Cancelled</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                        <p class="text-muted">No purchase history yet</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection