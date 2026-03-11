@extends('layouts.admin')
@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')
@section('page-subtitle', 'payment.show')

@section('content')
<div style="max-width:580px;margin-top:8px;display:flex;flex-direction:column;gap:16px;">

    {{-- Payment Card --}}
    <div style="border:1px solid #1a1a1a;background:#000;">
        <div style="padding:14px 20px;border-bottom:1px solid #1a1a1a;display:flex;align-items:center;justify-content:space-between;">
            <p style="font-size:10px;color:#444;letter-spacing:0.12em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">payment.id:{{ $payment->id }}</p>
            @if($payment->payment_status === 'paid')
                <span style="font-size:10px;padding:2px 10px;background:#fff;color:#000;font-weight:700;letter-spacing:0.08em;font-family:'JetBrains Mono',monospace;">LUNAS</span>
            @elseif($payment->payment_status === 'pending')
                <span style="font-size:10px;padding:2px 10px;border:1px solid #333;color:#666;letter-spacing:0.08em;font-family:'JetBrains Mono',monospace;">PENDING</span>
            @else
                <span style="font-size:10px;padding:2px 10px;border:1px solid #1a1a1a;color:#2a2a2a;letter-spacing:0.08em;font-family:'JetBrains Mono',monospace;">GAGAL</span>
            @endif
        </div>

        <div style="padding:20px;display:flex;flex-direction:column;gap:16px;">

            {{-- Amount --}}
            <div style="text-align:center;padding:24px 0;border-bottom:1px solid #111;">
                <p style="font-size:10px;color:#333;letter-spacing:0.12em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:8px;">nominal</p>
                <p style="font-size:36px;font-weight:800;color:#fff;letter-spacing:-0.02em;font-variant-numeric:tabular-nums;">
                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                </p>
                <p style="font-size:12px;color:#444;margin-top:4px;font-family:'JetBrains Mono',monospace;">{{ $payment->payment_method }}</p>
            </div>

            {{-- Metadata --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div>
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:4px;">Pelanggan</p>
                    <p style="font-size:13px;color:#bbb;">{{ $payment->subscription->customer->name }}</p>
                </div>
                <div>
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:4px;">Paket</p>
                    <p style="font-size:13px;color:#bbb;">{{ $payment->subscription->servicePackage->name }}</p>
                </div>
                <div>
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:4px;">Tanggal Bayar</p>
                    <p style="font-size:13px;color:#bbb;font-family:'JetBrains Mono',monospace;">
                        {{ $payment->payment_date ? $payment->payment_date->format('d.m.Y — H:i') : '—' }}
                    </p>
                </div>
                <div>
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:4px;">No. Referensi</p>
                    <p style="font-size:12px;color:#bbb;font-family:'JetBrains Mono',monospace;">{{ $payment->transaction_ref ?? '—' }}</p>
                </div>
                <div>
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:4px;">Dicatat</p>
                    <p style="font-size:12px;color:#555;font-family:'JetBrains Mono',monospace;">{{ $payment->created_at->format('d.m.Y — H:i') }}</p>
                </div>
            </div>

            @if($payment->notes)
                <div style="background:#0a0a0a;border:1px solid #1a1a1a;padding:12px;">
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Catatan</p>
                    <p style="font-size:12px;color:#666;">{{ $payment->notes }}</p>
                </div>
            @endif

            {{-- Subscription link --}}
            <div style="border:1px solid #1a1a1a;padding:12px 14px;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:3px;">Subscription</p>
                    <p style="font-size:12px;color:#777;font-family:'JetBrains Mono',monospace;">
                        {{ $payment->subscription->start_date->format('d.m.Y') }} → {{ $payment->subscription->end_date->format('d.m.Y') }}
                    </p>
                </div>
                <a href="{{ route('subscriptions.show', $payment->subscription) }}"
                   style="font-size:11px;color:#444;text-decoration:none;font-family:'JetBrains Mono',monospace;"
                   onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#444'">
                    lihat →
                </a>
            </div>

            <div style="display:flex;gap:8px;padding-top:4px;border-top:1px solid #111;">
                <a href="{{ route('payments.edit', $payment) }}" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('payments.index') }}" class="btn-secondary">← Kembali</a>
            </div>
        </div>
    </div>

</div>
@endsection
