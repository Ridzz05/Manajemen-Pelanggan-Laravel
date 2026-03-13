@extends('layouts.admin')
@section('title', 'Edit Subscription')
@section('page-title', 'Edit Subscription')
@section('page-subtitle', 'subscription.edit')

@section('content')
<div style="max-width:640px;margin-top:8px;">
    <div class="nb-card" style="background:#00FF85;">
        <div class="nb-card-header" style="background:#000;color:#00FF85;">
            <span style="font-size:11px;letter-spacing:0.12em;font-family:'Space Mono',monospace;text-transform:uppercase;">form.subscription.edit — id:{{ $subscription->id }}</span>
        </div>

        <form method="POST" action="{{ route('subscriptions.update', $subscription) }}"
              style="padding:24px;display:flex;flex-direction:column;gap:18px;">
            @csrf @method('PUT')

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
                {{-- Pelanggan --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Pelanggan *</label>
                    <select name="customer_id" required style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}" {{ old('customer_id',$subscription->customer_id)==$c->id ? 'selected':'' }}>
                                {{ $c->name }} / {{ $c->project_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kategori --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Kategori *</label>
                    <select name="category_id" required style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id',$subscription->category_id)==$cat->id ? 'selected':'' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Start Date --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Mulai *</label>
                    <input type="date" name="start_date" required
                           value="{{ old('start_date', $subscription->start_date->toDateString()) }}"
                           style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                </div>

                {{-- End Date --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Berakhir *</label>
                    <input type="date" name="end_date" required
                           value="{{ old('end_date', $subscription->end_date->toDateString()) }}"
                           style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                </div>

                {{-- Status --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Status *</label>
                    <select name="status" required style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                        <option value="active"    {{ old('status',$subscription->status)==='active'    ? 'selected':'' }}>Active</option>
                        <option value="expired"   {{ old('status',$subscription->status)==='expired'   ? 'selected':'' }}>Expired</option>
                        <option value="cancelled" {{ old('status',$subscription->status)==='cancelled' ? 'selected':'' }}>Cancelled</option>
                    </select>
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Catatan (Opsional)</label>
                <textarea name="notes" rows="3"
                          style="width:100%;padding:10px 14px;font-size:13px;resize:none;border:3px solid #000;box-shadow:4px 4px 0 #000;font-family:'Space Mono',monospace;">{{ old('notes', $subscription->notes) }}</textarea>
            </div>

            <div style="display:flex;gap:12px;padding-top:20px;border-top:3px solid #000;margin-top:4px;">
                <a href="{{ route('subscriptions.index') }}" class="btn-nb btn-secondary" style="flex:1;justify-content:center;background:#fff;">Batal</a>
                <button type="submit" class="btn-nb btn-primary" style="flex:1;justify-content:center;background:#0066FF;color:#fff;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:14px;height:14px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
