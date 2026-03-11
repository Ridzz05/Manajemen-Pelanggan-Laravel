@extends('layouts.admin')
@section('title', 'Detail Subscription')
@section('page-title', 'Detail Subscription')
@section('page-subtitle', 'subscription.show')

@section('content')
<div style="max-width:700px;margin-top:8px;display:flex;flex-direction:column;gap:16px;">

    {{-- ── Info Card ─────────────────────────────────────────────── --}}
    <div style="border:1px solid #1a1a1a;background:#000;">
        <div style="padding:16px 20px;border-bottom:1px solid #1a1a1a;display:flex;align-items:center;justify-content:space-between;">
            <p style="font-size:10px;color:#444;letter-spacing:0.12em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">
                subscription.id:{{ $subscription->id }}
            </p>
            @if($subscription->status === 'active')
                <span style="font-size:10px;padding:2px 10px;border:1px solid #444;color:#bbb;letter-spacing:0.08em;font-family:'JetBrains Mono',monospace;">AKTIF</span>
            @elseif($subscription->status === 'expired')
                <span style="font-size:10px;padding:2px 10px;border:1px solid #1a1a1a;color:#333;letter-spacing:0.08em;font-family:'JetBrains Mono',monospace;">EXPIRED</span>
            @else
                <span style="font-size:10px;padding:2px 10px;border:1px solid #1a1a1a;color:#2a2a2a;letter-spacing:0.08em;font-family:'JetBrains Mono',monospace;">BATAL</span>
            @endif
        </div>

        <div style="padding:20px;display:flex;flex-direction:column;gap:16px;">
            {{-- Customer banner --}}
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:40px;height:40px;border:1px solid #2a2a2a;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <span style="font-size:14px;font-weight:700;color:#555;letter-spacing:0.05em;">
                        {{ strtoupper(substr($subscription->customer->name, 0, 2)) }}
                    </span>
                </div>
                <div>
                    <p style="font-size:16px;font-weight:600;color:#fff;">{{ $subscription->customer->name }}</p>
                    <p style="font-size:12px;color:#444;margin-top:2px;font-family:'JetBrains Mono',monospace;">{{ $subscription->customer->email }} · {{ $subscription->customer->phone }}</p>
                </div>
            </div>

            <div style="height:1px;background:#111;"></div>

            {{-- Metadata grid --}}
            <div class="r-form-grid" style="grid-template-columns:repeat(3,1fr);">
                <div>
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:5px;">Proyek</p>
                    <p style="font-size:13px;color:#bbb;">{{ $subscription->customer->project_name }}</p>
                </div>
                <div>
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:5px;">Kategori</p>
                    <p style="font-size:13px;color:#bbb;">{{ $subscription->category->name ?? '-' }}</p>
                </div>
                <div>
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:5px;">Sisa Waktu</p>
                    @if($subscription->status === 'expired')
                        <p style="font-size:13px;color:#333;font-family:'JetBrains Mono',monospace;">expired</p>
                    @else
                        <p style="font-size:13px;color:#fff;font-weight:600;font-family:'JetBrains Mono',monospace;">{{ $subscription->days_remaining }}d</p>
                    @endif
                </div>
                <div>
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:5px;">Mulai</p>
                    <p style="font-size:13px;color:#bbb;font-family:'JetBrains Mono',monospace;">{{ $subscription->start_date->format('d.m.Y') }}</p>
                </div>
                <div>
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:5px;">Berakhir</p>
                    <p style="font-size:13px;color:{{ $subscription->status==='expired' ? '#333' : '#bbb' }};font-family:'JetBrains Mono',monospace;">{{ $subscription->end_date->format('d.m.Y') }}</p>
                </div>
            </div>

            @if($subscription->notes)
                <div style="background:#0a0a0a;border:1px solid #1a1a1a;padding:12px;margin-top:4px;">
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Catatan</p>
                    <p style="font-size:12px;color:#666;">{{ $subscription->notes }}</p>
                </div>
            @endif

            <div style="display:flex;gap:8px;padding-top:4px;border-top:1px solid #111;">
                <a href="{{ route('subscriptions.edit', $subscription) }}" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('subscriptions.index') }}" class="btn-secondary">← Kembali</a>
            </div>
        </div>
    </div>

    {{-- ── Payment History ───────────────────────────────────────── --}}
    <div style="border:1px solid #1a1a1a;background:#000;">
        <div style="padding:14px 20px;border-bottom:1px solid #1a1a1a;display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:10px;color:#555;letter-spacing:0.12em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">payment.history</span>
            <a href="{{ route('payments.create', ['subscription_id' => $subscription->id]) }}"
               style="font-size:11px;color:#555;text-decoration:none;border:1px solid #1a1a1a;padding:3px 10px;font-family:'JetBrains Mono',monospace;">
                + catat
            </a>
        </div>

        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid #0f0f0f;">
                    <th style="padding:10px 16px;text-align:left;">Tanggal</th>
                    <th style="padding:10px 16px;text-align:left;">Nominal</th>
                    <th style="padding:10px 16px;text-align:left;">Metode</th>
                    <th style="padding:10px 16px;text-align:left;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscription->payments as $pay)
                    <tr style="border-bottom:1px solid #0a0a0a;">
                        <td style="padding:10px 16px;font-size:12px;color:#555;font-family:'JetBrains Mono',monospace;">
                            {{ $pay->payment_date ? $pay->payment_date->format('d.m.Y') : '—' }}
                        </td>
                        <td style="padding:10px 16px;font-size:13px;font-weight:600;color:#ccc;">
                            Rp {{ number_format($pay->amount, 0, ',', '.') }}
                        </td>
                        <td style="padding:10px 16px;font-size:12px;color:#555;font-family:'JetBrains Mono',monospace;">
                            {{ $pay->payment_method }}
                        </td>
                        <td style="padding:10px 16px;">
                            @if($pay->payment_status === 'paid')
                                <span style="font-size:10px;padding:2px 8px;background:#fff;color:#000;font-weight:700;letter-spacing:0.06em;font-family:'JetBrains Mono',monospace;">LUNAS</span>
                            @elseif($pay->payment_status === 'pending')
                                <span style="font-size:10px;padding:2px 8px;border:1px solid #333;color:#555;letter-spacing:0.06em;font-family:'JetBrains Mono',monospace;">PENDING</span>
                            @else
                                <span style="font-size:10px;padding:2px 8px;border:1px solid #1a1a1a;color:#2a2a2a;letter-spacing:0.06em;font-family:'JetBrains Mono',monospace;">GAGAL</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding:32px;text-align:center;font-size:12px;color:#222;font-family:'JetBrains Mono',monospace;">
                            — belum ada riwayat pembayaran —
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
