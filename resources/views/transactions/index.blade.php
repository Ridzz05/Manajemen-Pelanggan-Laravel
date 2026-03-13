@extends('layouts.admin')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')
@section('page-subtitle', 'transactions.index')

@section('content')
<div style="display:flex;flex-direction:column;gap:20px;">

    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;">
        <div class="nb-card">
            <div style="background:#000;padding:10px 16px;border-bottom:2.5px solid #000;">
                <span style="font-size:10px;font-weight:700;color:#FFDD00;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Total Transaksi</span>
            </div>
            <div style="padding:14px 18px;">
                <p style="font-size:30px;font-weight:800;color:#000;font-variant-numeric:tabular-nums;">{{ number_format($stats['total_transactions']) }}</p>
            </div>
        </div>
        <div class="nb-card" style="background:#FFDD00;">
            <div style="background:#000;padding:10px 16px;border-bottom:2.5px solid #000;">
                <span style="font-size:10px;font-weight:700;color:#FFDD00;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Total Revenue</span>
            </div>
            <div style="padding:14px 18px;">
                <p style="font-size:20px;font-weight:800;color:#000;font-variant-numeric:tabular-nums;">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="nb-card">
            <div style="background:#0066FF;padding:10px 16px;border-bottom:2.5px solid #000;">
                <span style="font-size:10px;font-weight:700;color:#fff;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Hari Ini</span>
            </div>
            <div style="padding:14px 18px;">
                <p style="font-size:30px;font-weight:800;color:#000;font-variant-numeric:tabular-nums;">{{ number_format($stats['today_transactions']) }}</p>
            </div>
        </div>
        <div class="nb-card">
            <div style="background:#00FF85;padding:10px 16px;border-bottom:2.5px solid #000;">
                <span style="font-size:10px;font-weight:700;color:#000;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Rev. Hari Ini</span>
            </div>
            <div style="padding:14px 18px;">
                <p style="font-size:18px;font-weight:800;color:#000;font-variant-numeric:tabular-nums;">Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Search / Filter --}}
    <div class="nb-toolbar">
        <div class="nb-toolbar-left">
            <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari invoice / pelanggan..." style="width:220px;">
                <select name="status" style="width:155px;">
                    <option value="">Semua Status</option>
                    <option value="paid"    {{ request('status') === 'paid'    ? 'selected' : '' }}>Lunas</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed"  {{ request('status') === 'failed'  ? 'selected' : '' }}>Gagal</option>
                </select>
                <button type="submit" class="btn-nb btn-secondary">Filter</button>
                @if(request('search') || request('status'))
                    <a href="{{ route('transactions.index') }}" class="btn-nb btn-secondary">✕ Reset</a>
                @endif
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="nb-card">
        <div class="nb-card-header" style="background:#000;color:#FFDD00;">
            <span>Riwayat Transaksi Kasir</span>
        </div>
        <div class="r-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Pelanggan</th>
                        <th class="r-hide-mobile">Metode</th>
                        <th style="text-align:right;">Total</th>
                        <th style="text-align:center;">Status</th>
                        <th class="r-hide-mobile" style="text-align:right;">Tanggal</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $trx)
                    <tr>
                        <td style="font-size:12px;font-family:'Space Mono',monospace;font-weight:700;">{{ $trx->invoice_number }}</td>
                        <td style="font-weight:600;font-size:13px;">{{ $trx->customer->name ?? 'Umum' }}</td>
                        <td class="r-hide-mobile" style="font-size:12px;color:#888;font-family:'Space Mono',monospace;">{{ $trx->payment_method }}</td>
                        <td style="text-align:right;font-weight:800;font-size:13px;font-family:'Space Mono',monospace;white-space:nowrap;">{{ $trx->formatted_grand_total }}</td>
                        <td style="text-align:center;">
                            @if($trx->payment_status === 'paid')
                                <span class="badge badge-success">LUNAS</span>
                            @elseif($trx->payment_status === 'pending')
                                <span class="badge badge-warning">PENDING</span>
                            @else
                                <span class="badge badge-danger">GAGAL</span>
                            @endif
                        </td>
                        <td class="r-hide-mobile" style="text-align:right;font-size:11px;color:#888;font-family:'Space Mono',monospace;white-space:nowrap;">{{ $trx->created_at->format('d.m.Y H:i') }}</td>
                        <td style="text-align:right;">
                            <a href="{{ route('transactions.show', $trx) }}" class="btn-nb btn-secondary btn-sm">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding:48px;text-align:center;">
                            <p style="font-size:14px;color:#aaa;font-weight:600;">Belum ada transaksi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:14px 18px;border-top:2.5px solid #000;background:#FFFBF0;">
            {{ $transactions->links() }}
        </div>
    </div>

</div>
@endsection
