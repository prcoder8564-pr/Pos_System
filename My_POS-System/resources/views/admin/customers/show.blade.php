@extends('layouts.admin')

@section('title', 'View Customer')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-eye"></i> View Customer</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.customers.index') }}">Customers</a>
                    </li>
                    <li class="breadcrumb-item active">
                        {{ $customer->name }}
                    </li>
                </ol>
            </nav>
        </div>

        <div>
            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Customer Profile -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-user"></i> Customer Profile
                </h5>
            </div>

            <div class="card-body text-center">
                <div class="user-avatar bg-primary text-white mx-auto mb-3"
                     style="width:80px;height:80px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:bold;">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>

                <h4 class="mb-1">{{ $customer->name }}</h4>

                @if($customer->is_active)
                    <span class="badge bg-success mb-3">Active Customer</span>
                @else
                    <span class="badge bg-secondary mb-3">Inactive</span>
                @endif

                <table class="table table-borderless text-start">
                    <tr>
                        <th width="40%"><i class="fas fa-phone text-primary"></i> Phone:</th>
                        <td>{{ $customer->phone }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-envelope text-info"></i> Email:</th>
                        <td>{{ $customer->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-map-marker-alt text-danger"></i> Address:</th>
                        <td>{{ $customer->address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-calendar text-success"></i> Member Since:</th>
                        <td>{{ $customer->created_at->format('d M, Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Purchase Statistics -->
        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar"></i> Purchase Statistics
                </h5>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Total Orders</small>
                    <h4>{{ $customer->salesCount() }} Orders</h4>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Total Spent</small>
                    <h4 class="text-success">
                        ₹{{ number_format($customer->totalSalesAmount(), 2) }}
                    </h4>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Due Amount</small>
                    <h4 class="text-danger">
                        ₹{{ number_format($customer->totalDueAmount(), 2) }}
                    </h4>
                </div>

                <div>
                    <small class="text-muted">Average Order Value</small>
                    <h4>
                        ₹{{ $customer->salesCount() > 0
                            ? number_format($customer->totalSalesAmount() / $customer->salesCount(), 2)
                            : '0.00' }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Purchase History -->
    <div class="col-md-8">
        <div class="custom-table">
            <div class="p-3 border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-shopping-bag"></i> Purchase History
                </h5>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($customer->sales as $index => $sale)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $sale->invoice_number }}</td>
                                <td>{{ $sale->sale_date->format('d M, Y') }}</td>
                                <td>₹{{ number_format($sale->total, 2) }}</td>
                                <td>
                                    <span class="badge bg-success">
                                        ₹{{ number_format($sale->paid_amount, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-danger">
                                        ₹{{ number_format($sale->due_amount, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $sale->status === 'completed' ? 'success' : ($sale->status === 'pending' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-inbox fa-2x text-muted"></i>
                                    <p class="text-muted mt-2">No purchase history yet</p>
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
