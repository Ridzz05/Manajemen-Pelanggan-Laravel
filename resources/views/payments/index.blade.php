@extends('layouts.admin')
@section('title', 'Pembayaran')
@section('page-title', 'Pembayaran')
@section('page-subtitle', 'payment.management')

@section('content')
<div style="display:flex;flex-direction:column;gap:20px;">

    {{-- Revenue Stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px;">
        <div class="nb-card" style="background:#FFDD00;">
            <div style="padding:14px 18px;">
                <p style="font-size:10px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;color:#333;margin-bottom:6px;">Total Revenue</p>
                <p style="font-size:24px;font-weight:800;color:#000;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="nb-card">
            <div style="padding:14px 18px;">
                <p style="font-size:10px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;color:#888;margin-bottom:6px;">Total Transaksi</p>
                <p style="font-size:24px;font-weight:800;color:#000;">{{ $payments->total() }}</p>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="nb-toolbar">
        <div class="nb-toolbar-left">
            <form method="GET" action="{{ route('payments.index') }}" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <select name="status" onchange="this.form.submit()" style="width:160px;">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status')==='pending' ? 'selected':'' }}>Pending</option>
                    <option value="paid"    {{ request('status')==='paid'    ? 'selected':'' }}>Lunas</option>
                    <option value="failed"  {{ request('status')==='failed'  ? 'selected':'' }}>Gagal</option>
                </select>
                <select name="method" onchange="this.form.submit()" style="width:160px;">
                    <option value="">Semua Metode</option>
                    @foreach(\App\Models\Payment::PAYMENT_METHODS as $m)
                        <option value="{{ $m }}" {{ request('method')===$m ? 'selected':'' }}>{{ $m }}</option>
                    @endforeach
                </select>
                @if(request('status') || request('method'))
                    <a href="{{ route('payments.index') }}" class="btn-nb btn-secondary">✕ Reset</a>
                @endif
            </form>
        </div>
        <a href="{{ route('payments.create') }}" class="btn-nb btn-primary">
            <i class="ti ti-plus"></i>
            Catat Pembayaran
        </a>
    </div>

    {{-- Table --}}
    <div class="nb-card">
        <div class="nb-card-header" style="background:#000;color:#FFDD00;">
            <span>Daftar Pembayaran</span>
            <span style="font-size:11px;font-family:'Space Mono',monospace;opacity:.7;">{{ $payments->total() }} total</span>
        </div>
        <div class="r-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pelanggan</th>
                        <th>Nominal</th>
                        <th class="r-hide-mobile">Metode</th>
                        <th class="r-hide-mobile">Ref.</th>
                        <th class="r-hide-mobile">Tanggal</th>
                        <th>Status</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $pay)
                        <tr>
                            <td style="font-size:11px;color:#888;font-family:'Space Mono',monospace;">
                                {{ str_pad($payments->firstItem() + $loop->index, 2, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>
                                <p style="font-size:13px;font-weight:700;color:#000;">{{ $pay->subscription->customer->name ?? '—' }}</p>
                                <p style="font-size:11px;color:#888;margin-top:2px;font-family:'Space Mono',monospace;">{{ $pay->subscription->category->name ?? '—' }}</p>
                            </td>
                            <td style="font-size:14px;font-weight:800;font-family:'Space Mono',monospace;white-space:nowrap;">
                                Rp {{ number_format($pay->amount, 0, ',', '.') }}
                            </td>
                            <td class="r-hide-mobile" style="font-size:12px;font-family:'Space Mono',monospace;color:#555;">{{ $pay->payment_method }}</td>
                            <td class="r-hide-mobile" style="font-size:11px;font-family:'Space Mono',monospace;color:#888;">{{ $pay->transaction_ref ?? '—' }}</td>
                            <td class="r-hide-mobile" style="font-size:12px;font-family:'Space Mono',monospace;color:#555;white-space:nowrap;">
                                {{ $pay->payment_date ? $pay->payment_date->format('d.m.Y') : '—' }}
                            </td>
                            <td>
                                @if($pay->payment_status === 'paid')
                                    <span class="badge badge-success">LUNAS</span>
                                @elseif($pay->payment_status === 'pending')
                                    <span class="badge badge-warning">PENDING</span>
                                @else
                                    <span class="badge badge-danger">GAGAL</span>
                                @endif
                            </td>
                            <td style="text-align:right;">
                                <div style="display:inline-flex;gap:6px;">
                                    <a href="{{ route('payments.show', $pay) }}" class="btn-nb btn-secondary btn-sm">Detail</a>
                                    <a href="{{ route('payments.edit', $pay) }}" class="btn-nb btn-blue btn-sm">Edit</a>
                                    <form method="POST" action="{{ route('payments.destroy', $pay) }}"
                                          onsubmit="return confirm('Hapus data pembayaran ini?')" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-nb btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding:48px;text-align:center;">
                                <p style="font-size:14px;color:#aaa;font-weight:600;">Tidak ada data pembayaran</p>
                                <a href="{{ route('payments.create') }}" class="btn-nb btn-primary" style="margin-top:14px;display:inline-flex;">+ Catat Pembayaran</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($payments->hasPages())
            <div style="padding:14px 18px;border-top:2.5px solid #000;background:#FFFBF0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;color:#555;font-family:'Space Mono',monospace;">{{ $payments->firstItem() }}–{{ $payments->lastItem() }} dari {{ $payments->total() }}</span>
                <div style="display:flex;gap:6px;">
                    @if($payments->onFirstPage())
                        <span class="btn-nb btn-secondary btn-sm" style="opacity:0.4;cursor:default;">‹ Prev</span>
                    @else
                        <a href="{{ $payments->previousPageUrl() }}" class="btn-nb btn-secondary btn-sm">‹ Prev</a>
                    @endif
                    @if($payments->hasMorePages())
                        <a href="{{ $payments->nextPageUrl() }}" class="btn-nb btn-secondary btn-sm">Next ›</a>
                    @else
                        <span class="btn-nb btn-secondary btn-sm" style="opacity:0.4;cursor:default;">Next ›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
