@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'system.overview')

@section('content')
<div style="display:flex;flex-direction:column;gap:24px;">

    {{-- ── Stats Grid ─────────────────────────────────────── --}}
    <div class="r-grid-stats" style="gap:14px;">

        {{-- Total Pelanggan --}}
        <div class="nb-card" style="background:#fff;">
            <div style="background:#0066FF;padding:10px 16px;border-bottom:2.5px solid #000;">
                <span style="font-size:10px;font-weight:700;color:#fff;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Pelanggan</span>
            </div>
            <div style="padding:16px 18px;">
                <p style="font-size:36px;font-weight:800;color:#000;line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['total_customers']) }}</p>
                <p style="font-size:11px;color:#888;margin-top:4px;font-family:'Space Mono',monospace;">total terdaftar</p>
            </div>
        </div>

        {{-- Total Produk --}}
        <div class="nb-card" style="background:#fff;">
            <div style="background:#FF6B35;padding:10px 16px;border-bottom:2.5px solid #000;">
                <span style="font-size:10px;font-weight:700;color:#fff;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Produk</span>
            </div>
            <div style="padding:16px 18px;">
                <p style="font-size:36px;font-weight:800;color:#000;line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['total_products']) }}</p>
                <p style="font-size:11px;color:#888;margin-top:4px;font-family:'Space Mono',monospace;">item di katalog</p>
            </div>
        </div>

        {{-- Sub. Aktif --}}
        <div class="nb-card" style="background:#fff;">
            <div style="background:#00FF85;padding:10px 16px;border-bottom:2.5px solid #000;">
                <span style="font-size:10px;font-weight:700;color:#000;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Sub. Aktif</span>
            </div>
            <div style="padding:16px 18px;">
                <p style="font-size:36px;font-weight:800;color:#000;line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['active_subs']) }}</p>
                <p style="font-size:11px;color:#888;margin-top:4px;font-family:'Space Mono',monospace;">berlangganan aktif</p>
            </div>
        </div>

        {{-- Transaksi Hari Ini --}}
        <div class="nb-card" style="background:#fff;">
            <div style="background:#FF90E8;padding:10px 16px;border-bottom:2.5px solid #000;">
                <span style="font-size:10px;font-weight:700;color:#000;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Trx Hari Ini</span>
            </div>
            <div style="padding:16px 18px;">
                <p style="font-size:36px;font-weight:800;color:#000;line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['today_transactions']) }}</p>
                <p style="font-size:11px;color:#888;margin-top:4px;font-family:'Space Mono',monospace;">transaksi kasir</p>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div class="nb-card" style="background:#FFDD00;">
            <div style="background:#000;padding:10px 16px;border-bottom:2.5px solid #000;">
                <span style="font-size:10px;font-weight:700;color:#FFDD00;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Total Revenue</span>
            </div>
            <div style="padding:16px 18px;">
                <p style="font-size:22px;font-weight:800;color:#000;line-height:1;font-variant-numeric:tabular-nums;">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                <p style="font-size:11px;color:#555;margin-top:4px;font-family:'Space Mono',monospace;">semua waktu</p>
            </div>
        </div>

        {{-- Revenue Hari Ini --}}
        <div class="nb-card" style="background:#fff;">
            <div style="background:#FF3B3B;padding:10px 16px;border-bottom:2.5px solid #000;">
                <span style="font-size:10px;font-weight:700;color:#fff;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Rev. Hari Ini</span>
            </div>
            <div style="padding:16px 18px;">
                <p style="font-size:22px;font-weight:800;color:#000;line-height:1;font-variant-numeric:tabular-nums;">Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</p>
                <p style="font-size:11px;color:#888;margin-top:4px;font-family:'Space Mono',monospace;">{{ now()->format('d M Y') }}</p>
            </div>
        </div>

    </div>

    {{-- ── Recent Tables ───────────────────────────────────── --}}
    <div class="r-grid-recent">

        {{-- Recent Transactions --}}
        <div class="nb-card">
            <div class="nb-card-header" style="background:#000;color:#FFDD00;">
                <span>Transaksi Terbaru</span>
                <a href="{{ route('transactions.index') }}" style="font-size:11px;color:#FFDD00;text-decoration:none;font-family:'Space Mono',monospace;opacity:0.7;">lihat semua →</a>
            </div>
            <div class="r-table-wrap">
                @forelse($recentTransactions as $trx)
                    <div style="padding:12px 16px;border-bottom:1.5px solid #000;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                        <div style="min-width:0;">
                            <p style="font-size:13px;font-weight:700;color:#000;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $trx->customer->name ?? 'Umum' }}</p>
                            <p style="font-size:11px;color:#888;margin-top:1px;font-family:'Space Mono',monospace;">{{ $trx->invoice_number }}</p>
                        </div>
                        <div style="text-align:right;flex-shrink:0;">
                            <p style="font-size:13px;font-weight:800;color:#000;">{{ $trx->formatted_grand_total }}</p>
                            <span class="badge badge-success" style="margin-top:2px;">LUNAS</span>
                        </div>
                    </div>
                @empty
                    <p style="font-size:12px;color:#aaa;text-align:center;padding:24px;font-family:'Space Mono',monospace;">— kosong —</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Subscriptions --}}
        <div class="nb-card">
            <div class="nb-card-header" style="background:#0066FF;color:#fff;">
                <span>Subscription Terbaru</span>
                <a href="{{ route('subscriptions.index') }}" style="font-size:11px;color:#fff;text-decoration:none;font-family:'Space Mono',monospace;opacity:0.7;">lihat semua →</a>
            </div>
            <div class="r-table-wrap">
                @forelse($recentSubscriptions as $sub)
                    <div style="padding:12px 16px;border-bottom:1.5px solid #000;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                        <div style="min-width:0;">
                            <p style="font-size:13px;font-weight:700;color:#000;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $sub->customer->name }}</p>
                            <p style="font-size:11px;color:#888;margin-top:1px;font-family:'Space Mono',monospace;">{{ $sub->category->name ?? '-' }}</p>
                        </div>
                        <div style="text-align:right;flex-shrink:0;">
                            @if($sub->status === 'active')
                                <span class="badge badge-success">AKTIF</span>
                            @else
                                <span class="badge badge-muted">EXPIRED</span>
                            @endif
                            <p style="font-size:10px;color:#888;margin-top:4px;font-family:'Space Mono',monospace;">{{ $sub->end_date->format('d.m.Y') }}</p>
                        </div>
                    </div>
                @empty
                    <p style="font-size:12px;color:#aaa;text-align:center;padding:24px;font-family:'Space Mono',monospace;">— kosong —</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
