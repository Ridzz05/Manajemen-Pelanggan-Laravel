<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Subscription::with(['customer', 'category'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('project_name', 'like', "%{$search}%");
            });
        }

        Subscription::where('status', 'active')
            ->where('end_date', '<', now())
            ->update(['status' => 'expired']);

        $subscriptions = $query->paginate(15)->withQueryString();

        $stats = [
            'total'         => Subscription::count(),
            'active'        => Subscription::where('status', 'active')->count(),
            'expired'       => Subscription::where('status', 'expired')->count(),
            'expiring_soon' => Subscription::expiringSoon(7)->count(),
        ];

        return view('subscriptions.index', compact('subscriptions', 'stats'));
    }

    public function create(): View
    {
        $customers  = Customer::orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('subscriptions.create', compact('customers', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'category_id' => 'required|exists:categories,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
            'notes'       => 'nullable|string|max:1000',
        ]);

        $validated['status'] = Carbon::parse($validated['end_date'])->isPast()
            ? 'expired'
            : 'active';

        $subscription = Subscription::create($validated);

        return redirect()
            ->route('subscriptions.index')
            ->with('success', "Langganan berhasil ditambahkan untuk {$subscription->customer->name}.");
    }

    public function show(Subscription $subscription): View
    {
        $subscription->load(['customer', 'category', 'payments']);
        return view('subscriptions.show', compact('subscription'));
    }

    public function edit(Subscription $subscription): View
    {
        $customers  = Customer::orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('subscriptions.edit', compact('subscription', 'customers', 'categories'));
    }

    public function update(Request $request, Subscription $subscription): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'category_id' => 'required|exists:categories,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
            'status'      => 'required|in:active,expired,cancelled',
            'notes'       => 'nullable|string|max:1000',
        ]);

        $subscription->update($validated);

        return redirect()
            ->route('subscriptions.index')
            ->with('success', 'Data langganan berhasil diperbarui.');
    }

    public function destroy(Subscription $subscription): RedirectResponse
    {
        $customerName = $subscription->customer->name;
        $subscription->delete();

        return redirect()
            ->route('subscriptions.index')
            ->with('success', "Langganan {$customerName} berhasil dihapus.");
    }

    public function renew(Request $request, Subscription $subscription): RedirectResponse
    {
        $validated = $request->validate([
            'duration_months' => 'required|integer|min:1|max:24',
        ]);

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
