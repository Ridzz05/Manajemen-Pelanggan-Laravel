<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $transactions = Transaction::with('customer')
            ->when($request->filled('search'), fn($q) =>
                $q->where('invoice_number', 'like', "%{$request->search}%")
                  ->orWhereHas('customer', fn($c) =>
                      $c->where('name', 'like', "%{$request->search}%")
                  )
            )
            ->when($request->filled('status'), fn($q) =>
                $q->where('payment_status', $request->status)
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total_transactions' => Transaction::count(),
            'total_revenue'      => Transaction::paid()->sum('grand_total'),
            'today_transactions' => Transaction::today()->count(),
            'today_revenue'      => Transaction::today()->paid()->sum('grand_total'),
        ];

        return view('transactions.index', compact('transactions', 'stats'));
    }

    public function show(Transaction $transaction): View
    {
        $transaction->load(['customer', 'items.product']);
        return view('transactions.show', compact('transaction'));
    }
}
