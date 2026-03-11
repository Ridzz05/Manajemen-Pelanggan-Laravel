@extends('layouts.admin')
@section('title', 'Edit Pembayaran')
@section('page-title', 'Edit Pembayaran')
@section('page-subtitle', 'payment.edit')

@section('content')
<div style="max-width:580px;margin-top:8px;">
    <div style="border:1px solid #1a1a1a;background:#000;">
        <div style="padding:14px 20px;border-bottom:1px solid #1a1a1a;">
            <p style="font-size:10px;color:#444;letter-spacing:0.12em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">form.edit — id:{{ $payment->id }}</p>
        </div>

        <form method="POST" action="{{ route('payments.update', $payment) }}" style="padding:20px;display:flex;flex-direction:column;gap:14px;">
            @csrf @method('PUT')

            {{-- Subscription --}}
            <div>
                <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Subscription *</label>
                <select name="subscription_id" required style="width:100%;padding:9px 12px;font-size:12px;">
                    @foreach($subscriptions as $sub)
                        <option value="{{ $sub->id }}" {{ old('subscription_id', $payment->subscription_id) == $sub->id ? 'selected' : '' }}>
                            {{ $sub->customer->name }} — {{ $sub->servicePackage->name ?? '' }} (s/d {{ $sub->end_date->format('d.m.Y') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Nominal (Rp) *</label>
                    <input type="number" name="amount" value="{{ old('amount', $payment->amount) }}" required min="0"
                           style="width:100%;padding:9px 12px;font-size:12px;">
                </div>

                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Metode *</label>
                    <select name="payment_method" required style="width:100%;padding:9px 12px;font-size:12px;">
                        @foreach(\App\Models\Payment::PAYMENT_METHODS as $method)
                            <option value="{{ $method }}" {{ old('payment_method', $payment->payment_method) === $method ? 'selected' : '' }}>
                                {{ $method }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Status *</label>
                    <select name="payment_status" required style="width:100%;padding:9px 12px;font-size:12px;">
                        <option value="pending" {{ old('payment_status', $payment->payment_status)==='pending' ? 'selected':'' }}>pending</option>
                        <option value="paid"    {{ old('payment_status', $payment->payment_status)==='paid'    ? 'selected':'' }}>paid / lunas</option>
                        <option value="failed"  {{ old('payment_status', $payment->payment_status)==='failed'  ? 'selected':'' }}>failed / gagal</option>
                    </select>
                </div>

                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Tanggal Bayar</label>
                    <input type="date" name="payment_date"
                           value="{{ old('payment_date', $payment->payment_date ? $payment->payment_date->toDateString() : '') }}"
                           style="width:100%;padding:9px 12px;font-size:12px;">
                </div>

                <div style="grid-column:1/-1;">
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">No. Referensi</label>
                    <input type="text" name="transaction_ref"
                           value="{{ old('transaction_ref', $payment->transaction_ref) }}"
                           style="width:100%;padding:9px 12px;font-size:12px;font-family:'JetBrains Mono',monospace;">
                </div>
            </div>

            <div>
                <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Catatan</label>
                <textarea name="notes" rows="2"
                          style="width:100%;padding:9px 12px;font-size:12px;resize:none;">{{ old('notes', $payment->notes) }}</textarea>
            </div>

            <div style="display:flex;gap:8px;padding-top:4px;">
                <a href="{{ route('payments.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
