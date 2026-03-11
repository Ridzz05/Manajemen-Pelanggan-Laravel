<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ServicePackage;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of subscriptions.
     */
    public function index(Request $request): View
    {
        $query = Subscription::with(['customer', 'servicePackage'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by customer search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('project_name', 'like', "%{$search}%");
            });
        }

        // Auto-update expired subscriptions
        Subscription::where('status', 'active')
            ->where('end_date', '<', now())
            ->update(['status' => 'expired']);

        $subscriptions = $query->paginate(15)->withQueryString();

        $stats = [
            'total'          => Subscription::count(),
            'active'         => Subscription::where('status', 'active')->count(),
            'expired'        => Subscription::where('status', 'expired')->count(),
            'expiring_soon'  => Subscription::expiringSoon(7)->count(),
        ];

        return view('subscriptions.index', compact('subscriptions', 'stats'));
    }

    /**
     * Show the form for creating a new subscription.
     */
    public function create(): View
    {
        $customers = Customer::orderBy('name')->get();
        $packages  = ServicePackage::where('is_active', true)->orderBy('name')->get();

        return view('subscriptions.create', compact('customers', 'packages'));
    }

    /**
     * Store a newly created subscription in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id'        => 'required|exists:customers,id',
            'service_package_id' => 'required|exists:service_packages,id',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after:start_date',
            'notes'              => 'nullable|string|max:1000',
        ]);

        // Auto-determine status
        $validated['status'] = Carbon::parse($validated['end_date'])->isPast()
            ? 'expired'
            : 'active';

        $subscription = Subscription::create($validated);

        return redirect()
            ->route('subscriptions.index')
            ->with('success', "Langganan berhasil ditambahkan untuk {$subscription->customer->name}.");
    }

    /**
     * Display the specified subscription.
     */
    public function show(Subscription $subscription): View
    {
        $subscription->load(['customer', 'servicePackage', 'payments']);

        return view('subscriptions.show', compact('subscription'));
    }

    /**
     * Show the form for editing the specified subscription.
     */
    public function edit(Subscription $subscription): View
    {
        $customers = Customer::orderBy('name')->get();
        $packages  = ServicePackage::where('is_active', true)->orderBy('name')->get();

        return view('subscriptions.edit', compact('subscription', 'customers', 'packages'));
    }

    /**
     * Update the specified subscription in storage.
     */
    public function update(Request $request, Subscription $subscription): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id'        => 'required|exists:customers,id',
            'service_package_id' => 'required|exists:service_packages,id',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after:start_date',
            'status'             => 'required|in:active,expired,cancelled',
            'notes'              => 'nullable|string|max:1000',
        ]);

        $subscription->update($validated);

        return redirect()
            ->route('subscriptions.index')
            ->with('success', 'Data langganan berhasil diperbarui.');
    }

    /**
     * Remove the specified subscription from storage.
     */
    public function destroy(Subscription $subscription): RedirectResponse
    {
        $customerName = $subscription->customer->name;
        $subscription->delete();

        return redirect()
            ->route('subscriptions.index')
            ->with('success', "Langganan {$customerName} berhasil dihapus.");
    }

    /**
     * Renew a subscription by extending the end_date.
     */
    public function renew(Request $request, Subscription $subscription): RedirectResponse
    {
        $validated = $request->validate([
            'duration_months' => 'required|integer|min:1|max:24',
        ]);

        // Extend from end_date (or today if already expired)
        $baseDate = $subscription->end_date->isFuture()
            ? $subscription->end_date
            : now();

        $subscription->update([
            'end_date' => $baseDate->addMonths($validated['duration_months']),
            'status'   => 'active',
        ]);

        return redirect()
            ->route('subscriptions.index')
            ->with('success', "Langganan {$subscription->customer->name} berhasil diperpanjang.");
    }
}
