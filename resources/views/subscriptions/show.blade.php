@extends('layouts.admin')
@section('title', 'Detail Subscription')
@section('page-title', 'Detail Subscription')
@section('page-subtitle', 'subscription.show')

@section('content')
<div style="max-width:700px;margin-top:8px;display:flex;flex-direction:column;gap:24px;">

    {{-- ── Info Card ─────────────────────────────────────────────── --}}
    <div class="nb-card" style="background:#00FF85;">
        <div class="nb-card-header" style="background:#000;display:flex;align-items:center;justify-content:space-between;">
            <p style="font-size:11px;color:#00FF85;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">
                subscription.id:{{ $subscription->id }}
            </p>
            @if($subscription->status === 'active')
                <span class="badge badge-success">AKTIF</span>
            @elseif($subscription->status === 'expired')
                <span class="badge badge-muted">EXPIRED</span>
            @else
                <span class="badge badge-danger">BATAL</span>
            @endif
        </div>

        <div style="padding:24px;display:flex;flex-direction:column;gap:20px;">
            {{-- Customer banner --}}
            <div style="display:flex;align-items:center;gap:16px;">
                <div style="width:48px;height:48px;border:3px solid #000;background:#FFDD00;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <span style="font-size:16px;font-weight:800;color:#000;letter-spacing:0.05em;font-family:'Space Grotesk',sans-serif;">
                        {{ strtoupper(substr($subscription->customer->name, 0, 2)) }}
                    </span>
                </div>
                <div>
                    <p style="font-size:18px;font-weight:800;color:#000;">{{ $subscription->customer->name }}</p>
                    <p style="font-size:13px;font-weight:600;color:#222;margin-top:2px;font-family:'Space Mono',monospace;">{{ $subscription->customer->telegram_user_id }} · {{ $subscription->customer->phone }}</p>
                </div>
            </div>

            <div style="height:3px;background:#000;"></div>

            {{-- Metadata grid --}}
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
                <div>
                    <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:6px;">Proyek</p>
                    <p style="font-size:14px;font-weight:700;color:#000;">{{ $subscription->customer->project_name }}</p>
                </div>
                <div>
                    <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:6px;">Kategori</p>
                    <p style="font-size:14px;font-weight:700;color:#000;">{{ $subscription->category->name ?? '-' }}</p>
                </div>
                <div>
                    <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:6px;">Sisa Waktu</p>
                    @if($subscription->status === 'expired')
                        <p style="font-size:14px;font-weight:800;color:#FF3B3B;font-family:'Space Mono',monospace;">EXPIRED</p>
                    @else
                        <p style="font-size:14px;font-weight:800;color:#000;font-family:'Space Mono',monospace;">{{ $subscription->days_remaining }} hari</p>
                    @endif
                </div>
                <div>
                    <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:6px;">Mulai</p>
                    <p style="font-size:14px;font-weight:700;color:#000;font-family:'Space Mono',monospace;">{{ $subscription->start_date->format('d.m.Y') }}</p>
                </div>
                <div>
                    <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:6px;">Berakhir</p>
                    <p style="font-size:14px;font-weight:700;color:{{ $subscription->status==='expired' ? '#FF3B3B' : '#000' }};font-family:'Space Mono',monospace;">{{ $subscription->end_date->format('d.m.Y') }}</p>
                </div>
            </div>

            @if($subscription->notes)
                <div style="background:#fff;border:3px solid #000;padding:16px;box-shadow:4px 4px 0 #000;margin-top:4px;">
                    <p style="font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:6px;">Catatan</p>
                    <p style="font-size:13px;font-weight:600;color:#222;font-family:'Space Mono',monospace;">{{ $subscription->notes }}</p>
                </div>
            @endif

            <div style="display:flex;gap:12px;padding-top:20px;border-top:3px solid #000;margin-top:4px;">
                <a href="{{ route('subscriptions.edit', $subscription) }}" class="btn-nb btn-primary" style="flex:1;justify-content:center;background:#0066FF;color:#fff;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:14px;height:14px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('subscriptions.index') }}" class="btn-nb btn-secondary" style="flex:1;justify-content:center;background:#fff;">← Kembali</a>
            </div>
        </div>
    </div>

    {{-- ── Payment History ───────────────────────────────────────── --}}
    <div class="nb-card">
        <div class="nb-card-header" style="background:#000;color:#FFDD00;display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:11px;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">payment.history</span>
            <a href="{{ route('payments.create', ['subscription_id' => $subscription->id]) }}"
               class="btn-nb btn-primary" style="padding:4px 10px;font-size:11px;background:#00FF85;color:#000;">
                + Catat Pembayaran
            </a>
        </div>

        <div class="r-table-wrap">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="padding:12px 16px;text-align:left;">Tanggal</th>
                        <th style="padding:12px 16px;text-align:left;">Nominal</th>
                        <th style="padding:12px 16px;text-align:left;">Metode</th>
                        <th style="padding:12px 16px;text-align:left;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscription->payments as $pay)
                        <tr style="border-bottom:2px solid #000;">
                            <td style="padding:12px 16px;font-size:13px;font-weight:600;color:#222;font-family:'Space Mono',monospace;">
                                {{ $pay->payment_date ? $pay->payment_date->format('d.m.Y') : '—' }}
                            </td>
                            <td style="padding:12px 16px;font-size:14px;font-weight:800;color:#000;">
                                Rp {{ number_format($pay->amount, 0, ',', '.') }}
                            </td>
                            <td style="padding:12px 16px;font-size:13px;font-weight:600;color:#222;font-family:'Space Mono',monospace;">
                                {{ $pay->payment_method }}
                            </td>
                            <td style="padding:12px 16px;">
                                @if($pay->payment_status === 'paid')
                                    <span class="badge badge-success">LUNAS</span>
                                @elseif($pay->payment_status === 'pending')
                                    <span class="badge" style="background:#FFDD00;color:#000;">PENDING</span>
                                @else
                                    <span class="badge badge-danger">GAGAL</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding:48px;text-align:center;font-size:13px;font-weight:600;color:#888;font-family:'Space Mono',monospace;">
                                — Belum ada riwayat pembayaran —
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
