@extends('layouts.admin')

@section('title', $transaction->invoice_number)
@section('page-title', 'Detail Transaksi')
@section('page-subtitle', $transaction->invoice_number)

@section('content')
<div style="display:flex;flex-direction:column;gap:20px;max-width:700px;">

    {{-- Info Panel --}}
    <div style="border:1px solid var(--border);background:var(--bg-surface);">
        <div style="padding:16px 18px;border-bottom:1px solid var(--border);">
            <span style="font-size:11px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-muted);">Info Transaksi</span>
        </div>
        <div style="padding:16px 18px;display:grid;grid-template-columns:1fr 1fr;gap:14px;">
            <div>
                <p style="font-size:10px;color:var(--text-dim);letter-spacing:0.05em;margin-bottom:2px;">INVOICE</p>
                <p style="font-size:13px;font-weight:500;color:var(--text-primary);font-family:'JetBrains Mono',monospace;">{{ $transaction->invoice_number }}</p>
            </div>
            <div>
                <p style="font-size:10px;color:var(--text-dim);letter-spacing:0.05em;margin-bottom:2px;">TANGGAL</p>
                <p style="font-size:13px;color:var(--text-primary);font-family:'JetBrains Mono',monospace;">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</p>
            </div>
            <div>
                <p style="font-size:10px;color:var(--text-dim);letter-spacing:0.05em;margin-bottom:2px;">PELANGGAN</p>
                <p style="font-size:13px;color:var(--text-primary);">{{ $transaction->customer->name ?? 'Umum' }}</p>
            </div>
            <div>
                <p style="font-size:10px;color:var(--text-dim);letter-spacing:0.05em;margin-bottom:2px;">METODE BAYAR</p>
                <p style="font-size:13px;color:var(--text-primary);">{{ $transaction->payment_method }}</p>
            </div>
            <div>
                <p style="font-size:10px;color:var(--text-dim);letter-spacing:0.05em;margin-bottom:2px;">STATUS</p>
                @if($transaction->payment_status === 'paid')
                    <span style="font-size:10px;padding:2px 8px;background:var(--bg-primary);color:var(--text-on-primary);font-weight:700;font-family:'JetBrains Mono',monospace;">LUNAS</span>
                @elseif($transaction->payment_status === 'pending')
                    <span style="font-size:10px;padding:2px 8px;border:1px solid var(--border-mid);color:var(--text-muted);font-family:'JetBrains Mono',monospace;">PENDING</span>
                @else
                    <span style="font-size:10px;padding:2px 8px;border:1px solid var(--border-dim);color:var(--text-dim);font-family:'JetBrains Mono',monospace;">GAGAL</span>
                @endif
            </div>
            @if($transaction->notes)
            <div>
                <p style="font-size:10px;color:var(--text-dim);letter-spacing:0.05em;margin-bottom:2px;">CATATAN</p>
                <p style="font-size:13px;color:var(--text-secondary);">{{ $transaction->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Items Table --}}
    <div style="border:1px solid var(--border);background:var(--bg-surface);">
        <div style="padding:16px 18px;border-bottom:1px solid var(--border);">
            <span style="font-size:11px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-muted);">Item Transaksi</span>
        </div>
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid var(--border);">
                    <th style="text-align:left;padding:10px 18px;">Produk</th>
                    <th style="text-align:right;padding:10px 18px;">Harga</th>
                    <th style="text-align:center;padding:10px 18px;">Qty</th>
                    <th style="text-align:right;padding:10px 18px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->items as $item)
                <tr style="border-bottom:1px solid var(--border-dim);">
                    <td style="padding:10px 18px;font-size:13px;color:var(--text-primary);">{{ $item->product_name }}</td>
                    <td style="padding:10px 18px;text-align:right;font-size:12px;color:var(--text-muted);font-family:'JetBrains Mono',monospace;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td style="padding:10px 18px;text-align:center;font-size:13px;color:var(--text-primary);font-family:'JetBrains Mono',monospace;">{{ $item->quantity }}</td>
                    <td style="padding:10px 18px;text-align:right;font-size:13px;font-weight:600;color:var(--text-primary);font-family:'JetBrains Mono',monospace;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="border-top:1px solid var(--border);">
                    <td colspan="3" style="padding:10px 18px;text-align:right;font-size:12px;color:var(--text-muted);">Subtotal</td>
                    <td style="padding:10px 18px;text-align:right;font-size:13px;color:var(--text-secondary);font-family:'JetBrains Mono',monospace;">{{ $transaction->formatted_total_amount }}</td>
                </tr>
                @if($transaction->discount > 0)
                <tr>
                    <td colspan="3" style="padding:4px 18px 10px;text-align:right;font-size:12px;color:var(--text-muted);">Diskon</td>
                    <td style="padding:4px 18px 10px;text-align:right;font-size:13px;color:var(--text-secondary);font-family:'JetBrains Mono',monospace;">- {{ $transaction->formatted_discount }}</td>
                </tr>
                @endif
                <tr style="border-top:1px solid var(--border);">
                    <td colspan="3" style="padding:12px 18px;text-align:right;font-size:14px;font-weight:700;color:var(--text-primary);">TOTAL</td>
                    <td style="padding:12px 18px;text-align:right;font-size:16px;font-weight:700;color:var(--text-primary);font-family:'JetBrains Mono',monospace;">{{ $transaction->formatted_grand_total }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div style="display:flex;gap:10px;">
        <a href="{{ route('pos.receipt', $transaction) }}" class="btn-primary">Print Struk</a>
        <a href="{{ route('transactions.index') }}" class="btn-secondary">Kembali</a>
    </div>
</div>
@endsection
