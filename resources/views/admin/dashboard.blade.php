@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Add Tailwind CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<!-- Quick Stats - Matching Reference Style -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <!-- Total Products -->
    <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-80 mb-1">Total Products</p>
                <p class="text-3xl font-bold">{{ $totalProducts }}</p>
            </div>
            <i class="fas fa-box text-5xl opacity-20"></i>
        </div>
    </div>

    <!-- Categories -->
    <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-80 mb-1">Categories</p>
                <p class="text-3xl font-bold">{{ $totalCategories }}</p>
            </div>
            <i class="fas fa-tags text-5xl opacity-20"></i>
        </div>
    </div>

    <!-- Customers -->
    <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-80 mb-1">Total Customers</p>
                <p class="text-3xl font-bold">{{ $totalCustomers }}</p>
            </div>
            <i class="fas fa-user-friends text-5xl opacity-20"></i>
        </div>
    </div>

    <!-- Suppliers -->
    <div class="bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-80 mb-1">Total Suppliers</p>
                <p class="text-3xl font-bold">{{ $totalSuppliers }}</p>
            </div>
            <i class="fas fa-truck text-5xl opacity-20"></i>
        </div>
    </div>
</div>

<!-- Sales Stats Row -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Today's Sales -->
    <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-80 mb-1">Today's Sales</p>
                <p class="text-3xl font-bold">₹{{ number_format($todaySales, 2) }}</p>
            </div>
            <i class="fas fa-rupee-sign text-5xl opacity-20"></i>
        </div>
    </div>

    <!-- This Month Sales -->
    <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-80 mb-1">This Month Sales</p>
                <p class="text-3xl font-bold">₹{{ number_format($monthSales, 2) }}</p>
            </div>
            <i class="fas fa-calendar-alt text-5xl opacity-20"></i>
        </div>
    </div>

    <!-- Total Sales -->
    <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-80 mb-1">Total Sales</p>
                <p class="text-3xl font-bold">₹{{ number_format($totalSales, 2) }}</p>
            </div>
            <i class="fas fa-chart-line text-5xl opacity-20"></i>
        </div>
    </div>
</div>

<!-- Purchase Stats Row -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Today's Purchases -->
    <div class="bg-gradient-to-br from-red-400 to-red-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-80 mb-1">Today's Purchases</p>
                <p class="text-3xl font-bold">₹{{ number_format($todayPurchases, 2) }}</p>
            </div>
            <i class="fas fa-shopping-cart text-5xl opacity-20"></i>
        </div>
    </div>

    <!-- This Month Purchases -->
    <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-80 mb-1">This Month Purchases</p>
                <p class="text-3xl font-bold">₹{{ number_format($monthPurchases, 2) }}</p>
            </div>
            <i class="fas fa-calendar-check text-5xl opacity-20"></i>
        </div>
    </div>

    <!-- Total Purchases -->
    <div class="bg-gradient-to-br from-pink-400 to-pink-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-80 mb-1">Total Purchases</p>
                <p class="text-3xl font-bold">₹{{ number_format($totalPurchases, 2) }}</p>
            </div>
            <i class="fas fa-shopping-bag text-5xl opacity-20"></i>
        </div>
    </div>
</div>

<!-- Quick Actions - Reference Style -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <a href="{{ route('admin.products.index') }}" 
       class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition group">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-500 transition">
                <i class="fas fa-box text-2xl text-blue-600 group-hover:text-white transition"></i>
            </div>
            <div class="ml-4">
                <h3 class="font-bold text-gray-800 text-lg">View Products</h3>
                <p class="text-sm text-gray-500">Manage inventory</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.categories.index') }}" 
       class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition group">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-500 transition">
                <i class="fas fa-tags text-2xl text-green-600 group-hover:text-white transition"></i>
            </div>
            <div class="ml-4">
                <h3 class="font-bold text-gray-800 text-lg">Manage Categories</h3>
                <p class="text-sm text-gray-500">Organize products</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.customers.index') }}" 
       class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition group">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-500 transition">
                <i class="fas fa-users text-2xl text-purple-600 group-hover:text-white transition"></i>
            </div>
            <div class="ml-4">
                <h3 class="font-bold text-gray-800 text-lg">View Customers</h3>
                <p class="text-sm text-gray-500">Customer database</p>
            </div>
        </div>
    </a>
</div>

<!-- Low Stock Products - Reference Style -->
<div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-exclamation-triangle text-orange-500 mr-2"></i>
            Low Stock Products
        </h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($lowStockProducts as $product)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-800">{{ $product->name }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-gray-800">{{ $product->category->name }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <strong class="text-red-600">{{ $product->getCurrentStock() }}</strong>
                    </td>
                    <td class="px-6 py-4">
                        @if($product->isOutOfStock())
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Out of Stock
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Low Stock
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-8 text-gray-400">
                        <i class="fas fa-check-circle text-4xl mb-2"></i>
                        <p>All products have sufficient stock!</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Sales - Reference Style -->
<div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-receipt text-green-500 mr-2"></i>
            Recent Sales
        </h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Invoice</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($recentSales as $sale)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <span class="font-semibold text-blue-600">{{ $sale->invoice_number }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-gray-800">{{ $sale->customer ? $sale->customer->name : 'Walk-in' }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="font-bold text-green-600">₹{{ number_format($sale->total, 2) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-600">{{ $sale->sale_date->format('d M, Y') }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            {{ ucfirst($sale->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-400">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <p>No sales yet</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
</script>
@endpush