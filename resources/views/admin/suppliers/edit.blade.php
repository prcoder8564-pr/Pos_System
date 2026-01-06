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

@section('title', 'Edit Supplier')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-edit"></i> Edit Supplier</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.suppliers.index') }}">Suppliers</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Supplier Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Supplier Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">
                                Supplier Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $supplier->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Company Name -->
                        <div class="col-md-6 mb-3">
                            <label for="company" class="form-label">Company Name</label>
                            <input type="text" 
                                   class="form-control @error('company') is-invalid @enderror" 
                                   id="company" 
                                   name="company" 
                                   value="{{ old('company', $supplier->company) }}">
                            @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
                                   value="{{ old('phone', $supplier->phone) }}"
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
                                   value="{{ old('email', $supplier->email) }}">
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
                                  rows="3">{{ old('address', $supplier->address) }}</textarea>
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
               {{ old('is_active', $supplier->is_active) ? 'checked' : '' }}>

        <label class="form-check-label" for="is_active">
            <strong>Active Status</strong>
        </label>
    </div>
</div>

                    <hr>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Update Supplier
                        </button>
                        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">
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
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Supplier Details</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <th width="40%">Created:</th>
                        <td>{{ $supplier->created_at->format('d M, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated:</th>
                        <td>{{ $supplier->updated_at->format('d M, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Total Purchases:</th>
                        <td>
                            <span class="badge bg-primary">
                                {{ $supplier->purchases()->count() }} Orders
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Amount:</th>
                        <td>
                            <strong class="text-success">
                                ₹{{ number_format($supplier->totalPurchaseAmount(), 2) }}
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Due Amount:</th>
                        <td>
                            <strong class="text-danger">
                                ₹{{ number_format($supplier->totalDueAmount(), 2) }}
                            </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection