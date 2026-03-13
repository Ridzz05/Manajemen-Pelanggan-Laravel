<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $query = Customer::withCount('subscriptions');

        if ($request->has('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('telegram_user_id', 'like', "%{$request->search}%")
                  ->orWhere('project_name', 'like', "%{$request->search}%");
        }

        $customers = $query->latest()
            ->paginate(15)
            ->withQueryString();

        return view('customers.index', compact('customers'));
    }

    public function create(): View
    {
        return view('customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'telegram_user_id' => 'required|string|unique:customers,telegram_user_id|max:255',
            'phone'        => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'project_name' => 'required|string|max:255',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Pelanggan baru berhasil ditambahkan.');
    }

    public function show(Customer $customer): View
    {
        $customer->load(['subscriptions.servicePackage', 'subscriptions.payments']);
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer): View
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'telegram_user_id' => "required|string|unique:customers,telegram_user_id,{$customer->id}|max:255",
            'phone'        => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'project_name' => 'required|string|max:255',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}
