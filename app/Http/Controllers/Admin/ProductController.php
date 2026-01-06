<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'stock']);
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%")
                  ->orWhere('barcode', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by stock status
        if ($request->filled('stock_status')) {
            if ($request->stock_status == 'low') {
                $query->whereHas('stock', function($q) {
                    $q->whereColumn('quantity', '<=', 'alert_quantity');
                });
            } elseif ($request->stock_status == 'out') {
                $query->whereHas('stock', function($q) {
                    $q->where('quantity', 0);
                });
            }
        }
        
        $products = $query->latest()->paginate(15);
        $categories = Category::where('status', 'active')->get();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        $suppliers = Supplier::all();
        
        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'barcode' => 'nullable|string|max:100|unique:products,barcode',
            'description' => 'nullable|string',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0|gte:cost_price',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'unit' => 'required|string|max:50',
            'alert_quantity' => 'required|integer|min:0',
            'initial_stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ], [
            'selling_price.gte' => 'Selling price must be greater than or equal to cost price.',
        ]);
        
        // Auto-generate SKU if not provided
        if (empty($validated['sku'])) {
            $validated['sku'] = $this->generateSKU($validated['name']);
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }
        
        // Create product
        $product = Product::create($validated);
        
        // Create stock record
        Stock::create([
            'product_id' => $product->id,
            'quantity' => $validated['initial_stock'],
            'alert_quantity' => $validated['alert_quantity'],
        ]);
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'supplier', 'stock', 'saleItems.sale', 'purchaseItems.purchase']);
        
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', 'active')->get();
        $suppliers = Supplier::all();
        
        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|max:100|unique:products,barcode,' . $product->id,
            'description' => 'nullable|string',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0|gte:cost_price',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'unit' => 'required|string|max:50',
            'alert_quantity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ], [
            'selling_price.gte' => 'Selling price must be greater than or equal to cost price.',
        ]);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }
        
        // Update product
        $product->update($validated);
        
        // Update stock alert quantity
        if ($product->stock) {
            $product->stock->update(['alert_quantity' => $validated['alert_quantity']]);
        }
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Check if product has sales or purchases
        if ($product->saleItems()->count() > 0 || $product->purchaseItems()->count() > 0) {
            return back()->with('error', 'Cannot delete product with existing sales or purchases!');
        }
        
        // Delete image
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        
        // Delete stock record
        $product->stock()->delete();
        
        // Delete product
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }
    
    /**
     * Generate unique SKU
     */
    private function generateSKU($name)
    {
        $prefix = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $name), 0, 3));
        $random = strtoupper(Str::random(6));
        $sku = $prefix . '-' . $random;
        
        // Ensure uniqueness
        while (Product::where('sku', $sku)->exists()) {
            $random = strtoupper(Str::random(6));
            $sku = $prefix . '-' . $random;
        }
        
        return $sku;
    }
}