<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Admin\DashboardController;
// use App\Http\Controllers\Admin\CategoryController;
// use App\Http\Controllers\Admin\ProductController;
// use App\Http\Controllers\Admin\SupplierController;
// use App\Http\Controllers\Admin\CustomerController;
// use App\Http\Controllers\Admin\PurchaseController;
// use App\Http\Controllers\Admin\SaleController;
// use App\Http\Controllers\Admin\UserController;
// use App\Http\Controllers\Admin\ReportController;
// use App\Http\Controllers\Admin\SettingController;

// Route::get('/', function () {
//     return redirect()->route('login');
// });

// Authentication Routes (without register)
// Auth::routes(['register' => false]);

// // Admin Routes (Only Admin can access)
// Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
//     // User Management
//     Route::resource('users', UserController::class);
    
//     // Category Management
//     Route::resource('categories', CategoryController::class);
    
//     // Product Management
//     Route::resource('products', ProductController::class);
    
//     // Supplier Management
//     Route::resource('suppliers', SupplierController::class);
    
//     // Customer Management
    Route::resource('customers', CustomerController::class);
    
//     // Purchase Management
//     Route::resource('purchases', PurchaseController::class);
    
//     // Sales Management
//     Route::resource('sales', SaleController::class);
    
//     // Reports
//     Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
//     Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
//     Route::get('/reports/purchases', [ReportController::class, 'purchases'])->name('reports.purchases');
//     Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
    
//     // Settings
//     Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
//     Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
// });

// // Manager Routes (Admin + Manager can access)
// Route::middleware(['auth', 'manager'])->prefix('manager')->name('manager.')->group(function () {
//     Route::get('/dashboard', function() {
//         return view('manager.dashboard');
//     })->name('dashboard');
    
//     // Manager can view reports but not modify settings
// });

// // Cashier Routes (All authenticated users can access)
// Route::middleware(['auth', 'cashier'])->prefix('cashier')->name('cashier.')->group(function () {
//     Route::get('/pos', function() {
//         return view('cashier.pos');
//     })->name('pos');
// });


// New Code



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Redirect Root
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Auth::routes(['register' => false]);

/*
|--------------------------------------------------------------------------
| Admin Routes (ONLY ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::resource('sales', SaleController::class);

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/purchases', [ReportController::class, 'purchases'])->name('reports.purchases');
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

/*
|--------------------------------------------------------------------------
| Manager Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'manager'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {

    Route::get('/dashboard', function () {
        return view('manager.dashboard');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Cashier Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'cashier'])
    ->prefix('cashier')
    ->name('cashier.')
    ->group(function () {

    Route::get('/pos', function () {
        return view('cashier.pos');
    })->name('pos');
});

// admmim/categories Route
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
});