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

@section('title', 'Edit Purchase')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Edit Purchase</h2>
    <a href="{{ route('admin.purchases.show', $purchase) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="alert alert-warning">
    <i class="fas fa-info-circle"></i> <strong>Note:</strong> You can only edit basic information. Product quantities cannot be changed after creation to maintain stock integrity.
</div>

<form action="{{ route('admin.purchases.update', $purchase) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Purchase Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="supplier_id" class="form-label">Supplier <span class="text-danger">*</span></label>
                    <select class="form-select @error('supplier_id') is-invalid @enderror" 
                            id="supplier_id" name="supplier_id" required>
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" 
                                {{ old('supplier_id', $purchase->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }} - {{ $supplier->company }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="reference_number" class="form-label">Reference Number</label>
                    <input type="text" class="form-control" value="{{ $purchase->reference_number }}" disabled>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="purchase_date" class="form-label">Purchase Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('purchase_date') is-invalid @enderror" 
                           id="purchase_date" name="purchase_date" 
                           value="{{ old('purchase_date', $purchase->purchase_date->format('Y-m-d')) }}" required>
                    @error('purchase_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-12 mb-3">
                    <label for="note" class="form-label">Note</label>
                    <textarea class="form-control @error('note') is-invalid @enderror" 
                              id="note" name="note" rows="3">{{ old('note', $purchase->note) }}</textarea>
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    
    <!-- Products (Read-only) -->
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="mb-0">Products (Read-only)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Cost</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchase->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->product->name }}</strong><br>
                                    <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                </td>
                                <td>{{ $item->quantity }} {{ $item->product->unit }}</td>
                                <td>₹{{ number_format($item->cost, 2) }}</td>
                                <td>₹{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total Amount:</strong></td>
                            <td><strong>₹{{ number_format($purchase->total_amount, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Update Purchase
        </button>
        <a href="{{ route('admin.purchases.show', $purchase) }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection