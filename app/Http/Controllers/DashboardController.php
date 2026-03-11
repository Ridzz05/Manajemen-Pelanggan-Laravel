<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Auto-expire subscriptions
        Subscription::where('status', 'active')
            ->where('end_date', '<', now())
            ->update(['status' => 'expired']);

        $stats = [
            'total_customers'    => Customer::count(),
            'active_subs'        => Subscription::where('status', 'active')->count(),
            'expired_subs'       => Subscription::where('status', 'expired')->count(),
            'expiring_soon'      => Subscription::expiringSoon(7)->count(),
            'total_revenue'      => Payment::paid()->sum('amount'),
            'pending_payments'   => Payment::pending()->count(),
        ];

        $recentSubscriptions = Subscription::with(['customer', 'servicePackage'])
            ->latest()
            ->take(5)
            ->get();

        $recentPayments = Payment::with(['subscription.customer'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentSubscriptions', 'recentPayments'));
    }
}
