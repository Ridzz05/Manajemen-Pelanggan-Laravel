@extends('layouts.admin')

@section('title', $transaction->invoice_number)
@section('page-title', 'Detail Transaksi')
@section('page-subtitle', $transaction->invoice_number)

@section('content')
<div style="display:flex;flex-direction:column;gap:24px;max-width:700px;margin-top:8px;">

    {{-- Info Panel --}}
    <div class="nb-card" style="background:#FFDD00;">
        <div class="nb-card-header" style="background:#000;color:#FFDD00;">
            <span style="font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Info Transaksi</span>
        </div>
        <div style="padding:24px;display:grid;grid-template-columns:1fr 1fr;gap:20px;">
            <div>
                <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;margin-bottom:6px;font-family:'Space Mono',monospace;">INVOICE</p>
                <p style="font-size:14px;font-weight:800;color:#000;font-family:'Space Mono',monospace;">{{ $transaction->invoice_number }}</p>
            </div>
            <div>
                <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;margin-bottom:6px;font-family:'Space Mono',monospace;">TANGGAL</p>
                <p style="font-size:14px;font-weight:700;color:#000;font-family:'Space Mono',monospace;">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</p>
            </div>
            <div>
                <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;margin-bottom:6px;font-family:'Space Mono',monospace;">PELANGGAN</p>
                <p style="font-size:14px;font-weight:800;color:#000;">{{ $transaction->customer->name ?? 'Umum' }}</p>
            </div>
            <div>
                <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;margin-bottom:6px;font-family:'Space Mono',monospace;">METODE BAYAR</p>
                <p style="font-size:14px;font-weight:700;color:#000;">{{ $transaction->payment_method }}</p>
            </div>
            <div>
                <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;margin-bottom:6px;font-family:'Space Mono',monospace;">STATUS</p>
                @if($transaction->payment_status === 'paid')
                    <span class="badge badge-success">LUNAS</span>
                @elseif($transaction->payment_status === 'pending')
                    <span class="badge badge-warning">PENDING</span>
                @else
                    <span class="badge badge-danger">GAGAL</span>
                @endif
            </div>
            @if($transaction->notes)
            <div>
                <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;letter-spacing:0.1em;margin-bottom:6px;font-family:'Space Mono',monospace;">CATATAN</p>
                <p style="font-size:13px;font-weight:600;color:#222;font-family:'Space Mono',monospace;">{{ $transaction->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Items Table --}}
    <div class="nb-card" style="background:#fff;">
        <div class="nb-card-header" style="background:#000;color:#00FF85;">
            <span style="font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Item Transaksi</span>
        </div>
        <div class="r-table-wrap">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="text-align:left;padding:12px 16px;">Produk</th>
                        <th style="text-align:right;padding:12px 16px;">Harga</th>
                        <th style="text-align:center;padding:12px 16px;">Qty</th>
                        <th style="text-align:right;padding:12px 16px;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->items as $item)
                    <tr>
                        <td style="padding:12px 16px;font-size:14px;font-weight:800;color:#000;">{{ $item->product_name }}</td>
                        <td style="padding:12px 16px;text-align:right;font-size:13px;font-weight:600;color:#444;font-family:'Space Mono',monospace;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="padding:12px 16px;text-align:center;font-size:14px;font-weight:800;color:#000;font-family:'Space Mono',monospace;">{{ $item->quantity }}</td>
                        <td style="padding:12px 16px;text-align:right;font-size:14px;font-weight:800;color:#000;font-family:'Space Mono',monospace;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="border-top:3px solid #000;">
                        <td colspan="3" style="padding:12px 16px;text-align:right;font-size:12px;font-weight:700;color:#000;letter-spacing:0.05em;text-transform:uppercase;">Subtotal</td>
                        <td style="padding:12px 16px;text-align:right;font-size:14px;font-weight:800;color:#000;font-family:'Space Mono',monospace;">{{ $transaction->formatted_total_amount }}</td>
                    </tr>
                    @if($transaction->discount > 0)
                    <tr>
                        <td colspan="3" style="padding:8px 16px 12px;text-align:right;font-size:12px;font-weight:700;color:#000;letter-spacing:0.05em;text-transform:uppercase;">Diskon</td>
                        <td style="padding:8px 16px 12px;text-align:right;font-size:14px;font-weight:800;color:#FF3B3B;font-family:'Space Mono',monospace;">- {{ $transaction->formatted_discount }}</td>
                    </tr>
                    @endif
                    <tr style="border-top:3px solid #000;background:#FFDD00;">
                        <td colspan="3" style="padding:16px;text-align:right;font-size:16px;font-weight:800;color:#000;letter-spacing:0.05em;text-transform:uppercase;">TOTAL</td>
                        <td style="padding:16px;text-align:right;font-size:20px;font-weight:800;color:#000;font-family:'Space Mono',monospace;">{{ $transaction->formatted_grand_total }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div style="display:flex;gap:12px;margin-top:8px;">
        <a href="{{ route('pos.receipt', $transaction) }}" class="btn-nb btn-primary" style="flex:1;justify-content:center;background:#0066FF;color:#fff;">Print Struk</a>
        <a href="{{ route('transactions.index') }}" class="btn-nb btn-secondary" style="flex:1;justify-content:center;background:#fff;">Kembali</a>
    </div>
</div>
@endsection
