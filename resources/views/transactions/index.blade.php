@extends('layouts.admin')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')
@section('page-subtitle', 'transactions.index')

@section('content')
<div style="display:flex;flex-direction:column;gap:20px;">

    {{-- Stats --}}
    <div class="r-grid-stats" style="background:var(--border);border:1px solid var(--border);">
        <div style="background:var(--bg-surface);padding:16px 18px;">
            <p style="font-size:10px;color:var(--text-dim);letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:8px;">Total Transaksi</p>
            <p style="font-size:24px;font-weight:700;color:var(--text-primary);font-variant-numeric:tabular-nums;">{{ number_format($stats['total_transactions']) }}</p>
        </div>
        <div style="background:var(--bg-surface);padding:16px 18px;">
            <p style="font-size:10px;color:var(--text-dim);letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:8px;">Total Revenue</p>
            <p style="font-size:18px;font-weight:700;color:var(--text-primary);font-variant-numeric:tabular-nums;">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
        </div>
        <div style="background:var(--bg-surface);padding:16px 18px;">
            <p style="font-size:10px;color:var(--text-dim);letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:8px;">Hari Ini</p>
            <p style="font-size:24px;font-weight:700;color:var(--text-primary);font-variant-numeric:tabular-nums;">{{ number_format($stats['today_transactions']) }}</p>
        </div>
        <div style="background:var(--bg-surface);padding:16px 18px;">
            <p style="font-size:10px;color:var(--text-dim);letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:8px;">Revenue Hari Ini</p>
            <p style="font-size:18px;font-weight:700;color:var(--text-primary);font-variant-numeric:tabular-nums;">Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Search --}}
    <div class="r-flex-toolbar" style="flex-wrap:wrap;">
        <form method="GET" style="display:flex;gap:8px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari invoice / pelanggan..." style="padding:6px 12px;width:250px;">
            <select name="status" style="padding:6px 12px;">
                <option value="">Semua Status</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Lunas</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Gagal</option>
            </select>
            <button type="submit" class="btn-secondary" style="padding:6px 14px;">Filter</button>
        </form>
    </div>

    {{-- Table --}}
    <div class="r-table-wrap" style="border:1px solid var(--border);background:var(--bg-surface);">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid var(--border);">
                    <th style="text-align:left;padding:12px 18px;">Invoice</th>
                    <th style="text-align:left;padding:12px 18px;">Pelanggan</th>
                    <th style="text-align:left;padding:12px 18px;">Metode</th>
                    <th style="text-align:right;padding:12px 18px;">Total</th>
                    <th style="text-align:center;padding:12px 18px;">Status</th>
                    <th style="text-align:right;padding:12px 18px;">Tanggal</th>
                    <th style="text-align:right;padding:12px 18px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr style="border-bottom:1px solid var(--border-dim);">
                    <td style="padding:12px 18px;font-size:12px;color:var(--text-primary);font-family:'JetBrains Mono',monospace;font-weight:500;">{{ $trx->invoice_number }}</td>
                    <td style="padding:12px 18px;font-size:13px;color:var(--text-secondary);">{{ $trx->customer->name ?? 'Umum' }}</td>
                    <td style="padding:12px 18px;font-size:12px;color:var(--text-muted);">{{ $trx->payment_method }}</td>
                    <td style="padding:12px 18px;text-align:right;font-size:13px;font-weight:600;color:var(--text-primary);font-family:'JetBrains Mono',monospace;">{{ $trx->formatted_grand_total }}</td>
                    <td style="padding:12px 18px;text-align:center;">
                        @if($trx->payment_status === 'paid')
                            <span style="font-size:10px;padding:2px 8px;background:var(--bg-primary);color:var(--text-on-primary);font-weight:700;font-family:'JetBrains Mono',monospace;letter-spacing:0.05em;">LUNAS</span>
                        @elseif($trx->payment_status === 'pending')
                            <span style="font-size:10px;padding:2px 8px;border:1px solid var(--border-mid);color:var(--text-muted);font-family:'JetBrains Mono',monospace;">PENDING</span>
                        @else
                            <span style="font-size:10px;padding:2px 8px;border:1px solid var(--border-dim);color:var(--text-dim);font-family:'JetBrains Mono',monospace;">GAGAL</span>
                        @endif
                    </td>
                    <td style="padding:12px 18px;text-align:right;font-size:11px;color:var(--text-muted);font-family:'JetBrains Mono',monospace;">{{ $trx->created_at->format('d.m.Y H:i') }}</td>
                    <td style="padding:12px 18px;text-align:right;">
                        <a href="{{ route('transactions.show', $trx) }}" class="btn-secondary" style="padding:4px 12px;">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:40px;text-align:center;font-size:12px;color:var(--text-dim);font-family:'JetBrains Mono',monospace;">— belum ada transaksi —</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $transactions->links() }}
</div>
@endsection
