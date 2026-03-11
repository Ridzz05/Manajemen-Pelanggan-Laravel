@extends('layouts.admin')
@section('title', 'Detail Pelanggan')
@section('page-title', 'Detail Pelanggan')
@section('page-subtitle', 'customer.show')

@section('content')
<div style="max-width:700px;margin-top:8px;display:flex;flex-direction:column;gap:16px;">

    {{-- Profile Card --}}
    <div style="border:1px solid #1a1a1a;background:#000;">
        <div style="padding:14px 20px;border-bottom:1px solid #1a1a1a;display:flex;align-items:center;justify-content:space-between;">
            <p style="font-size:10px;color:#444;letter-spacing:0.12em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">customer.id:{{ $customer->id }}</p>
            <div style="display:flex;gap:8px;">
                <a href="{{ route('customers.edit', $customer) }}" class="btn-primary" style="padding:5px 12px;font-size:12px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:12px;height:12px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('customers.index') }}" class="btn-secondary" style="padding:5px 12px;font-size:12px;">← Kembali</a>
            </div>
        </div>

        <div style="padding:20px;">
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px;">
                <div style="width:48px;height:48px;border:1px solid #2a2a2a;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <span style="font-size:16px;font-weight:700;color:#444;letter-spacing:0.05em;">{{ strtoupper(substr($customer->name, 0, 2)) }}</span>
                </div>
                <div>
                    <p style="font-size:18px;font-weight:600;color:#fff;">{{ $customer->name }}</p>
                    @if($customer->company_name)
                        <p style="font-size:12px;color:#444;margin-top:2px;font-family:'JetBrains Mono',monospace;">{{ $customer->company_name }}</p>
                    @endif
                </div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;">
                <div>
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:4px;">Email</p>
                    <p style="font-size:13px;color:#aaa;font-family:'JetBrains Mono',monospace;">{{ $customer->email }}</p>
                </div>
                <div>
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:4px;">WhatsApp</p>
                    <p style="font-size:13px;color:#aaa;font-family:'JetBrains Mono',monospace;">{{ $customer->phone ?? '—' }}</p>
                </div>
                <div>
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:4px;">Nama Proyek</p>
                    <p style="font-size:13px;color:#aaa;">{{ $customer->project_name }}</p>
                </div>
                <div>
                    <p style="font-size:10px;color:#333;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:4px;">Bergabung</p>
                    <p style="font-size:13px;color:#aaa;font-family:'JetBrains Mono',monospace;">{{ $customer->created_at->format('d.m.Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Subscription History --}}
    <div style="border:1px solid #1a1a1a;background:#000;">
        <div style="padding:14px 20px;border-bottom:1px solid #1a1a1a;display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:10px;color:#555;letter-spacing:0.12em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">subscription.history</span>
            <a href="{{ route('subscriptions.create', ['customer_id' => $customer->id]) }}"
               style="font-size:11px;color:#555;text-decoration:none;border:1px solid #1a1a1a;padding:3px 10px;font-family:'JetBrains Mono',monospace;">+ buat langganan</a>
        </div>
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid #0f0f0f;">
                    <th style="padding:10px 16px;text-align:left;">Paket</th>
                    <th style="padding:10px 16px;text-align:left;">Mulai</th>
                    <th style="padding:10px 16px;text-align:left;">Berakhir</th>
                    <th style="padding:10px 16px;text-align:left;">Status</th>
                    <th style="padding:10px 16px;text-align:left;">Pembayaran</th>
                    <th style="padding:10px 16px;text-align:right;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($customer->subscriptions as $sub)
                    <tr style="border-bottom:1px solid #0a0a0a;">
                        <td style="padding:10px 16px;font-size:12px;color:#888;">{{ $sub->servicePackage->name }}</td>
                        <td style="padding:10px 16px;font-size:12px;color:#555;font-family:'JetBrains Mono',monospace;">{{ $sub->start_date->format('d.m.Y') }}</td>
                        <td style="padding:10px 16px;font-size:12px;color:#555;font-family:'JetBrains Mono',monospace;">{{ $sub->end_date->format('d.m.Y') }}</td>
                        <td style="padding:10px 16px;">
                            @if($sub->status === 'active')
                                <span style="font-size:10px;padding:2px 8px;border:1px solid #444;color:#ccc;font-family:'JetBrains Mono',monospace;">AKTIF</span>
                            @elseif($sub->status === 'expired')
                                <span style="font-size:10px;padding:2px 8px;border:1px solid #1a1a1a;color:#333;font-family:'JetBrains Mono',monospace;">EXPIRED</span>
                            @else
                                <span style="font-size:10px;padding:2px 8px;border:1px solid #1a1a1a;color:#2a2a2a;font-family:'JetBrains Mono',monospace;">BATAL</span>
                            @endif
                        </td>
                        <td style="padding:10px 16px;font-size:12px;color:#444;font-family:'JetBrains Mono',monospace;">{{ $sub->payments->count() }}x</td>
                        <td style="padding:10px 16px;text-align:right;">
                            <a href="{{ route('subscriptions.show', $sub) }}"
                               style="font-size:11px;color:#333;text-decoration:none;font-family:'JetBrains Mono',monospace;"
                               onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#333'">
                                detail →
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="padding:32px;text-align:center;font-size:12px;color:#222;font-family:'JetBrains Mono',monospace;">— belum ada langganan —</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
