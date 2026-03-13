@extends('layouts.admin')
@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')
@section('page-subtitle', 'payment.show')

@section('content')
<div style="max-width:640px;margin-top:8px;display:flex;flex-direction:column;gap:24px;">

    {{-- Payment Card --}}
    <div class="nb-card" style="background:#FFDD00;">
        <div class="nb-card-header" style="background:#000;display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:11px;color:#FFDD00;letter-spacing:0.12em;font-family:'Space Mono',monospace;text-transform:uppercase;">payment.id:{{ $payment->id }}</span>
            @if($payment->payment_status === 'paid')
                <span class="badge badge-success">LUNAS</span>
            @elseif($payment->payment_status === 'pending')
                <span class="badge badge-warning">PENDING</span>
            @else
                <span class="badge badge-danger">GAGAL</span>
            @endif
        </div>

        <div style="padding:24px;display:flex;flex-direction:column;gap:20px;">

            {{-- Amount --}}
            <div style="text-align:center;padding:24px 0;border-bottom:3px solid #000;">
                <p style="font-size:11px;font-weight:700;color:#000;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Nominal</p>
                <p style="font-size:42px;font-weight:800;color:#000;letter-spacing:-0.02em;font-variant-numeric:tabular-nums;line-height:1;">
                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                </p>
                <p style="font-size:14px;font-weight:700;color:#222;margin-top:8px;font-family:'Space Mono',monospace;">{{ $payment->payment_method }}</p>
            </div>

            {{-- Metadata --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                <div>
                    <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:4px;">Pelanggan</p>
                    <p style="font-size:14px;font-weight:800;color:#000;">{{ $payment->subscription->customer->name }}</p>
                </div>
                <div>
                    <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:4px;">Paket</p>
                    <p style="font-size:14px;font-weight:800;color:#000;">{{ $payment->subscription->servicePackage->name }}</p>
                </div>
                <div>
                    <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:4px;">Tanggal Bayar</p>
                    <p style="font-size:14px;font-weight:700;color:#000;font-family:'Space Mono',monospace;">
                        {{ $payment->payment_date ? $payment->payment_date->format('d.m.Y — H:i') : '—' }}
                    </p>
                </div>
                <div>
                    <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:4px;">No. Referensi</p>
                    <p style="font-size:13px;font-weight:700;color:#000;font-family:'Space Mono',monospace;">{{ $payment->transaction_ref ?? '—' }}</p>
                </div>
                <div>
                    <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:4px;">Dicatat Pada</p>
                    <p style="font-size:13px;font-weight:700;color:#000;font-family:'Space Mono',monospace;">{{ $payment->created_at->format('d.m.Y — H:i') }}</p>
                </div>
            </div>

            @if($payment->notes)
                <div style="background:#fff;border:3px solid #000;padding:16px;box-shadow:4px 4px 0 #000;">
                    <p style="font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:6px;">Catatan</p>
                    <p style="font-size:13px;font-weight:600;color:#222;font-family:'Space Mono',monospace;">{{ $payment->notes }}</p>
                </div>
            @endif

            {{-- Subscription link --}}
            <div style="border:3px solid #000;background:#fff;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;box-shadow:4px 4px 0 #000;">
                <div>
                    <p style="font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:4px;">Subscription</p>
                    <p style="font-size:14px;font-weight:700;color:#000;font-family:'Space Mono',monospace;">
                        {{ $payment->subscription->start_date->format('d.m.Y') }} → {{ $payment->subscription->end_date->format('d.m.Y') }}
                    </p>
                </div>
                <a href="{{ route('subscriptions.show', $payment->subscription) }}" class="btn-nb btn-secondary" style="padding:6px 14px;font-size:12px;">
                    Lihat →
                </a>
            </div>

            <div style="display:flex;gap:12px;padding-top:20px;border-top:3px solid #000;margin-top:4px;">
                <a href="{{ route('payments.edit', $payment) }}" class="btn-nb btn-primary" style="flex:1;justify-content:center;background:#0066FF;color:#fff;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:14px;height:14px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('payments.index') }}" class="btn-nb btn-secondary" style="flex:1;justify-content:center;background:#fff;">← Kembali</a>
            </div>
        </div>
    </div>

</div>
@endsection
