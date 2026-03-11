@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'system.overview')

@section('content')
<div style="display:flex;flex-direction:column;gap:20px;">

    {{-- ── Stats Grid ───────────────────────────────────────────────── --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1px;background:#1a1a1a;border:1px solid #1a1a1a;">

        {{-- Total Pelanggan --}}
        <div style="background:#000;padding:20px 22px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;color:#444;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                </svg>
                <span style="font-size:10px;color:#444;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">Pelanggan</span>
            </div>
            <p style="font-size:32px;font-weight:700;color:#fff;line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['total_customers']) }}</p>
        </div>

        {{-- Aktif --}}
        <div style="background:#000;padding:20px 22px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;color:#444;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <span style="font-size:10px;color:#444;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">Sub. Aktif</span>
            </div>
            <p style="font-size:32px;font-weight:700;color:#fff;line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['active_subs']) }}</p>
        </div>

        {{-- Segera Berakhir --}}
        <div style="background:#000;padding:20px 22px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;color:#444;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                </svg>
                <span style="font-size:10px;color:#444;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">Berakhir 7d</span>
            </div>
            <p style="font-size:32px;font-weight:700;color:#fff;line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['expiring_soon']) }}</p>
        </div>

        {{-- Kadaluarsa --}}
        <div style="background:#000;padding:20px 22px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;color:#444;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <span style="font-size:10px;color:#444;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">Kadaluarsa</span>
            </div>
            <p style="font-size:32px;font-weight:700;color:#555;line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['expired_subs']) }}</p>
        </div>

        {{-- Revenue --}}
        <div style="background:#000;padding:20px 22px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;color:#444;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/>
                </svg>
                <span style="font-size:10px;color:#444;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">Revenue</span>
            </div>
            <p style="font-size:22px;font-weight:700;color:#fff;line-height:1;font-variant-numeric:tabular-nums;">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
        </div>

        {{-- Pending --}}
        <div style="background:#000;padding:20px 22px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;color:#444;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <span style="font-size:10px;color:#444;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">Pending</span>
            </div>
            <p style="font-size:32px;font-weight:700;color:#555;line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['pending_payments']) }}</p>
        </div>

    </div>

    {{-- ── Recent Tables ────────────────────────────────────────────── --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

        {{-- Recent Subscriptions --}}
        <div style="border:1px solid #1a1a1a;background:#000;">
            <div style="padding:14px 18px;border-bottom:1px solid #1a1a1a;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:#aaa;">Subscription Terbaru</span>
                <a href="{{ route('subscriptions.index') }}" style="font-size:11px;color:#444;text-decoration:none;font-family:'JetBrains Mono',monospace;letter-spacing:0.05em;">
                    lihat semua →
                </a>
            </div>
            @forelse($recentSubscriptions as $sub)
                <div style="padding:12px 18px;border-bottom:1px solid #0f0f0f;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                    <div style="min-width:0;">
                        <p style="font-size:13px;font-weight:500;color:#ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $sub->customer->name }}</p>
                        <p style="font-size:11px;color:#444;margin-top:1px;font-family:'JetBrains Mono',monospace;">{{ $sub->servicePackage->name }}</p>
                    </div>
                    <div style="text-align:right;flex-shrink:0;">
                        @if($sub->status === 'active')
                            <span style="font-size:10px;padding:2px 8px;border:1px solid #333;color:#aaa;font-family:'JetBrains Mono',monospace;letter-spacing:0.05em;">AKTIF</span>
                        @else
                            <span style="font-size:10px;padding:2px 8px;border:1px solid #1a1a1a;color:#333;font-family:'JetBrains Mono',monospace;letter-spacing:0.05em;">EXPIRED</span>
                        @endif
                        <p style="font-size:10px;color:#333;margin-top:4px;font-family:'JetBrains Mono',monospace;">{{ $sub->end_date->format('d.m.Y') }}</p>
                    </div>
                </div>
            @empty
                <p style="font-size:12px;color:#333;text-align:center;padding:24px;font-family:'JetBrains Mono',monospace;">— kosong —</p>
            @endforelse
        </div>

        {{-- Recent Payments --}}
        <div style="border:1px solid #1a1a1a;background:#000;">
            <div style="padding:14px 18px;border-bottom:1px solid #1a1a1a;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:#aaa;">Pembayaran Terbaru</span>
                <a href="{{ route('payments.index') }}" style="font-size:11px;color:#444;text-decoration:none;font-family:'JetBrains Mono',monospace;letter-spacing:0.05em;">
                    lihat semua →
                </a>
            </div>
            @forelse($recentPayments as $payment)
                <div style="padding:12px 18px;border-bottom:1px solid #0f0f0f;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                    <div style="min-width:0;">
                        <p style="font-size:13px;font-weight:500;color:#ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $payment->subscription->customer->name }}</p>
                        <p style="font-size:11px;color:#444;margin-top:1px;font-family:'JetBrains Mono',monospace;">{{ $payment->payment_method }}</p>
                    </div>
                    <div style="text-align:right;flex-shrink:0;">
                        <p style="font-size:13px;font-weight:600;color:#fff;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                        @if($payment->payment_status === 'paid')
                            <span style="font-size:10px;padding:2px 8px;background:#fff;color:#000;font-weight:700;font-family:'JetBrains Mono',monospace;letter-spacing:0.05em;">LUNAS</span>
                        @elseif($payment->payment_status === 'pending')
                            <span style="font-size:10px;padding:2px 8px;border:1px solid #333;color:#555;font-family:'JetBrains Mono',monospace;letter-spacing:0.05em;">PENDING</span>
                        @else
                            <span style="font-size:10px;padding:2px 8px;border:1px solid #1a1a1a;color:#333;font-family:'JetBrains Mono',monospace;letter-spacing:0.05em;">GAGAL</span>
                        @endif
                    </div>
                </div>
            @empty
                <p style="font-size:12px;color:#333;text-align:center;padding:24px;font-family:'JetBrains Mono',monospace;">— kosong —</p>
            @endforelse
        </div>

    </div>
</div>
@endsection
