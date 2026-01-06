<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::withCount('purchases')
            ->latest()
            ->paginate(10);

        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:150',
            'company'   => 'nullable|string|max:150',
            'phone'     => 'required|string|max:20|unique:suppliers,phone',
            'email'     => 'nullable|email|max:100|unique:suppliers,email',
            'address'   => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        Supplier::create([
            'name'      => $validated['name'],
            'company'   => $validated['company'] ?? null,
            'phone'     => $validated['phone'],
            'email'     => $validated['email'] ?? null,
            'address'   => $validated['address'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier created successfully!');
    }

    public function show(Supplier $supplier)
{
    $supplier->load('purchases');

    return view('admin.suppliers.show', compact('supplier'));
}
    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:150',
            'company'   => 'nullable|string|max:150',
            'phone'     => 'required|string|max:20|unique:suppliers,phone,' . $supplier->id,
            'email'     => 'nullable|email|max:100|unique:suppliers,email,' . $supplier->id,
            'address'   => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $supplier->update([
            'name'      => $validated['name'],
            'company'   => $validated['company'] ?? null,
            'phone'     => $validated['phone'],
            'email'     => $validated['email'] ?? null,
            'address'   => $validated['address'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier updated successfully!');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->purchases()->count() > 0) {
            return redirect()->route('admin.suppliers.index')
                ->with('error', 'Cannot delete supplier with existing purchases.');
        }

        $supplier->delete();

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier deleted successfully!');
    }
}
