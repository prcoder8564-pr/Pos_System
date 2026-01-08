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

@section('title', 'New Purchase')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Create New Purchase</h2>
    <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Purchases
    </a>
</div>

<form action="{{ route('admin.purchases.store') }}" method="POST" id="purchaseForm">
    @csrf
    
    <div class="row">
        <!-- Purchase Details -->
        <div class="col-md-8">
            <div class="card mb-3">
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
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }} - {{ $supplier->company }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="reference_number" class="form-label">Reference Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('reference_number') is-invalid @enderror" 
                                   id="reference_number" name="reference_number" 
                                   value="{{ old('reference_number', $reference_number) }}" required readonly>
                            @error('reference_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="purchase_date" class="form-label">Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('purchase_date') is-invalid @enderror" 
                                   id="purchase_date" name="purchase_date" 
                                   value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                            @error('purchase_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" 
                                      id="note" name="note" rows="2">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Products Section -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Products</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="productsTable">
                            <thead>
                                <tr>
                                    <th width="25%">Product</th>
                                    <th width="10%">Current Stock</th>
                                    <th width="10%">Quantity</th>
                                    <th width="13%">Cost Price (₹)</th>
                                    <th width="13%">Selling Price (₹)</th>
                                    <th width="13%">Subtotal (₹)</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody id="productRows">
                                <!-- Dynamic rows will be added here -->
                            </tbody>
                        </table>
                    </div>
                    
                    <button type="button" class="btn btn-sm btn-primary" onclick="addProductRow()">
                        <i class="fas fa-plus"></i> Add Product
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Summary -->
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Payment Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Total Amount</label>
                        <input type="number" step="0.01" class="form-control form-control-lg" 
                               id="total_amount" name="total_amount" value="0.00" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="paid_amount" class="form-label">Paid Amount <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('paid_amount') is-invalid @enderror" 
                               id="paid_amount" name="paid_amount" value="{{ old('paid_amount', 0) }}" 
                               required onchange="calculateDue()">
                        @error('paid_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                        <select class="form-select @error('payment_method') is-invalid @enderror" 
                                id="payment_method" name="payment_method" required>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="upi" {{ old('payment_method') == 'upi' ? 'selected' : '' }}>UPI</option>
                            <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="alert alert-info">
                        <strong>Due Amount:</strong>
                        <h4 class="mb-0" id="due_amount">₹0.00</h4>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100 btn-lg">
                        <i class="fas fa-save"></i> Create Purchase
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
// Products data from PHP
const products = @json($products);
let rowIndex = 0;

// Add product row
function addProductRow() {
    const row = `
        <tr id="row_${rowIndex}">
            <td>
                <select class="form-select" name="products[${rowIndex}][product_id]" 
                        onchange="updateProductInfo(this, ${rowIndex})" required>
                    <option value="">Select Product</option>
                    ${products.map(p => `<option value="${p.id}" 
                        data-stock="${p.stock?.quantity || 0}"
                        data-selling-price="${p.selling_price || 0}">${p.name} (SKU: ${p.sku})</option>`).join('')}
                </select>
            </td>
            <td>
                <input type="text" class="form-control" id="stock_${rowIndex}" readonly>
            </td>
            <td>
                <input type="number" class="form-control" name="products[${rowIndex}][quantity]" 
                       min="1" value="1" required onchange="calculateSubtotal(${rowIndex})">
            </td>
            <td>
                <input type="number" step="0.01" class="form-control" name="products[${rowIndex}][cost]" 
                       min="0" value="0" required onchange="calculateSubtotal(${rowIndex})">
            </td>
            <td>
                <input type="number" step="0.01" class="form-control" name="products[${rowIndex}][selling_price]" 
                       id="selling_price_${rowIndex}" min="0" value="0" required>
            </td>
            <td>
                <input type="number" step="0.01" class="form-control subtotal" 
                       id="subtotal_${rowIndex}" value="0" readonly>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(${rowIndex})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `;
    
    document.getElementById('productRows').insertAdjacentHTML('beforeend', row);
    rowIndex++;
}

// Update product info (stock and selling price)
function updateProductInfo(select, index) {
    const option = select.options[select.selectedIndex];
    const stock = option.getAttribute('data-stock') || 0;
    const sellingPrice = option.getAttribute('data-selling-price') || 0;
    
    document.getElementById(`stock_${index}`).value = stock + ' units';
    document.getElementById(`selling_price_${index}`).value = parseFloat(sellingPrice).toFixed(2);
}

// Calculate subtotal for a row
function calculateSubtotal(index) {
    const quantity = parseFloat(document.querySelector(`[name="products[${index}][quantity]"]`).value) || 0;
    const cost = parseFloat(document.querySelector(`[name="products[${index}][cost]"]`).value) || 0;
    const subtotal = quantity * cost;
    
    document.getElementById(`subtotal_${index}`).value = subtotal.toFixed(2);
    calculateTotal();
}

// Calculate total amount
function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    
    document.getElementById('total_amount').value = total.toFixed(2);
    calculateDue();
}

// Calculate due amount
function calculateDue() {
    const total = parseFloat(document.getElementById('total_amount').value) || 0;
    const paid = parseFloat(document.getElementById('paid_amount').value) || 0;
    const due = total - paid;
    
    document.getElementById('due_amount').textContent = '₹' + due.toFixed(2);
}

// Remove row
function removeRow(index) {
    document.getElementById(`row_${index}`).remove();
    calculateTotal();
}

// Add first row on load
window.addEventListener('DOMContentLoaded', function() {
    addProductRow();
});
</script>
@endsection