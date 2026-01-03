<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalCustomers = Customer::count();
        $totalSuppliers = Supplier::count();
        $totalUsers = User::count();
        
        // Sales statistics
        $todaySales = Sale::whereDate('sale_date', today())->sum('total');
        $monthSales = Sale::whereMonth('sale_date', now()->month)->sum('total');
        $totalSales = Sale::sum('total');
        
        // Purchase statistics
        $todayPurchases = Purchase::whereDate('purchase_date', today())->sum('total');
        $monthPurchases = Purchase::whereMonth('purchase_date', now()->month)->sum('total');
        $totalPurchases = Purchase::sum('total');
        
        // Low stock products
        $lowStockProducts = Product::with('stock')
            ->whereHas('stock', function($query) {
                $query->whereRaw('quantity <= alert_quantity');
            })
            ->orWhereHas('stock', function($query) {
                $query->where('quantity', '<=', 10);
            })
            ->limit(10)
            ->get();
        
        // Recent sales
        $recentSales = Sale::with(['customer', 'user'])
            ->latest()
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalCustomers',
            'totalSuppliers',
            'totalUsers',
            'todaySales',
            'monthSales',
            'totalSales',
            'todayPurchases',
            'monthPurchases',
            'totalPurchases',
            'lowStockProducts',
            'recentSales'
        ));
    }
}