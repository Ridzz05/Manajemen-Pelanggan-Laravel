@extends('layouts.admin')

@section('title', 'Struk - ' . $transaction->invoice_number)
@section('page-title', 'Struk Transaksi')
@section('page-subtitle', $transaction->invoice_number)

@section('content')
<div style="max-width:420px;margin:0 auto;">

    <div id="receipt" style="border:1px solid var(--border);background:var(--bg-surface);padding:28px;">

        <div style="text-align:center;margin-bottom:20px;">
            <p style="font-size:16px;font-weight:700;color:var(--text-primary);letter-spacing:0.05em;">AWBuilder</p>
            <p style="font-size:10px;color:var(--text-dim);font-family:'JetBrains Mono',monospace;margin-top:4px;">STRUK TRANSAKSI</p>
        </div>
        <div style="border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:12px 0;margin-bottom:16px;">
            <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                <span style="font-size:11px;color:var(--text-muted);">Invoice</span>
                <span style="font-size:11px;color:var(--text-primary);font-family:'JetBrains Mono',monospace;">{{ $transaction->invoice_number }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                <span style="font-size:11px;color:var(--text-muted);">Tanggal</span>
                <span style="font-size:11px;color:var(--text-primary);font-family:'JetBrains Mono',monospace;">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                <span style="font-size:11px;color:var(--text-muted);">Pelanggan</span>
                <span style="font-size:11px;color:var(--text-primary);">{{ $transaction->customer->name ?? 'Umum' }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;">
                <span style="font-size:11px;color:var(--text-muted);">Bayar</span>
                <span style="font-size:11px;color:var(--text-primary);">{{ $transaction->payment_method }}</span>
            </div>
        </div>

        {{-- Items --}}
        <div style="margin-bottom:16px;">
            @foreach($transaction->items as $item)
            <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px dashed var(--border-dim);">
                <div>
                    <p style="font-size:12px;color:var(--text-primary);">{{ $item->product_name }}</p>
                    <p style="font-size:10px;color:var(--text-muted);font-family:'JetBrains Mono',monospace;">
                        Rp {{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}
                    </p>
                </div>
                <span style="font-size:12px;font-weight:600;color:var(--text-primary);font-family:'JetBrains Mono',monospace;white-space:nowrap;">
                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                </span>
            </div>
            @endforeach
        </div>

        {{-- Totals --}}
        <div style="border-top:1px solid var(--border);padding-top:12px;">
            <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                <span style="font-size:12px;color:var(--text-muted);">Subtotal</span>
                <span style="font-size:12px;color:var(--text-secondary);font-family:'JetBrains Mono',monospace;">{{ $transaction->formatted_total_amount }}</span>
            </div>
            @if($transaction->discount > 0)
            <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                <span style="font-size:12px;color:var(--text-muted);">Diskon</span>
                <span style="font-size:12px;color:var(--text-secondary);font-family:'JetBrains Mono',monospace;">- {{ $transaction->formatted_discount }}</span>
            </div>
            @endif
            <div style="display:flex;justify-content:space-between;padding-top:8px;border-top:1px solid var(--border);">
                <span style="font-size:14px;font-weight:700;color:var(--text-primary);">TOTAL</span>
                <span style="font-size:16px;font-weight:700;color:var(--text-primary);font-family:'JetBrains Mono',monospace;">{{ $transaction->formatted_grand_total }}</span>
            </div>
        </div>

        {{-- Status --}}
        <div style="text-align:center;margin-top:16px;">
            <span style="font-size:10px;padding:3px 12px;background:var(--bg-primary);color:var(--text-on-primary);font-weight:700;font-family:'JetBrains Mono',monospace;letter-spacing:0.1em;">LUNAS</span>
        </div>

        {{-- Footer --}}
        <p style="text-align:center;font-size:10px;color:var(--text-dim);margin-top:20px;font-family:'JetBrains Mono',monospace;">
            Terima kasih telah bertransaksi
        </p>
    </div>

    {{-- Actions --}}
    <div style="display:flex;gap:10px;margin-top:16px;justify-content:center;">
        <button onclick="window.print()" class="btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;">
                <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.092 1.086a1.875 1.875 0 0 0 1.868 2.064h9.408a1.875 1.875 0 0 0 1.868-2.064l-.092-1.086h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25Z" clip-rule="evenodd"/>
            </svg>
            Print
        </button>
        <a href="{{ route('pos.index') }}" class="btn-secondary">Transaksi Baru</a>
        <a href="{{ route('transactions.index') }}" class="btn-secondary">Riwayat</a>
    </div>
</div>

@push('styles')
<style>
    @media print {
        aside, header, .btn-primary, .btn-secondary, [style*="display:flex;gap:10px;margin-top:16px"] { display: none !important; }
        main { padding: 0 !important; }
        #receipt { border: none !important; }
    }
</style>
@endpush
@endsection
