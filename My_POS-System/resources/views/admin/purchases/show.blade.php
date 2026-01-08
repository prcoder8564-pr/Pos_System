@extends('layouts.admin')

@section('title', 'Purchase Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Purchase Details</h2>
    <div>
        @if($purchase->due_amount > 0)
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#paymentModal">
                <i class="fas fa-money-bill"></i> Add Payment
            </button>
        @endif
        <a href="{{ route('admin.purchases.edit', $purchase) }}" class="btn btn-info">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <!-- Purchase Information -->
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Purchase Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Reference Number:</label>
                        <p><code class="fs-5">{{ $purchase->reference_number }}</code></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Purchase Date:</label>
                        <p><strong>{{ $purchase->purchase_date->format('d M Y') }}</strong></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Supplier:</label>
                        <p>
                            <strong>{{ $purchase->supplier->name }}</strong><br>
                            <small class="text-muted">{{ $purchase->supplier->company }}</small><br>
                            <small class="text-muted">{{ $purchase->supplier->phone }}</small>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Payment Status:</label>
                        <p>
                            @if($purchase->payment_status == 'paid')
                                <span class="badge bg-success fs-6">Paid</span>
                            @elseif($purchase->payment_status == 'partial')
                                <span class="badge bg-warning text-dark fs-6">Partial Payment</span>
                            @else
                                <span class="badge bg-danger fs-6">Unpaid</span>
                            @endif
                        </p>
                    </div>
                    @if($purchase->note)
                        <div class="col-md-12">
                            <label class="text-muted">Note:</label>
                            <p>{{ $purchase->note }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Products List -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Products ({{ $purchase->items->count() }} items)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>SKU</th>
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
                                        <small class="text-muted">{{ $item->product->category->name }}</small>
                                    </td>
                                    <td><code>{{ $item->product->sku }}</code></td>
                                    <td>{{ $item->quantity }} {{ $item->product->unit }}</td>
                                    <td>₹{{ number_format($item->cost, 2) }}</td>
                                    <td><strong>₹{{ number_format($item->subtotal, 2) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end"><strong>Total Amount:</strong></td>
                                <td><strong class="text-success fs-5">₹{{ number_format($purchase->total_amount, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Payment History -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Payment History</h5>
            </div>
            <div class="card-body">
                @if($purchase->payments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchase->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_date->format('d M Y, h:i A') }}</td>
                                        <td><strong>₹{{ number_format($payment->amount, 2) }}</strong></td>
                                        <td><span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span></td>
                                        <td>{{ $payment->note ?: '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">No payments recorded yet.</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Summary Sidebar -->
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Payment Summary</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <span>Total Amount:</span>
                    <strong class="fs-5">₹{{ number_format($purchase->total_amount, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Paid Amount:</span>
                    <strong class="text-success fs-5">₹{{ number_format($purchase->paid_amount, 2) }}</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="fs-5">Due Amount:</span>
                    <strong class="fs-4 {{ $purchase->due_amount > 0 ? 'text-danger' : 'text-success' }}">
                        ₹{{ number_format($purchase->due_amount, 2) }}
                    </strong>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Stats</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Items:</span>
                    <strong>{{ $purchase->items->count() }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Quantity:</span>
                    <strong>{{ $purchase->items->sum('quantity') }} units</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Payments Made:</span>
                    <strong>{{ $purchase->payments->count() }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Created:</span>
                    <strong>{{ $purchase->created_at->format('d M Y') }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.purchases.add-payment', $purchase) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Due Amount:</strong> ₹{{ number_format($purchase->due_amount, 2) }}
                    </div>
                    
                    <div class="mb-3">
                        <label for="amount" class="form-label">Payment Amount <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" 
                               max="{{ $purchase->due_amount }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="upi">UPI</option>
                            <option value="cheque">Cheque</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="payment_date" class="form-label">Payment Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date" 
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection