@extends('layouts.admin')

@section('title', 'Product Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Product Details</h2>
    <div>
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row">
    <!-- Product Info Card -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="img-fluid rounded mb-3" 
                         style="max-height: 300px;">
                @else
                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center mb-3" 
                         style="height: 300px; border-radius: 8px;">
                        <i class="fas fa-box fa-5x"></i>
                    </div>
                @endif
                
                <h4>{{ $product->name }}</h4>
                <p class="text-muted">{{ $product->category->name }}</p>
                
                @if($product->status == 'active')
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-secondary">Inactive</span>
                @endif
                
                @php
                    $stock = $product->stock;
                    $qty = $stock ? $stock->quantity : 0;
                    $alert = $stock ? $stock->alert_quantity : 0;
                @endphp
                
                @if($qty == 0)
                    <span class="badge bg-danger ms-2">Out of Stock</span>
                @elseif($qty <= $alert)
                    <span class="badge bg-warning text-dark ms-2">Low Stock</span>
                @else
                    <span class="badge bg-success ms-2">In Stock</span>
                @endif
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="card mt-3">
            <div class="card-body">
                <h6 class="card-title">Quick Stats</h6>
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Current Stock:</span>
                    <strong>{{ $qty }} {{ $product->unit }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Alert Quantity:</span>
                    <strong>{{ $alert }} {{ $product->unit }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Sold:</span>
                    <strong>{{ $product->saleItems->sum('quantity') }} {{ $product->unit }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Total Purchased:</span>
                    <strong>{{ $product->purchaseItems->sum('quantity') }} {{ $product->unit }}</strong>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Details & History -->
    <div class="col-md-8">
        <!-- Product Information -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">SKU:</label>
                        <p><code>{{ $product->sku }}</code></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Barcode:</label>
                        <p>{{ $product->barcode ?: 'N/A' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Category:</label>
                        <p>{{ $product->category->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Supplier:</label>
                        <p>{{ $product->supplier ? $product->supplier->name : 'N/A' }}</p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="text-muted">Description:</label>
                        <p>{{ $product->description ?: 'No description available' }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pricing Information -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Pricing Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="text-muted">Cost Price:</label>
                        <h4 class="text-danger">₹{{ number_format($product->cost_price, 2) }}</h4>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted">Selling Price:</label>
                        <h4 class="text-success">₹{{ number_format($product->selling_price, 2) }}</h4>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted">Profit Margin:</label>
                        <h4 class="text-primary">₹{{ number_format($product->profitMargin(), 2) }}</h4>
                        <small class="text-muted">
                            ({{ $product->cost_price > 0 ? number_format(($product->profitMargin() / $product->cost_price) * 100, 1) : 0 }}%)
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sales History -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Recent Sales</h5>
            </div>
            <div class="card-body">
                @if($product->saleItems->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Invoice</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->saleItems->take(10) as $item)
                                    <tr>
                                        <td>{{ $item->sale->sale_date->format('d M Y') }}</td>
                                        <td>{{ $item->sale->invoice_number }}</td>
                                        <td>{{ $item->quantity }} {{ $product->unit }}</td>
                                        <td>₹{{ number_format($item->price, 2) }}</td>
                                        <td>₹{{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">No sales recorded yet</p>
                @endif
            </div>
        </div>
        
        <!-- Purchase History -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Purchases</h5>
            </div>
            <div class="card-body">
                @if($product->purchaseItems->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Reference</th>
                                    <th>Supplier</th>
                                    <th>Quantity</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->purchaseItems->take(10) as $item)
                                    <tr>
                                        <td>{{ $item->purchase->purchase_date->format('d M Y') }}</td>
                                        <td>{{ $item->purchase->reference_number }}</td>
                                        <td>{{ $item->purchase->supplier->name }}</td>
                                        <td>{{ $item->quantity }} {{ $product->unit }}</td>
                                        <td>₹{{ number_format($item->cost, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">No purchases recorded yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection