@extends('layouts.admin')
@section('title', 'Detail Pelanggan')
@section('page-title', 'Detail Pelanggan')
@section('page-subtitle', 'customer.show')

@section('content')
<div style="max-width:700px;margin-top:8px;display:flex;flex-direction:column;gap:24px;">

    {{-- Profile Card --}}
    <div class="nb-card" style="background:#00FF85;">
        <div class="nb-card-header" style="background:#000;display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:11px;color:#00FF85;letter-spacing:0.12em;font-family:'Space Mono',monospace;text-transform:uppercase;">customer.id:{{ $customer->id }}</span>
            <div style="display:flex;gap:8px;">
                <a href="{{ route('customers.edit', $customer) }}" class="btn-nb btn-primary" style="padding:5px 12px;font-size:12px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:12px;height:12px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('customers.index') }}" class="btn-nb btn-secondary" style="padding:5px 12px;font-size:12px;">← Kembali</a>
            </div>
        </div>

        <div style="padding:24px;background:#00FF85;color:#000;">
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;">
                <div style="width:56px;height:56px;border:3px solid #000;background:#FFDD00;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <span style="font-size:20px;font-weight:800;color:#000;font-family:'Space Grotesk',sans-serif;">{{ strtoupper(substr($customer->name, 0, 2)) }}</span>
                </div>
                <div>
                    <p style="font-size:22px;font-weight:800;color:#000;">{{ $customer->name }}</p>
                    @if($customer->company_name)
                        <p style="font-size:13px;color:#222;font-weight:600;margin-top:2px;font-family:'Space Mono',monospace;">{{ $customer->company_name }}</p>
                    @endif
                </div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:20px;">
                <div>
                    <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;margin-bottom:4px;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;">Telegram User ID</p>
                    <p style="font-size:14px;font-weight:700;color:#000;font-family:'Space Mono',monospace;">{{ $customer->telegram_user_id }}</p>
                </div>
                <div>
                    <p style="font-size:10px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:4px;">WhatsApp</p>
                    <p style="font-size:14px;font-weight:700;color:#000;font-family:'Space Mono',monospace;">{{ $customer->phone ?? '—' }}</p>
                </div>
                <div>
                    <p style="font-size:10px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:4px;">Nama Proyek</p>
                    <p style="font-size:14px;font-weight:700;color:#000;">{{ $customer->project_name }}</p>
                </div>
                <div>
                    <p style="font-size:10px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:4px;">Bergabung</p>
                    <p style="font-size:14px;font-weight:700;color:#000;font-family:'Space Mono',monospace;">{{ $customer->created_at->format('d.m.Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Subscription History --}}
    <div class="nb-card">
        <div class="nb-card-header" style="background:#000;color:#FFDD00;display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:11px;letter-spacing:0.12em;font-family:'Space Mono',monospace;">subscription.history</span>
            <a href="{{ route('subscriptions.create', ['customer_id' => $customer->id]) }}"
               class="btn-nb btn-primary" style="padding:4px 10px;font-size:11px;">+ Buat Langganan</a>
        </div>
        <div class="r-table-wrap">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="padding:12px 16px;text-align:left;">Paket</th>
                        <th style="padding:12px 16px;text-align:left;">Mulai</th>
                        <th style="padding:12px 16px;text-align:left;">Berakhir</th>
                        <th style="padding:12px 16px;text-align:left;">Status</th>
                        <th style="padding:12px 16px;text-align:left;">Pembayaran</th>
                        <th style="padding:12px 16px;text-align:right;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customer->subscriptions as $sub)
                        <tr>
                            <td style="font-size:13px;font-weight:700;color:#000;">{{ $sub->servicePackage->name }}</td>
                            <td style="font-size:12px;color:#555;font-family:'Space Mono',monospace;">{{ $sub->start_date->format('d.m.Y') }}</td>
                            <td style="font-size:12px;color:#555;font-family:'Space Mono',monospace;">{{ $sub->end_date->format('d.m.Y') }}</td>
                            <td>
                                @if($sub->status === 'active')
                                    <span class="badge badge-success">AKTIF</span>
                                @elseif($sub->status === 'expired')
                                    <span class="badge badge-muted">EXPIRED</span>
                                @else
                                    <span class="badge badge-danger">BATAL</span>
                                @endif
                            </td>
                            <td style="font-size:12px;font-weight:700;color:#000;font-family:'Space Mono',monospace;">{{ $sub->payments->count() }}x</td>
                            <td style="text-align:right;">
                                <a href="{{ route('subscriptions.show', $sub) }}" class="btn-nb btn-secondary" style="padding:4px 10px;font-size:11px;">
                                    Detail →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="padding:48px;text-align:center;font-size:13px;font-weight:600;color:#888;">Belum ada langganan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
