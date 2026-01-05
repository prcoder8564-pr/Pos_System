@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@extends('layouts.admin')

@section('title', 'Edit Customer')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-edit"></i> Edit Customer</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customers</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Customer Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Customer Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Customer Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $customer->name) }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Phone -->
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">
                                Phone Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $customer->phone) }}"
                                   required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $customer->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" 
                                  name="address" 
                                  rows="3">{{ old('address', $customer->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $customer->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <strong>Active Status</strong>
                            </label>
                        </div>
                    </div>

                    <hr>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Update Customer
                        </button>
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Customer Details</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <th width="40%">Customer Since:</th>
                        <td>{{ $customer->created_at->format('d M, Y') }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated:</th>
                        <td>{{ $customer->updated_at->format('d M, Y') }}</td>
                    </tr>
                    <tr>
                        <th>Total Orders:</th>
                        <td>
                            <span class="badge bg-primary">
                                {{ $customer->salesCount() }} Orders
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Purchases:</th>
                        <td>
                            <strong class="text-success">
                                ₹{{ number_format($customer->totalSalesAmount(), 2) }}
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Due Amount:</th>
                        <td>
                            <strong class="text-danger">
                                ₹{{ number_format($customer->totalDueAmount(), 2) }}
                            </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-chart-line"></i> Quick Stats</h5>
            </div>
            <div class="card-body">
                @if($customer->salesCount() > 0)
                    <p class="mb-2">
                        <i class="fas fa-calendar-check text-success"></i>
                        <strong>Last Purchase:</strong> {{ $customer->sales()->latest()->first()->sale_date->format('d M, Y') }}
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-star text-warning"></i>
                        <strong>Loyalty:</strong> 
                        @if($customer->salesCount() > 20)
                            VIP Customer
                        @elseif($customer->salesCount() > 10)
                            Regular Customer
                        @else
                            New Customer
                        @endif
                    </p>
                @else
                    <p class="text-muted mb-0">No purchase history yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection