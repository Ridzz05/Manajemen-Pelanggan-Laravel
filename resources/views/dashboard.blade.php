@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'system.overview')

@section('content')
<div style="display:flex;flex-direction:column;gap:24px;">

    {{-- ── Stats Grid ─────────────────────────────────────── --}}
    <div class="r-grid-stats" style="gap:16px;">

        {{-- Total Pelanggan --}}
        <div class="nb-card" style="background:#fff;">
            <div class="nb-card-header" style="background:#0066FF;color:#fff;">
                <span style="font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Pelanggan</span>
            </div>
            <div style="padding:20px;display:flex;flex-direction:column;gap:4px;">
                <p style="font-size:42px;font-weight:900;color:#000;line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['total_customers']) }}</p>
                <p style="font-size:12px;font-weight:700;color:#000;opacity:0.6;font-family:'Space Mono',monospace;">Total Terdaftar</p>
            </div>
        </div>

        {{-- Total Produk --}}
        <div class="nb-card" style="background:#fff;">
            <div class="nb-card-header" style="background:#FF6B35;color:#fff;">
                <span style="font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Produk</span>
            </div>
            <div style="padding:20px;display:flex;flex-direction:column;gap:4px;">
                <p style="font-size:42px;font-weight:900;color:#000;line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['total_products']) }}</p>
                <p style="font-size:12px;font-weight:700;color:#000;opacity:0.6;font-family:'Space Mono',monospace;">Katalog Item</p>
            </div>
        </div>

        {{-- Sub. Aktif --}}
        <div class="nb-card" style="background:#fff;">
            <div class="nb-card-header" style="background:#00FF85;color:#000;">
                <span style="font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Sub. Aktif</span>
            </div>
            <div style="padding:20px;display:flex;flex-direction:column;gap:4px;">
                <p style="font-size:42px;font-weight:900;color:#000;line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['active_subs']) }}</p>
                <p style="font-size:12px;font-weight:700;color:#000;opacity:0.6;font-family:'Space Mono',monospace;">Langganan Berjalan</p>
            </div>
        </div>

        {{-- Transaksi Hari Ini --}}
        <div class="nb-card" style="background:#fff;">
            <div class="nb-card-header" style="background:#FF90E8;color:#000;">
                <span style="font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Trx Hari Ini</span>
            </div>
            <div style="padding:20px;display:flex;flex-direction:column;gap:4px;">
                <p style="font-size:42px;font-weight:900;color:#000;line-height:1;font-variant-numeric:tabular-nums;">{{ number_format($stats['today_transactions']) }}</p>
                <p style="font-size:12px;font-weight:700;color:#000;opacity:0.6;font-family:'Space Mono',monospace;">Transaksi Baru</p>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div class="nb-card" style="background:#FFDD00;">
            <div class="nb-card-header" style="background:#000;color:#FFDD00;">
                <span style="font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Total Revenue</span>
            </div>
            <div style="padding:20px;display:flex;flex-direction:column;gap:6px;">
                <p style="font-size:24px;font-weight:900;color:#000;line-height:1;font-variant-numeric:tabular-nums;">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                <p style="font-size:12px;font-weight:700;color:#000;opacity:0.6;font-family:'Space Mono',monospace;">Semua Waktu</p>
            </div>
        </div>

        {{-- Revenue Hari Ini --}}
        <div class="nb-card" style="background:#fff;">
            <div class="nb-card-header" style="background:#FF3B3B;color:#fff;">
                <span style="font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Rev. Hari Ini</span>
            </div>
            <div style="padding:20px;display:flex;flex-direction:column;gap:6px;">
                <p style="font-size:24px;font-weight:900;color:#000;line-height:1;font-variant-numeric:tabular-nums;">Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</p>
                <p style="font-size:12px;font-weight:700;color:#000;opacity:0.6;font-family:'Space Mono',monospace;">{{ now()->format('d M Y') }}</p>
            </div>
        </div>

    </div>

    {{-- ── Recent Tables ───────────────────────────────────── --}}
    <div class="r-grid-recent" style="gap:24px;">

        {{-- Recent Transactions --}}
        <div class="nb-card">
            <div class="nb-card-header" style="background:#000;color:#FFDD00;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Transaksi Terbaru</span>
                <a href="{{ route('transactions.index') }}" class="btn-nb btn-secondary" style="padding:4px 10px;font-size:11px;background:#FFDD00;color:#000;border:2px solid #FFDD00;">
                    Lihat Semua →
                </a>
            </div>
            <div class="r-table-wrap">
                <table style="width:100%;border-collapse:collapse;">
                    <tbody>
                        @forelse($recentTransactions as $trx)
                            <tr style="border-bottom:3px solid #000;">
                                <td style="padding:16px 20px;">
                                    <p style="font-size:14px;font-weight:800;color:#000;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $trx->customer->name ?? 'Umum' }}</p>
                                    <p style="font-size:12px;font-weight:600;color:#444;margin-top:2px;font-family:'Space Mono',monospace;">{{ $trx->invoice_number }}</p>
                                </td>
                                <td style="padding:16px 20px;text-align:right;">
                                    <p style="font-size:15px;font-weight:900;color:#000;">{{ $trx->formatted_grand_total }}</p>
                                    @if($trx->payment_status === 'paid')
                                        <span class="badge badge-success" style="margin-top:4px;display:inline-block;">LUNAS</span>
                                    @elseif($trx->payment_status === 'pending')
                                        <span class="badge badge-warning" style="margin-top:4px;display:inline-block;">PENDING</span>
                                    @else
                                        <span class="badge badge-danger" style="margin-top:4px;display:inline-block;">GAGAL</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" style="font-size:13px;font-weight:700;color:#888;text-align:center;padding:48px;font-family:'Space Mono',monospace;text-transform:uppercase;letter-spacing:0.05em;">— Kosong —</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Subscriptions --}}
        <div class="nb-card">
            <div class="nb-card-header" style="background:#0066FF;color:#fff;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Subscription Terbaru</span>
                <a href="{{ route('subscriptions.index') }}" class="btn-nb btn-secondary" style="padding:4px 10px;font-size:11px;background:#fff;color:#0066FF;border:2px solid #fff;">
                    Lihat Semua →
                </a>
            </div>
            <div class="r-table-wrap">
                <table style="width:100%;border-collapse:collapse;">
                    <tbody>
                        @forelse($recentSubscriptions as $sub)
                            <tr style="border-bottom:3px solid #000;">
                                <td style="padding:16px 20px;">
                                    <p style="font-size:14px;font-weight:800;color:#000;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $sub->customer->name }}</p>
                                    <p style="font-size:12px;font-weight:600;color:#444;margin-top:2px;font-family:'Space Mono',monospace;">{{ $sub->category->name ?? '-' }}</p>
                                </td>
                                <td style="padding:16px 20px;text-align:right;">
                                    @if($sub->status === 'active')
                                        <span class="badge badge-success" style="display:inline-block;">AKTIF</span>
                                    @else
                                        <span class="badge badge-muted" style="display:inline-block;">EXPIRED</span>
                                    @endif
                                    <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;margin-top:6px;font-family:'Space Mono',monospace;">{{ $sub->end_date->format('d.m.Y') }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" style="font-size:13px;font-weight:700;color:#888;text-align:center;padding:48px;font-family:'Space Mono',monospace;text-transform:uppercase;letter-spacing:0.05em;">— Kosong —</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
