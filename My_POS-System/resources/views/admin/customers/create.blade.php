@extends('layouts.admin')

@section('title', 'Add Customer')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-plus"></i> Add New Customer</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customers</a></li>
            <li class="breadcrumb-item active">Add New</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Customer Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.customers.store') }}" method="POST">
                    @csrf

                    <!-- Customer Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            Customer Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               placeholder="Enter customer full name"
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
                                   value="{{ old('phone') }}"
                                   placeholder="Enter phone number"
                                   required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Phone number must be unique</small>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="Enter email address (optional)">
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
                                  rows="3"
                                  placeholder="Enter complete address (optional)">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <strong>Active Status</strong>
                            </label>
                        </div>
                        <small class="text-muted">Enable to make this customer active for transactions</small>
                    </div>

                    <hr>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Customer
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
                <h5 class="mb-0"><i class="fas fa-lightbulb"></i> Tips</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success"></i>
                        <strong>Unique Phone:</strong> Phone number must be unique
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success"></i>
                        <strong>Valid Email:</strong> Enter valid email format (optional)
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success"></i>
                        <strong>Complete Name:</strong> Use full customer name
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success"></i>
                        <strong>Address:</strong> Complete address helps in delivery
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success"></i>
                        <strong>Active Status:</strong> Keep active for sales
                    </li>
                </ul>

                <div class="alert alert-warning">
                    <i class="fas fa-info-circle"></i>
                    <strong>Note:</strong> Customer purchase history will be tracked automatically when you make sales.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection