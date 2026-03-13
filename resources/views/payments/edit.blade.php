@extends('layouts.admin')
@section('title', 'Edit Pembayaran')
@section('page-title', 'Edit Pembayaran')
@section('page-subtitle', 'payment.edit')

@section('content')
<div style="max-width:600px;margin-top:8px;">
    <div class="nb-card" style="background:#FFDD00;">
        <div class="nb-card-header" style="background:#000;color:#00FF85;">
            <span style="font-size:11px;letter-spacing:0.12em;font-family:'Space Mono',monospace;text-transform:uppercase;">form.pembayaran.edit — id:{{ $payment->id }}</span>
        </div>

        <form method="POST" action="{{ route('payments.update', $payment) }}" style="padding:24px;display:flex;flex-direction:column;gap:18px;">
            @csrf @method('PUT')

            {{-- Subscription --}}
            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Subscription *</label>
                <select name="subscription_id" required style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                    @foreach($subscriptions as $sub)
                        <option value="{{ $sub->id }}" {{ old('subscription_id', $payment->subscription_id) == $sub->id ? 'selected' : '' }}>
                            {{ $sub->customer->name }} — {{ $sub->servicePackage->name ?? '' }} (s/d {{ $sub->end_date->format('d.m.Y') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Nominal (Rp) *</label>
                    <input type="number" name="amount" value="{{ old('amount', $payment->amount) }}" required min="0"
                           style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                </div>

                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Metode *</label>
                    <select name="payment_method" required style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                        @foreach(\App\Models\Payment::PAYMENT_METHODS as $method)
                            <option value="{{ $method }}" {{ old('payment_method', $payment->payment_method) === $method ? 'selected' : '' }}>
                                {{ $method }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Status *</label>
                    <select name="payment_status" required style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                        <option value="pending" {{ old('payment_status', $payment->payment_status)==='pending' ? 'selected':'' }}>Pending</option>
                        <option value="paid"    {{ old('payment_status', $payment->payment_status)==='paid'    ? 'selected':'' }}>Paid / Lunas</option>
                        <option value="failed"  {{ old('payment_status', $payment->payment_status)==='failed'  ? 'selected':'' }}>Failed / Gagal</option>
                    </select>
                </div>

                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Tanggal Bayar</label>
                    <input type="date" name="payment_date"
                           value="{{ old('payment_date', $payment->payment_date ? $payment->payment_date->toDateString() : '') }}"
                           style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                </div>

                <div style="grid-column:1/-1;">
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">No. Referensi</label>
                    <input type="text" name="transaction_ref"
                           value="{{ old('transaction_ref', $payment->transaction_ref) }}"
                           style="width:100%;padding:10px 14px;font-size:13px;font-family:'Space Mono',monospace;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                </div>
            </div>

            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Catatan</label>
                <textarea name="notes" rows="2"
                          style="width:100%;padding:10px 14px;font-size:13px;resize:none;border:3px solid #000;box-shadow:4px 4px 0 #000;font-family:'Space Mono',monospace;">{{ old('notes', $payment->notes) }}</textarea>
            </div>

            <div style="display:flex;gap:12px;padding-top:14px;border-top:3px solid #000;margin-top:4px;">
                <a href="{{ route('payments.index') }}" class="btn-nb btn-secondary" style="flex:1;justify-content:center;background:#fff;">Batal</a>
                <button type="submit" class="btn-nb btn-primary" style="flex:1;justify-content:center;background:#0066FF;color:#fff;">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
