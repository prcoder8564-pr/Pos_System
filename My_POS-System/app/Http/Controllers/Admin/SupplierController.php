<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of suppliers
     */
    public function index()
    {
        $suppliers = Supplier::withCount('purchases')
            ->latest()
            ->paginate(10);

        return view('admin.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new supplier
     */
    public function create()
    {
        return view('admin.suppliers.create');
    }

    /**
     * Store a newly created supplier in database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'company' => 'nullable|string|max:150',
            'phone' => 'required|string|max:20|unique:suppliers,phone',
            'email' => 'nullable|email|max:100|unique:suppliers,email',
            'address' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Supplier::create([
            'name' => $request->name,
            'company' => $request->company,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier created successfully!');
    }

    /**
     * Display the specified supplier
     */
    public function show(Supplier $supplier)
    {
        $supplier->load('purchases');
        return view('admin.suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified supplier
     */
    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified supplier in database
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'company' => 'nullable|string|max:150',
            'phone' => 'required|string|max:20|unique:suppliers,phone,' . $supplier->id,
            'email' => 'nullable|email|max:100|unique:suppliers,email,' . $supplier->id,
            'address' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $supplier->update([
            'name' => $request->name,
            'company' => $request->company,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier updated successfully!');
    }

    /**
     * Remove the specified supplier from database
     */
    public function destroy(Supplier $supplier)
    {
        // Check if supplier has purchases
        if ($supplier->purchases()->count() > 0) {
            return redirect()->route('admin.suppliers.index')
                ->with('error', 'Cannot delete supplier with existing purchases.');
        }

        $supplier->delete();

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier deleted successfully!');
    }
}