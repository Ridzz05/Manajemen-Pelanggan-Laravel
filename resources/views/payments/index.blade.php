@extends('layouts.admin')
@section('title', 'Pembayaran')
@section('page-title', 'Pembayaran')
@section('page-subtitle', 'payment.management')

@section('content')
<div style="display:flex;flex-direction:column;gap:16px;">

    {{-- Revenue Banner --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1px;background:#1a1a1a;border:1px solid #1a1a1a;">
        <div style="background:#000;padding:18px 22px;">
            <p style="font-size:10px;color:#333;letter-spacing:0.12em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Total Revenue</p>
            <p style="font-size:22px;font-weight:700;color:#fff;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div style="background:#000;padding:18px 22px;">
            <p style="font-size:10px;color:#333;letter-spacing:0.12em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Total Transaksi</p>
            <p style="font-size:22px;font-weight:700;color:#fff;">{{ $payments->total() }}</p>
        </div>
    </div>

    {{-- Toolbar --}}
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <form method="GET" action="{{ route('payments.index') }}"
              style="display:flex;align-items:center;gap:8px;flex:1;flex-wrap:wrap;">

            <select name="status" onchange="this.form.submit()"
                    style="padding:8px 12px;font-size:12px;cursor:pointer;">
                <option value="">semua status</option>
                <option value="pending" {{ request('status')==='pending' ? 'selected':'' }}>pending</option>
                <option value="paid"    {{ request('status')==='paid'    ? 'selected':'' }}>lunas</option>
                <option value="failed"  {{ request('status')==='failed'  ? 'selected':'' }}>gagal</option>
            </select>

            <select name="method" onchange="this.form.submit()"
                    style="padding:8px 12px;font-size:12px;cursor:pointer;">
                <option value="">semua metode</option>
                @foreach(\App\Models\Payment::PAYMENT_METHODS as $m)
                    <option value="{{ $m }}" {{ request('method')===$m ? 'selected':'' }}>{{ $m }}</option>
                @endforeach
            </select>

            @if(request('status') || request('method'))
                <a href="{{ route('payments.index') }}"
                   style="font-size:12px;color:#444;text-decoration:none;padding:8px 10px;border:1px solid #1a1a1a;">✕ Reset</a>
            @endif
        </form>

        <a href="{{ route('payments.create') }}" class="btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Catat Pembayaran
        </a>
    </div>

    {{-- Table --}}
    <div style="border:1px solid #1a1a1a;overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid #1a1a1a;background:#000;">
                    <th style="padding:10px 16px;text-align:left;">#</th>
                    <th style="padding:10px 16px;text-align:left;">Pelanggan</th>
                    <th style="padding:10px 16px;text-align:left;">Nominal</th>
                    <th style="padding:10px 16px;text-align:left;">Metode</th>
                    <th style="padding:10px 16px;text-align:left;">Ref.</th>
                    <th style="padding:10px 16px;text-align:left;">Tanggal</th>
                    <th style="padding:10px 16px;text-align:left;">Status</th>
                    <th style="padding:10px 16px;text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $pay)
                    <tr style="border-bottom:1px solid #0f0f0f;background:#000;transition:background 0.1s;"
                        onmouseover="this.style.background='#0d0d0d'" onmouseout="this.style.background='#000'">

                        <td style="padding:12px 16px;font-size:11px;color:#333;font-family:'JetBrains Mono',monospace;">
                            {{ str_pad($payments->firstItem() + $loop->index, 2, '0', STR_PAD_LEFT) }}
                        </td>

                        <td style="padding:12px 16px;">
                            <p style="font-size:13px;font-weight:500;color:#ddd;">{{ $pay->subscription->customer->name }}</p>
                            <p style="font-size:11px;color:#333;margin-top:2px;font-family:'JetBrains Mono',monospace;">{{ $pay->subscription->servicePackage->name }}</p>
                        </td>

                        <td style="padding:12px 16px;font-size:14px;font-weight:700;color:#fff;white-space:nowrap;font-variant-numeric:tabular-nums;">
                            Rp {{ number_format($pay->amount, 0, ',', '.') }}
                        </td>

                        <td style="padding:12px 16px;">
                            @if($pay->payment_method === 'QRIS')
                                <div style="display:inline-flex;align-items:center;gap:5px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:12px;height:12px;color:#555;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z"/>
                                    </svg>
                                    <span style="font-size:11px;color:#777;font-family:'JetBrains Mono',monospace;">QRIS</span>
                                </div>
                            @else
                                <span style="font-size:11px;color:#555;font-family:'JetBrains Mono',monospace;">{{ $pay->payment_method }}</span>
                            @endif
                        </td>

                        <td style="padding:12px 16px;font-size:11px;color:#333;font-family:'JetBrains Mono',monospace;">
                            {{ $pay->transaction_ref ?? '—' }}
                        </td>

                        <td style="padding:12px 16px;font-size:12px;color:#555;white-space:nowrap;font-family:'JetBrains Mono',monospace;">
                            {{ $pay->payment_date ? $pay->payment_date->format('d.m.Y') : '—' }}
                        </td>

                        <td style="padding:12px 16px;">
                            @if($pay->payment_status === 'paid')
                                <span style="font-size:10px;padding:2px 10px;background:#fff;color:#000;font-weight:700;letter-spacing:0.08em;font-family:'JetBrains Mono',monospace;">LUNAS</span>
                            @elseif($pay->payment_status === 'pending')
                                <span style="font-size:10px;padding:2px 10px;border:1px solid #333;color:#666;letter-spacing:0.08em;font-family:'JetBrains Mono',monospace;">PENDING</span>
                            @else
                                <span style="font-size:10px;padding:2px 10px;border:1px solid #1a1a1a;color:#2a2a2a;letter-spacing:0.08em;font-family:'JetBrains Mono',monospace;">GAGAL</span>
                            @endif
                        </td>

                        <td style="padding:12px 16px;text-align:right;">
                            <div style="display:inline-flex;align-items:center;gap:4px;">
                                <a href="{{ route('payments.show', $pay) }}" title="Detail"
                                   style="display:inline-flex;padding:5px;color:#333;text-decoration:none;transition:color 0.15s;"
                                   onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#333'">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('payments.edit', $pay) }}" title="Edit"
                                   style="display:inline-flex;padding:5px;color:#333;text-decoration:none;transition:color 0.15s;"
                                   onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#333'">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('payments.destroy', $pay) }}"
                                      onsubmit="return confirm('Hapus data pembayaran ini?')" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" title="Hapus"
                                            style="display:inline-flex;padding:5px;background:none;border:none;cursor:pointer;color:#333;transition:color 0.15s;"
                                            onmouseover="this.style.color='#888'" onmouseout="this.style.color='#333'">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="padding:48px;text-align:center;">
                            <p style="font-size:12px;color:#333;font-family:'JetBrains Mono',monospace;">— tidak ada data pembayaran —</p>
                            <a href="{{ route('payments.create') }}"
                               style="display:inline-block;margin-top:12px;font-size:12px;color:#555;text-decoration:none;border:1px solid #1a1a1a;padding:6px 14px;">
                                + catat pembayaran
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($payments->hasPages())
            <div style="padding:12px 16px;border-top:1px solid #111;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;color:#333;font-family:'JetBrains Mono',monospace;">
                    {{ $payments->firstItem() }}–{{ $payments->lastItem() }} dari {{ $payments->total() }}
                </span>
                <div style="display:flex;gap:4px;">
                    @if($payments->onFirstPage())
                        <span style="padding:4px 10px;border:1px solid #111;font-size:11px;color:#222;font-family:'JetBrains Mono',monospace;">‹</span>
                    @else
                        <a href="{{ $payments->previousPageUrl() }}" style="padding:4px 10px;border:1px solid #333;font-size:11px;color:#666;text-decoration:none;font-family:'JetBrains Mono',monospace;">‹</a>
                    @endif
                    @if($payments->hasMorePages())
                        <a href="{{ $payments->nextPageUrl() }}" style="padding:4px 10px;border:1px solid #333;font-size:11px;color:#666;text-decoration:none;font-family:'JetBrains Mono',monospace;">›</a>
                    @else
                        <span style="padding:4px 10px;border:1px solid #111;font-size:11px;color:#222;font-family:'JetBrains Mono',monospace;">›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
