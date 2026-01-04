@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>

<!-- Statistics Cards Row 1 -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card primary">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>{{ $totalProducts }}</h3>
                    <p>Total Products</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-box"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card success">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>{{ $totalCategories }}</h3>
                    <p>Categories</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-tags"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card warning">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>{{ $totalCustomers }}</h3>
                    <p>Customers</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-user-friends"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card info">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>{{ $totalSuppliers }}</h3>
                    <p>Suppliers</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-truck"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales Statistics Row 2 -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stats-card success">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>₹{{ number_format($todaySales, 2) }}</h3>
                    <p>Today's Sales</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stats-card primary">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>₹{{ number_format($monthSales, 2) }}</h3>
                    <p>This Month Sales</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stats-card info">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>₹{{ number_format($totalSales, 2) }}</h3>
                    <p>Total Sales</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Purchase Statistics Row 3 -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stats-card danger">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>₹{{ number_format($todayPurchases, 2) }}</h3>
                    <p>Today's Purchases</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stats-card warning">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>₹{{ number_format($monthPurchases, 2) }}</h3>
                    <p>This Month Purchases</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stats-card danger">
            <div class="d-flex justify-content-between">
                <div>
                    <h3>₹{{ number_format($totalPurchases, 2) }}</h3>
                    <p>Total Purchases</p>
                </div>
                <div class="card-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tables Row -->
<div class="row">
    <!-- Low Stock Products -->
    <div class="col-xl-6 mb-4">
        <div class="custom-table">
            <div class="p-3 border-bottom">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle text-warning"></i> Low Stock Products</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>
                                <strong class="text-danger">{{ $product->getCurrentStock() }}</strong>
                            </td>
                            <td>
                                @if($product->isOutOfStock())
                                    <span class="badge bg-danger">Out of Stock</span>
                                @else
                                    <span class="badge bg-warning">Low Stock</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-check-circle fa-2x mb-2"></i>
                                <p>All products have sufficient stock!</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Sales -->
    <div class="col-xl-6 mb-4">
        <div class="custom-table">
            <div class="p-3 border-bottom">
                <h5 class="mb-0"><i class="fas fa-receipt text-success"></i> Recent Sales</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSales as $sale)
                        <tr>
                            <td><strong>{{ $sale->invoice_number }}</strong></td>
                            <td>{{ $sale->customer ? $sale->customer->name : 'Walk-in' }}</td>
                            <td><strong class="text-success">₹{{ number_format($sale->total, 2) }}</strong></td>
                            <td>{{ $sale->sale_date->format('d M, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                <p>No sales yet</p>
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

@push('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@endpush