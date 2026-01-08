<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Stock;
use App\Models\InventoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $query = Purchase::with(['supplier', 'items']);
        
        // Search by reference number or supplier
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('reference_number', 'LIKE', "%{$search}%")
                  ->orWhereHas('supplier', function($q2) use ($search) {
                      $q2->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        // Filter by supplier
        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }
        
        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('purchase_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('purchase_date', '<=', $request->date_to);
        }
        
        $purchases = $query->latest('purchase_date')->paginate(15);
        $suppliers = Supplier::all();
        
        return view('admin.purchases.index', compact('purchases', 'suppliers'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::with('stock')->where('status', 'active')->get();
        $reference_number = $this->generateReferenceNumber();
        
        return view('admin.purchases.create', compact('suppliers', 'products', 'reference_number'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'reference_number' => 'required|string|max:100|unique:purchases,reference_number',
            'purchase_date' => 'required|date',
            'note' => 'nullable|string',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0|lte:total_amount',
            'payment_method' => 'required|in:cash,card,bank_transfer,upi,cheque',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.cost' => 'required|numeric|min:0',
            'products.*.selling_price' => 'required|numeric|min:0',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Calculate payment status
            $due_amount = $validated['total_amount'] - $validated['paid_amount'];
            if ($validated['paid_amount'] == 0) {
                $payment_status = 'unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'partial';
            } else {
                $payment_status = 'paid';
            }
            
            // Create purchase
            $purchase = Purchase::create([
                'supplier_id' => $validated['supplier_id'],
                'user_id' => auth()->id(),
                'reference_number' => $validated['reference_number'],
                'invoice_number' => $validated['reference_number'],
                'purchase_date' => $validated['purchase_date'],
                'subtotal' => $validated['total_amount'],
                'tax' => 0,
                'discount' => 0,
                'total' => $validated['total_amount'],
                'paid_amount' => $validated['paid_amount'],
                'due_amount' => $due_amount,
                'status' => 'completed',
                'note' => $validated['note'],
            ]);
            
            // Create purchase items and update stock
            foreach ($validated['products'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $subtotal = $item['quantity'] * $item['cost'];
                
                // Create purchase item
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'cost_price' => $item['cost'],
                    'selling_price' => $item['selling_price'],
                    'subtotal' => $subtotal,
                ]);
                
                // Update stock
                $stock = Stock::firstOrCreate(
                    ['product_id' => $item['product_id']],
                    ['quantity' => 0, 'alert_quantity' => 10]
                );
                
                $old_quantity = $stock->quantity;
                $stock->increment('quantity', $item['quantity']);
                
                // Log inventory movement with ALL required fields
                InventoryLog::create([
                    'product_id' => $item['product_id'],
                    'user_id' => auth()->id(),
                    'type' => 'purchase',
                    'quantity_changed' => $item['quantity'],
                    'quantity_before' => $old_quantity,
                    'quantity_after' => $stock->quantity,
                    'reference_id' => $purchase->id,
                    'reference_type' => 'App\Models\Purchase',
                    'note' => "Purchase from {$purchase->supplier->name} - Ref: {$purchase->reference_number}",
                ]);
            }
            
            // Create payment record if paid amount > 0
            if ($validated['paid_amount'] > 0) {
                Payment::create([
                    'purchase_id' => $purchase->id,
                    'amount' => $validated['paid_amount'],
                    'payment_method' => $validated['payment_method'],
                    'payment_date' => now(),
                    'note' => 'Initial payment for purchase ' . $purchase->reference_number,
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('admin.purchases.show', $purchase)
                ->with('success', 'Purchase created successfully and stock updated!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create purchase: ' . $e->getMessage());
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.product', 'payments']);
        
        return view('admin.purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        $suppliers = Supplier::all();
        $products = Product::with('stock')->where('status', 'active')->get();
        $purchase->load(['items.product']);
        
        return view('admin.purchases.edit', compact('purchase', 'suppliers', 'products'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'note' => 'nullable|string',
        ]);
        
        $purchase->update($validated);
        
        return redirect()->route('admin.purchases.show', $purchase)
            ->with('success', 'Purchase updated successfully!');
    }

    public function destroy(Purchase $purchase)
    {
        DB::beginTransaction();
        
        try {
            // Reverse stock changes
            foreach ($purchase->items as $item) {
                $stock = Stock::where('product_id', $item->product_id)->first();
                if ($stock) {
                    $old_quantity = $stock->quantity;
                    $stock->decrement('quantity', $item->quantity);
                    
                    // Log inventory reversal with ALL required fields
                    InventoryLog::create([
                        'product_id' => $item->product_id,
                        'user_id' => auth()->id(),
                        'type' => 'adjustment',
                        'quantity_changed' => -$item->quantity,
                        'quantity_before' => $old_quantity,
                        'quantity_after' => $stock->quantity,
                        'reference_id' => $purchase->id,
                        'reference_type' => 'App\Models\Purchase',
                        'note' => "Purchase deleted - Ref: {$purchase->reference_number}",
                    ]);
                }
            }
            
            // Delete related records
            $purchase->payments()->delete();
            $purchase->items()->delete();
            $purchase->delete();
            
            DB::commit();
            
            return redirect()->route('admin.purchases.index')
                ->with('success', 'Purchase deleted and stock reversed successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete purchase: ' . $e->getMessage());
        }
    }
    
    /**
     * Add payment to existing purchase
     */
    public function addPayment(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $purchase->due_amount,
            'payment_method' => 'required|in:cash,card,bank_transfer,upi,cheque',
            'payment_date' => 'required|date',
            'note' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Create payment
            Payment::create([
                'purchase_id' => $purchase->id,
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'payment_date' => $validated['payment_date'],
                'note' => $validated['note'],
            ]);
            
            // Update purchase amounts
            $purchase->paid_amount += $validated['amount'];
            $purchase->due_amount -= $validated['amount'];
            
            // Update payment status
            if ($purchase->due_amount <= 0) {
                $purchase->payment_status = 'paid';
            } else {
                $purchase->payment_status = 'partial';
            }
            
            $purchase->save();
            
            DB::commit();
            
            return back()->with('success', 'Payment added successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add payment: ' . $e->getMessage());
        }
    }
    
    /**
     * Generate unique reference number
     */
    private function generateReferenceNumber()
    {
        $prefix = 'PUR';
        $date = date('Ymd');
        $random = strtoupper(substr(md5(uniqid()), 0, 4));
        $reference = $prefix . '-' . $date . '-' . $random;
        
        // Ensure uniqueness
        while (Purchase::where('reference_number', $reference)->exists()) {
            $random = strtoupper(substr(md5(uniqid()), 0, 4));
            $reference = $prefix . '-' . $date . '-' . $random;
        }
        
        return $reference;
    }
}