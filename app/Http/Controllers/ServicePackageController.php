<?php

namespace App\Http\Controllers;

use App\Models\ServicePackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServicePackageController extends Controller
{
    public function index(): View
    {
        $packages = ServicePackage::withCount('subscriptions')->latest()->paginate(15);
        return view('service-packages.index', compact('packages'));
    }

    public function create(): View
    {
        return view('service-packages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        ServicePackage::create($validated);

        return redirect()->route('service-packages.index')
            ->with('success', 'Paket layanan berhasil ditambahkan.');
    }

    public function edit(ServicePackage $servicePackage): View
    {
        return view('service-packages.edit', compact('servicePackage'));
    }

    public function update(Request $request, ServicePackage $servicePackage): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $servicePackage->update($validated);

        return redirect()->route('service-packages.index')
            ->with('success', 'Paket layanan berhasil diperbarui.');
    }

    public function destroy(ServicePackage $servicePackage): RedirectResponse
    {
        $servicePackage->delete();
        return redirect()->route('service-packages.index')
            ->with('success', 'Paket layanan berhasil dihapus.');
    }
}
