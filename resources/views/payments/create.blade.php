@extends('layouts.admin')
@section('title', 'Catat Pembayaran')
@section('page-title', 'Catat Pembayaran')
@section('page-subtitle', 'payment.create')

@section('content')
<div style="max-width:580px;margin-top:8px;">
    <div style="border:1px solid #1a1a1a;background:#000;">
        <div style="padding:14px 20px;border-bottom:1px solid #1a1a1a;">
            <p style="font-size:10px;color:#444;letter-spacing:0.12em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">form.new_payment</p>
        </div>

        <form method="POST" action="{{ route('payments.store') }}" style="padding:20px;display:flex;flex-direction:column;gap:14px;">
            @csrf

            {{-- Selected subscription info --}}
            @if($selectedSubscription)
                <div style="background:#0a0a0a;border:1px solid #1a1a1a;padding:12px 14px;display:flex;align-items:center;gap:10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;color:#444;flex-shrink:0;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                    </svg>
                    <div>
                        <p style="font-size:12px;color:#888;">{{ $selectedSubscription->customer->name }}</p>
                        <p style="font-size:11px;color:#444;font-family:'JetBrains Mono',monospace;">{{ $selectedSubscription->servicePackage->name }} — Rp {{ number_format($selectedSubscription->servicePackage->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endif

            {{-- Subscription --}}
            <div>
                <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Subscription *</label>
                <select name="subscription_id" required style="width:100%;padding:9px 12px;font-size:12px;">
                    <option value="">-- pilih subscription --</option>
                    @foreach($subscriptions as $sub)
                        <option value="{{ $sub->id }}"
                            {{ (old('subscription_id', request('subscription_id')) == $sub->id) ? 'selected' : '' }}>
                            {{ $sub->customer->name }} — {{ $sub->servicePackage->name ?? '' }} (s/d {{ $sub->end_date->format('d.m.Y') }})
                        </option>
                    @endforeach
                </select>
                @error('subscription_id') <p style="font-size:11px;color:#666;margin-top:4px;font-family:'JetBrains Mono',monospace;">{{ $message }}</p> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                {{-- Nominal --}}
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Nominal (Rp) *</label>
                    <input type="number" name="amount" value="{{ old('amount') }}" required min="0" placeholder="1500000"
                           style="width:100%;padding:9px 12px;font-size:12px;">
                    @error('amount') <p style="font-size:11px;color:#666;margin-top:4px;font-family:'JetBrains Mono',monospace;">{{ $message }}</p> @enderror
                </div>

                {{-- Metode --}}
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Metode Pembayaran *</label>
                    <select name="payment_method" required style="width:100%;padding:9px 12px;font-size:12px;">
                        @foreach(\App\Models\Payment::PAYMENT_METHODS as $method)
                            <option value="{{ $method }}" {{ old('payment_method', 'QRIS') === $method ? 'selected' : '' }}>
                                {{ $method }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Status Pembayaran *</label>
                    <select name="payment_status" required style="width:100%;padding:9px 12px;font-size:12px;">
                        <option value="pending" {{ old('payment_status')==='pending' ? 'selected':'' }}>pending</option>
                        <option value="paid"    {{ old('payment_status')==='paid'    ? 'selected':'' }}>paid / lunas</option>
                        <option value="failed"  {{ old('payment_status')==='failed'  ? 'selected':'' }}>failed / gagal</option>
                    </select>
                </div>

                {{-- Tanggal Pembayaran --}}
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Tanggal Bayar</label>
                    <input type="date" name="payment_date" value="{{ old('payment_date', now()->toDateString()) }}"
                           style="width:100%;padding:9px 12px;font-size:12px;">
                </div>

                {{-- Ref --}}
                <div style="grid-column:1/-1;">
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">No. Referensi Transaksi</label>
                    <input type="text" name="transaction_ref" value="{{ old('transaction_ref') }}" placeholder="Opsional — ID transaksi QRIS / bukti transfer"
                           style="width:100%;padding:9px 12px;font-size:12px;font-family:'JetBrains Mono',monospace;">
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Catatan</label>
                <textarea name="notes" rows="2" placeholder="catatan opsional..."
                          style="width:100%;padding:9px 12px;font-size:12px;resize:none;">{{ old('notes') }}</textarea>
            </div>

            <div style="display:flex;gap:8px;padding-top:4px;">
                <a href="{{ route('payments.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Catat Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
