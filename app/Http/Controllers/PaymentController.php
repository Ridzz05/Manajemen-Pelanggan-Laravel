<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $payments = Payment::with(['subscription.customer', 'subscription.servicePackage'])
            ->when($request->filled('status'), fn($q) =>
                $q->where('payment_status', $request->status)
            )
            ->when($request->filled('method'), fn($q) =>
                $q->where('payment_method', $request->method)
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalRevenue = Payment::paid()->sum('amount');

        return view('payments.index', compact('payments', 'totalRevenue'));
    }

    public function create(Request $request): View
    {
        $subscriptions = Subscription::with('customer')
            ->where('status', 'active')
            ->get();
        $selectedSubscription = $request->filled('subscription_id')
            ? Subscription::with('customer', 'servicePackage')->find($request->subscription_id)
            : null;

        return view('payments.create', compact('subscriptions', 'selectedSubscription'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'amount'          => 'required|numeric|min:0',
            'payment_method'  => 'required|in:QRIS,Transfer Bank,Cash,Virtual Account,E-Wallet',
            'payment_status'  => 'required|in:pending,paid,failed',
            'payment_date'    => 'nullable|date',
            'transaction_ref' => 'nullable|string|max:100',
            'notes'           => 'nullable|string|max:1000',
        ]);

        if ($validated['payment_status'] === 'paid' && empty($validated['payment_date'])) {
            $validated['payment_date'] = now();
        }

        Payment::create($validated);

        return redirect()->route('payments.index')
            ->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function show(Payment $payment): View
    {
        $payment->load(['subscription.customer', 'subscription.servicePackage']);
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment): View
    {
        $subscriptions = Subscription::with('customer')->get();
        return view('payments.edit', compact('payment', 'subscriptions'));
    }

    public function update(Request $request, Payment $payment): RedirectResponse
    {
        $validated = $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'amount'          => 'required|numeric|min:0',
            'payment_method'  => 'required|in:QRIS,Transfer Bank,Cash,Virtual Account,E-Wallet',
            'payment_status'  => 'required|in:pending,paid,failed',
            'payment_date'    => 'nullable|date',
            'transaction_ref' => 'nullable|string|max:100',
            'notes'           => 'nullable|string|max:1000',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.index')
            ->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        $payment->delete();
        return redirect()->route('payments.index')
            ->with('success', 'Data pembayaran berhasil dihapus.');
    }
}
