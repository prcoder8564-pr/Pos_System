@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<style>
    :root {
        --pos-primary: #4361ee;
        --pos-success: #2ec4b6;
        --pos-danger: #e71d36;
        --pos-warning: #ff9f1c;
        --pos-dark: #011627;
        --pos-bg: #f8f9fa;
    }

    body { background-color: var(--pos-bg); font-family: 'Inter', sans-serif; }

    /* Modern Page Header */
    .dashboard-header {
        padding: 1.5rem 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* KPI Cards - Glassmorphism style */
    .stat-widget {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.07);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height: 100%;
    }
    
    .stat-widget:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
    }

    .icon-shape {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }

    .bg-soft-primary { background: #eef2ff; color: var(--pos-primary); }
    .bg-soft-success { background: #ecfdf5; color: var(--pos-success); }
    .bg-soft-warning { background: #fff7ed; color: var(--pos-warning); }
    .bg-soft-danger { background: #fef2f2; color: var(--pos-danger); }
    .bg-soft-info { background: #e0f2fe; color: #0ea5e9; }

    /* Financial Summary Banner */
    .finance-banner {
        background: var(--pos-dark);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        background-image: radial-gradient(circle at top right, #1e293b, #011627);
    }

    .currency-font {
        font-family: 'Roboto Mono', monospace;
        font-weight: 700;
        letter-spacing: -1px;
    }

    /* Table Customization */
    .card-table-wrapper {
        background: white;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .card-table-header {
        padding: 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table thead th {
        background: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        padding: 1rem;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
    }

    /* Mobile Responsive Tweak */
    @media (max-width: 768px) {
        .dashboard-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        .money-display { font-size: 1.5rem !important; }
    }
</style>

<div class="container-fluid">
    <div class="dashboard-header">
        <div>
            <h2 class="fw-bold mb-0">Business Overview</h2>
            <p class="text-muted small">Real-time status of your store</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-white border shadow-sm btn-sm"><i class="fas fa-download me-1"></i> Report</button>
            <button class="btn btn-primary btn-sm shadow-sm"><i class="fas fa-plus me-1"></i> New Sale</button>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="stat-widget">
                <div class="icon-shape bg-soft-primary"><i class="fas fa-box"></i></div>
                <h6 class="text-muted small fw-bold text-uppercase">Total Products</h6>
                <h3 class="fw-bold mb-0">{{ $totalProducts }}</h3>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-widget">
                <div class="icon-shape bg-soft-success"><i class="fas fa-tags"></i></div>
                <h6 class="text-muted small fw-bold text-uppercase">Categories</h6>
                <h3 class="fw-bold mb-0">{{ $totalCategories }}</h3>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-widget">
                <div class="icon-shape bg-soft-warning"><i class="fas fa-user-friends"></i></div>
                <h6 class="text-muted small fw-bold text-uppercase">Total Customers</h6>
                <h3 class="fw-bold mb-0">{{ $totalCustomers }}</h3>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-widget">
                <div class="icon-shape bg-soft-info"><i class="fas fa-truck"></i></div>
                <h6 class="text-muted small fw-bold text-uppercase">Total Suppliers</h6>
                <h3 class="fw-bold mb-0">{{ $totalSuppliers }}</h3>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-6">
            <div class="finance-banner h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0 opacity-75 text-uppercase small fw-bold">Sales Performance</h5>
                    <span class="badge bg-success">Live</span>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <p class="mb-1 opacity-50 small">Today's Revenue</p>
                        <h2 class="currency-font money-display">₹{{ number_format($todaySales, 2) }}</h2>
                    </div>
                    <div class="col-md-6 mb-4">
                        <p class="mb-1 opacity-50 small">Monthly Revenue</p>
                        <h2 class="currency-font money-display">₹{{ number_format($monthSales, 2) }}</h2>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.05)">
                            <p class="mb-0 opacity-50 small">Lifetime Sales Volume</p>
                            <h4 class="currency-font mb-0 text-success">₹{{ number_format($totalSales, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="stat-widget h-100 border-start border-4 border-danger">
                <h5 class="fw-bold mb-4">Expense Analysis (Purchases)</h5>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3 rounded-4 bg-soft-danger">
                            <p class="small mb-1 text-muted">Today's Cost</p>
                            <h4 class="fw-bold currency-font mb-0">₹{{ number_format($todayPurchases, 2) }}</h4>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-4 bg-light">
                            <p class="small mb-1 text-muted">Month's Cost</p>
                            <h4 class="fw-bold currency-font mb-0">₹{{ number_format($monthPurchases, 2) }}</h4>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card bg-light border-0">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <span class="text-muted">Total Inventory Investment</span>
                                <span class="fw-bold currency-font h5 mb-0 text-danger">₹{{ number_format($totalPurchases, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-7">
            <div class="card-table-wrapper h-100">
                <div class="card-table-header">
                    <h5 class="fw-bold mb-0"><i class="fas fa-exclamation-circle text-danger me-2"></i>Inventory Alerts</h5>
                    <a href="#" class="btn btn-sm btn-light">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
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
                                <td class="fw-bold text-dark">{{ $product->name }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $product->category->name }}</span></td>
                                <td class="currency-font text-danger fw-bold">{{ $product->getCurrentStock() }}</td>
                                <td>
                                    @if($product->isOutOfStock())
                                        <span class="badge bg-danger rounded-pill">Out of Stock</span>
                                    @else
                                        <span class="badge bg-warning text-dark rounded-pill">Critical</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <img src="https://cdn-icons-png.flaticon.com/512/4436/4436481.png" width="50" class="mb-3 opacity-50">
                                    <p class="mb-0">Inventory levels are healthy!</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card-table-wrapper h-100">
                <div class="card-table-header">
                    <h5 class="fw-bold mb-0"><i class="fas fa-history text-primary me-2"></i>Recent Sales</h5>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Amount</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales as $sale)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $sale->invoice_number }}</div>
                                    <small class="text-muted">{{ $sale->customer ? $sale->customer->name : 'Walk-in' }}</small>
                                </td>
                                <td class="currency-font text-success fw-bold">₹{{ number_format($sale->total, 2) }}</td>
                                <td class="small text-muted text-end">{{ $sale->sale_date->format('d M, h:i A') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">No transactions recorded yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Modern UI feedback: Auto-hide alerts
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').slideUp('slow');
        }, 5000);
    });
</script>
@endpush