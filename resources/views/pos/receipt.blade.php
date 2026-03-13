@extends('layouts.admin')

@section('title', 'Struk - ' . $transaction->invoice_number)
@section('page-title', 'Struk Transaksi')
@section('page-subtitle', $transaction->invoice_number)

@section('content')
<div style="max-width:480px;margin:0 auto;padding-top:16px;">

    <div id="receipt" class="nb-card" style="background:#fff;padding:32px;border:4px solid #000;box-shadow:8px 8px 0 #000;">

        {{-- Header --}}
        <div style="text-align:center;margin-bottom:24px;padding-bottom:16px;border-bottom:4px solid #000;">
            <p style="font-size:28px;font-weight:900;color:#000;letter-spacing:0.05em;text-transform:uppercase;font-family:'Space Grotesk',sans-serif;">AWBuilder</p>
            <p style="display:inline-block;padding:4px 12px;background:#000;color:#fff;font-size:12px;font-weight:800;letter-spacing:0.2em;font-family:'Space Mono',monospace;margin-top:8px;">STRUK TRANSAKSI</p>
        </div>

        {{-- Meta --}}
        <div style="padding:12px 16px;background:#FFDD00;border:3px solid #000;margin-bottom:24px;">
            <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                <span style="font-size:12px;font-weight:700;color:#000;text-transform:uppercase;font-family:'Space Mono',monospace;">Invoice</span>
                <span style="font-size:13px;font-weight:800;color:#000;font-family:'Space Mono',monospace;">{{ $transaction->invoice_number }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                <span style="font-size:12px;font-weight:700;color:#000;text-transform:uppercase;font-family:'Space Mono',monospace;">Tanggal</span>
                <span style="font-size:13px;font-weight:800;color:#000;font-family:'Space Mono',monospace;">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                <span style="font-size:12px;font-weight:700;color:#000;text-transform:uppercase;font-family:'Space Mono',monospace;">Pelanggan</span>
                <span style="font-size:14px;font-weight:800;color:#000;">{{ $transaction->customer->name ?? 'UMUM' }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;">
                <span style="font-size:12px;font-weight:700;color:#000;text-transform:uppercase;font-family:'Space Mono',monospace;">Bayar</span>
                <span style="font-size:14px;font-weight:800;color:#000;">{{ strtoupper($transaction->payment_method) }}</span>
            </div>
        </div>

        {{-- Items --}}
        <div style="margin-bottom:24px;">
            <div style="display:flex;justify-content:space-between;padding-bottom:8px;border-bottom:3px solid #000;margin-bottom:12px;">
                <span style="font-size:12px;font-weight:700;color:#000;text-transform:uppercase;font-family:'Space Mono',monospace;">Item</span>
                <span style="font-size:12px;font-weight:700;color:#000;text-transform:uppercase;font-family:'Space Mono',monospace;">Subtotal</span>
            </div>

            @foreach($transaction->items as $item)
            <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:2px dashed #000;">
                <div>
                    <p style="font-size:15px;font-weight:800;color:#000;text-transform:uppercase;">{{ $item->product_name }}</p>
                    <p style="font-size:12px;font-weight:600;color:#222;font-family:'Space Mono',monospace;margin-top:4px;">
                        Rp {{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}
                    </p>
                </div>
                <span style="font-size:15px;font-weight:800;color:#000;font-family:'Space Mono',monospace;white-space:nowrap;display:flex;align-items:center;">
                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                </span>
            </div>
            @endforeach
        </div>

        {{-- Totals --}}
        <div style="border-top:4px solid #000;padding-top:16px;">
            <div style="display:flex;justify-content:space-between;margin-bottom:12px;">
                <span style="font-size:13px;font-weight:700;color:#000;text-transform:uppercase;font-family:'Space Mono',monospace;">Subtotal</span>
                <span style="font-size:14px;font-weight:800;color:#000;font-family:'Space Mono',monospace;">{{ $transaction->formatted_total_amount }}</span>
            </div>
            @if($transaction->discount > 0)
            <div style="display:flex;justify-content:space-between;margin-bottom:12px;">
                <span style="font-size:13px;font-weight:700;color:#000;text-transform:uppercase;font-family:'Space Mono',monospace;">Diskon</span>
                <span style="font-size:14px;font-weight:800;color:#FF3B3B;font-family:'Space Mono',monospace;">- {{ $transaction->formatted_discount }}</span>
            </div>
            @endif
            <div style="display:flex;justify-content:space-between;padding:16px;background:#00FF85;border:3px solid #000;margin-top:8px;">
                <span style="font-size:18px;font-weight:900;color:#000;text-transform:uppercase;">TOTAL</span>
                <span style="font-size:24px;font-weight:900;color:#000;font-family:'Space Mono',monospace;">{{ $transaction->formatted_grand_total }}</span>
            </div>
        </div>

        {{-- Status / Footer --}}
        <div style="text-align:center;margin-top:32px;">
            <div style="display:inline-block;padding:8px 32px;border:3px solid #000;background:#000;color:#fff;font-weight:900;font-size:18px;letter-spacing:0.2em;transform:rotate(-2deg);">
                LUNAS
            </div>
        </div>

        <p style="text-align:center;font-size:13px;font-weight:800;color:#000;margin-top:32px;font-family:'Space Mono',monospace;text-transform:uppercase;">
            TERIMA KASIH! <br> AWBUILDER
        </p>
    </div>

    {{-- Actions --}}
    <div style="display:flex;gap:16px;margin-top:24px;justify-content:center;">
        <button onclick="window.print()" class="btn-nb btn-primary" style="padding:12px 24px;font-size:16px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;margin-right:8px;display:inline-block;">
                <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.092 1.086a1.875 1.875 0 0 0 1.868 2.064h9.408a1.875 1.875 0 0 0 1.868-2.064l-.092-1.086h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25Z" clip-rule="evenodd"/>
            </svg>
            PRINT STRUK
        </button>
        <a href="{{ route('pos.index') }}" class="btn-nb btn-secondary" style="background:#fff;padding:12px 24px;font-size:16px;">TRANSAKSI BARU</a>
    </div>
</div>

@push('styles')
<style>
    @media print {
        aside, header, .btn-primary, .btn-secondary, [style*="display:flex;gap:16px;margin-top:24px"] { display: none !important; }
        body { background: #fff !important; margin: 0; padding: 0; }
        main { padding: 0 !important; }
        #receipt { border: none !important; box-shadow: none !important; margin: 0 !important; max-width: 100% !important; padding: 0 !important; }
        .nb-card { box-shadow: none !important; border-radius: 0 !important; }
    }
</style>
@endpush
@endsection
