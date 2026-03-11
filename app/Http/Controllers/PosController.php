<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PosController extends Controller
{
    /**
     * Display the POS interface.
     */
    public function index(): View
    {
        $products   = Product::with('category')->active()->inStock()->orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $customers  = Customer::orderBy('name')->get();

        return view('pos.index', compact('products', 'categories', 'customers'));
    }

    /**
     * Process a POS transaction.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id'        => 'nullable|exists:customers,id',
            'payment_method'     => 'required|in:QRIS,Transfer Bank,Cash,Virtual Account,E-Wallet',
            'discount'           => 'nullable|numeric|min:0',
            'notes'              => 'nullable|string|max:1000',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        try {
            $transaction = DB::transaction(function () use ($validated) {
                $totalAmount = 0;
                $itemsData   = [];

                // Calculate totals and validate stock
                foreach ($validated['items'] as $item) {
                    $product = Product::findOrFail($item['product_id']);

                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Stok {$product->name} tidak mencukupi. Tersisa: {$product->stock}");
                    }

                    $subtotal = $product->price * $item['quantity'];
                    $totalAmount += $subtotal;

                    $itemsData[] = [
                        'product_id'   => $product->id,
                        'product_name' => $product->name,
                        'price'        => $product->price,
                        'quantity'     => $item['quantity'],
                        'subtotal'     => $subtotal,
                    ];

                    // Reduce stock
                    $product->decrement('stock', $item['quantity']);
                }

                $discount   = $validated['discount'] ?? 0;
                $grandTotal = max(0, $totalAmount - $discount);

                // Create transaction
                $transaction = Transaction::create([
                    'customer_id'    => $validated['customer_id'] ?? null,
                    'total_amount'   => $totalAmount,
                    'discount'       => $discount,
                    'grand_total'    => $grandTotal,
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => 'paid',
                    'notes'          => $validated['notes'] ?? null,
                ]);

                // Create transaction items
                $transaction->items()->createMany($itemsData);

                return $transaction;
            });

            return redirect()->route('pos.receipt', $transaction)
                ->with('success', 'Transaksi berhasil! Invoice: ' . $transaction->invoice_number);

        } catch (\Exception $e) {
            return redirect()->route('pos.index')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display receipt for a transaction.
     */
    public function receipt(Transaction $transaction): View
    {
        $transaction->load(['customer', 'items.product']);
        return view('pos.receipt', compact('transaction'));
    }
}
