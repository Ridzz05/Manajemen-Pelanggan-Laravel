<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\Transaction;
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
            'total_products'     => Product::count(),
            'active_subs'        => Subscription::where('status', 'active')->count(),
            'expired_subs'       => Subscription::where('status', 'expired')->count(),
            'expiring_soon'      => Subscription::expiringSoon(7)->count(),
            'total_revenue'      => Transaction::paid()->sum('grand_total') + Payment::paid()->sum('amount'),
            'pending_payments'   => Payment::pending()->count(),
            'today_transactions' => Transaction::today()->count(),
            'today_revenue'      => Transaction::today()->paid()->sum('grand_total'),
        ];

        $recentSubscriptions = Subscription::with(['customer', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $recentPayments = Payment::with(['subscription.customer'])
            ->latest()
            ->take(5)
            ->get();

        $recentTransactions = Transaction::with('customer')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentSubscriptions', 'recentPayments', 'recentTransactions'));
    }
}
