@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'system.overview')

@section('content')
<div style="display:flex;flex-direction:column;gap:20px;">

    {{-- ── Stats Grid ───────────────────────────────────────────────── --}}
    <div class="r-grid-stats" style="background:var(--border);border:1px solid var(--border);">

        {{-- Total Pelanggan --}}
        <div style="background:var(--bg-surface);padding:20px 22px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;color:var(--text-dim);">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                </svg>
                <span style="font-size:10px;color:var(--text-dim);letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">Pelanggan</span>
            </div>
            <p style="font-size:32px;font-weight:700;color:var(--text-primary);line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['total_customers']) }}</p>
        </div>

        {{-- Total Produk --}}
        <div style="background:var(--bg-surface);padding:20px 22px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;color:var(--text-dim);">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/>
                </svg>
                <span style="font-size:10px;color:var(--text-dim);letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">Produk</span>
            </div>
            <p style="font-size:32px;font-weight:700;color:var(--text-primary);line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['total_products']) }}</p>
        </div>

        {{-- Sub. Aktif --}}
        <div style="background:var(--bg-surface);padding:20px 22px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;color:var(--text-dim);">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <span style="font-size:10px;color:var(--text-dim);letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">Sub. Aktif</span>
            </div>
            <p style="font-size:32px;font-weight:700;color:var(--text-primary);line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['active_subs']) }}</p>
        </div>

        {{-- Transaksi Hari Ini --}}
        <div style="background:var(--bg-surface);padding:20px 22px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;color:var(--text-dim);">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                </svg>
                <span style="font-size:10px;color:var(--text-dim);letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">Trx Hari Ini</span>
            </div>
            <p style="font-size:32px;font-weight:700;color:var(--text-primary);line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['today_transactions']) }}</p>
        </div>

        {{-- Revenue --}}
        <div style="background:var(--bg-surface);padding:20px 22px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;color:var(--text-dim);">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/>
                </svg>
                <span style="font-size:10px;color:var(--text-dim);letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">Total Revenue</span>
            </div>
            <p style="font-size:22px;font-weight:700;color:var(--text-primary);line-height:1;font-variant-numeric:tabular-nums;">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
        </div>

        {{-- Revenue Hari Ini --}}
        <div style="background:var(--bg-surface);padding:20px 22px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;color:var(--text-dim);">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <span style="font-size:10px;color:var(--text-dim);letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">Revenue Hari Ini</span>
            </div>
            <p style="font-size:22px;font-weight:700;color:var(--text-primary);line-height:1;font-variant-numeric:tabular-nums;">Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</p>
        </div>

    </div>

    {{-- ── Recent Tables ────────────────────────────────────────────── --}}
    <div class="r-grid-recent">

        {{-- Recent Transactions --}}
        <div style="border:1px solid var(--border);background:var(--bg-surface);">
            <div style="padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-secondary);">Transaksi Terbaru</span>
                <a href="{{ route('transactions.index') }}" style="font-size:11px;color:var(--text-dim);text-decoration:none;font-family:'JetBrains Mono',monospace;letter-spacing:0.05em;">
                    lihat semua →
                </a>
            </div>
            @forelse($recentTransactions as $trx)
                <div style="padding:12px 18px;border-bottom:1px solid var(--border-dim);display:flex;align-items:center;justify-content:space-between;gap:12px;">
                    <div style="min-width:0;">
                        <p style="font-size:13px;font-weight:500;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $trx->customer->name ?? 'Umum' }}</p>
                        <p style="font-size:11px;color:var(--text-dim);margin-top:1px;font-family:'JetBrains Mono',monospace;">{{ $trx->invoice_number }}</p>
                    </div>
                    <div style="text-align:right;flex-shrink:0;">
                        <p style="font-size:13px;font-weight:600;color:var(--text-primary);">{{ $trx->formatted_grand_total }}</p>
                        <span style="font-size:10px;padding:2px 8px;background:var(--bg-primary);color:var(--text-on-primary);font-weight:700;font-family:'JetBrains Mono',monospace;letter-spacing:0.05em;">LUNAS</span>
                    </div>
                </div>
            @empty
                <p style="font-size:12px;color:var(--text-dim);text-align:center;padding:24px;font-family:'JetBrains Mono',monospace;">— kosong —</p>
            @endforelse
        </div>

        {{-- Recent Subscriptions --}}
        <div style="border:1px solid var(--border);background:var(--bg-surface);">
            <div style="padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-secondary);">Subscription Terbaru</span>
                <a href="{{ route('subscriptions.index') }}" style="font-size:11px;color:var(--text-dim);text-decoration:none;font-family:'JetBrains Mono',monospace;letter-spacing:0.05em;">
                    lihat semua →
                </a>
            </div>
            @forelse($recentSubscriptions as $sub)
                <div style="padding:12px 18px;border-bottom:1px solid var(--border-dim);display:flex;align-items:center;justify-content:space-between;gap:12px;">
                    <div style="min-width:0;">
                        <p style="font-size:13px;font-weight:500;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $sub->customer->name }}</p>
                        <p style="font-size:11px;color:var(--text-dim);margin-top:1px;font-family:'JetBrains Mono',monospace;">{{ $sub->category->name ?? '-' }}</p>
                    </div>
                    <div style="text-align:right;flex-shrink:0;">
                        @if($sub->status === 'active')
                            <span style="font-size:10px;padding:2px 8px;border:1px solid var(--border-mid);color:var(--text-secondary);font-family:'JetBrains Mono',monospace;letter-spacing:0.05em;">AKTIF</span>
                        @else
                            <span style="font-size:10px;padding:2px 8px;border:1px solid var(--border-dim);color:var(--text-dim);font-family:'JetBrains Mono',monospace;letter-spacing:0.05em;">EXPIRED</span>
                        @endif
                        <p style="font-size:10px;color:var(--text-dim);margin-top:4px;font-family:'JetBrains Mono',monospace;">{{ $sub->end_date->format('d.m.Y') }}</p>
                    </div>
                </div>
            @empty
                <p style="font-size:12px;color:var(--text-dim);text-align:center;padding:24px;font-family:'JetBrains Mono',monospace;">— kosong —</p>
            @endforelse
        </div>

    </div>
</div>
@endsection
