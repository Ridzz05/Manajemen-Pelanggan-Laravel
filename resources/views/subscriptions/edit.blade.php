@extends('layouts.admin')
@section('title', 'Edit Subscription')
@section('page-title', 'Edit Subscription')
@section('page-subtitle', 'subscription.edit')

@section('content')
<div style="max-width:600px;margin-top:8px;">
    <div style="border:1px solid #1a1a1a;background:#000;">
        <div style="padding:16px 20px;border-bottom:1px solid #1a1a1a;">
            <p style="font-size:10px;color:#444;letter-spacing:0.12em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">
                form.edit — id:{{ $subscription->id }}
            </p>
        </div>

        <form method="POST" action="{{ route('subscriptions.update', $subscription) }}"
              style="padding:20px;display:flex;flex-direction:column;gap:16px;">
            @csrf @method('PUT')

            <div class="r-form-grid">
                {{-- Pelanggan --}}
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Pelanggan *</label>
                    <select name="customer_id" required style="width:100%;padding:9px 12px;font-size:12px;">
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}" {{ old('customer_id',$subscription->customer_id)==$c->id ? 'selected':'' }}>
                                {{ $c->name }} / {{ $c->project_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kategori --}}
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Kategori *</label>
                    <select name="category_id" required style="width:100%;padding:9px 12px;font-size:12px;">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id',$subscription->category_id)==$cat->id ? 'selected':'' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Start Date --}}
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Mulai *</label>
                    <input type="date" name="start_date" required
                           value="{{ old('start_date', $subscription->start_date->toDateString()) }}"
                           style="width:100%;padding:9px 12px;font-size:12px;">
                </div>

                {{-- End Date --}}
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Berakhir *</label>
                    <input type="date" name="end_date" required
                           value="{{ old('end_date', $subscription->end_date->toDateString()) }}"
                           style="width:100%;padding:9px 12px;font-size:12px;">
                </div>

                {{-- Status --}}
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Status *</label>
                    <select name="status" required style="width:100%;padding:9px 12px;font-size:12px;">
                        <option value="active"    {{ old('status',$subscription->status)==='active'    ? 'selected':'' }}>active</option>
                        <option value="expired"   {{ old('status',$subscription->status)==='expired'   ? 'selected':'' }}>expired</option>
                        <option value="cancelled" {{ old('status',$subscription->status)==='cancelled' ? 'selected':'' }}>cancelled</option>
                    </select>
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Catatan</label>
                <textarea name="notes" rows="3"
                          style="width:100%;padding:9px 12px;font-size:12px;resize:none;">{{ old('notes', $subscription->notes) }}</textarea>
            </div>

            <div style="display:flex;gap:8px;padding-top:4px;">
                <a href="{{ route('subscriptions.index') }}" class="btn-secondary">Batal</a>
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
