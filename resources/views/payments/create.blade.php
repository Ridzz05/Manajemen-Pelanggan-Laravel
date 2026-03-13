@extends('layouts.admin')
@section('title', 'Catat Pembayaran')
@section('page-title', 'Catat Pembayaran')
@section('page-subtitle', 'payment.create')

@section('content')
<div style="max-width:600px;margin-top:8px;">
    <div class="nb-card" style="background:#00FF85;">
        <div class="nb-card-header" style="background:#000;color:#FFDD00;">
            <span style="font-size:11px;letter-spacing:0.12em;font-family:'Space Mono',monospace;text-transform:uppercase;">form.pembayaran.baru</span>
        </div>

        <form method="POST" action="{{ route('payments.store') }}" style="padding:24px;display:flex;flex-direction:column;gap:18px;">
            @csrf

            {{-- Selected subscription info --}}
            @if($selectedSubscription)
                <div style="background:#fff;border:3px solid #000;box-shadow:4px 4px 0 #000;padding:14px;display:flex;align-items:center;gap:14px;">
                    <div style="width:40px;height:40px;background:#000;display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:20px;height:20px;color:#FFDD00;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                        </svg>
                    </div>
                    <div>
                        <p style="font-size:14px;font-weight:800;color:#000;">{{ $selectedSubscription->customer->name }}</p>
                        <p style="font-size:12px;font-weight:600;color:#444;font-family:'Space Mono',monospace;margin-top:2px;">{{ $selectedSubscription->servicePackage->name }} — Rp {{ number_format($selectedSubscription->servicePackage->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endif

            {{-- Subscription --}}
            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Subscription *</label>
                <select name="subscription_id" required style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                    <option value="">-- Pilih Subscription --</option>
                    @foreach($subscriptions as $sub)
                        <option value="{{ $sub->id }}"
                            {{ (old('subscription_id', request('subscription_id')) == $sub->id) ? 'selected' : '' }}>
                            {{ $sub->customer->name }} — {{ $sub->servicePackage->name ?? '' }} (s/d {{ $sub->end_date->format('d.m.Y') }})
                        </option>
                    @endforeach
                </select>
                @error('subscription_id') <p style="font-size:11px;color:#FF3B3B;margin-top:6px;font-weight:600;font-family:'Space Mono',monospace;">{{ $message }}</p> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
                {{-- Nominal --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Nominal (Rp) *</label>
                    <input type="number" name="amount" value="{{ old('amount') }}" required min="0" placeholder="1500000"
                           style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                    @error('amount') <p style="font-size:11px;color:#FF3B3B;margin-top:6px;font-weight:600;font-family:'Space Mono',monospace;">{{ $message }}</p> @enderror
                </div>

                {{-- Metode --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Metode Pembayaran *</label>
                    <select name="payment_method" required style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                        @foreach(\App\Models\Payment::PAYMENT_METHODS as $method)
                            <option value="{{ $method }}" {{ old('payment_method', 'QRIS') === $method ? 'selected' : '' }}>
                                {{ $method }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Status Pembayaran *</label>
                    <select name="payment_status" required style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                        <option value="pending" {{ old('payment_status')==='pending' ? 'selected':'' }}>Pending</option>
                        <option value="paid"    {{ old('payment_status')==='paid'    ? 'selected':'' }}>Paid / Lunas</option>
                        <option value="failed"  {{ old('payment_status')==='failed'  ? 'selected':'' }}>Failed / Gagal</option>
                    </select>
                </div>

                {{-- Tanggal Pembayaran --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Tanggal Bayar</label>
                    <input type="date" name="payment_date" value="{{ old('payment_date', now()->toDateString()) }}"
                           style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                </div>

                {{-- Ref --}}
                <div style="grid-column:1/-1;">
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">No. Referensi Transaksi</label>
                    <input type="text" name="transaction_ref" value="{{ old('transaction_ref') }}" placeholder="Opsional — ID transaksi QRIS / bukti transfer"
                           style="width:100%;padding:10px 14px;font-size:13px;font-family:'Space Mono',monospace;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Catatan (Opsional)</label>
                <textarea name="notes" rows="2" placeholder="Catatan opsional..."
                          style="width:100%;padding:10px 14px;font-size:13px;resize:none;border:3px solid #000;box-shadow:4px 4px 0 #000;font-family:'Space Mono',monospace;">{{ old('notes') }}</textarea>
            </div>

            <div style="display:flex;gap:12px;padding-top:14px;border-top:3px solid #000;margin-top:4px;">
                <a href="{{ route('payments.index') }}" class="btn-nb btn-secondary" style="flex:1;justify-content:center;background:#fff;">Batal</a>
                <button type="submit" class="btn-nb btn-primary" style="flex:1;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:14px;height:14px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Catat Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
