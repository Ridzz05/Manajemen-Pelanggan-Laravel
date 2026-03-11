@extends('layouts.admin')
@section('title', 'Tambah Subscription')
@section('page-title', 'Tambah Subscription')
@section('page-subtitle', 'subscription.create')

@section('content')
<div style="max-width:600px;margin-top:8px;">
    <div style="border:1px solid #1a1a1a;background:#000;">
        <div style="padding:16px 20px;border-bottom:1px solid #1a1a1a;">
            <p style="font-size:10px;color:#444;letter-spacing:0.12em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">form.new_subscription</p>
        </div>

        <form method="POST" action="{{ route('subscriptions.store') }}" style="padding:20px;display:flex;flex-direction:column;gap:16px;">
            @csrf

            <div class="r-form-grid">
                {{-- Pelanggan --}}
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">
                        Pelanggan *
                    </label>
                    <select name="customer_id" required style="width:100%;padding:9px 12px;font-size:12px;">
                        <option value="">-- pilih pelanggan --</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}" {{ old('customer_id')==$c->id ? 'selected':'' }}>
                                {{ $c->name }} / {{ $c->project_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id') <p style="font-size:11px;color:#666;margin-top:4px;font-family:'JetBrains Mono',monospace;">{{ $message }}</p> @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">
                        Kategori *
                    </label>
                    <select name="category_id" required style="width:100%;padding:9px 12px;font-size:12px;">
                        <option value="">-- pilih kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id ? 'selected':'' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p style="font-size:11px;color:#666;margin-top:4px;font-family:'JetBrains Mono',monospace;">{{ $message }}</p> @enderror
                </div>

                {{-- Start Date --}}
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">
                        Tanggal Mulai *
                    </label>
                    <input type="date" name="start_date" required
                           value="{{ old('start_date', now()->toDateString()) }}"
                           style="width:100%;padding:9px 12px;font-size:12px;">
                </div>

                {{-- End Date --}}
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">
                        Tanggal Berakhir *
                    </label>
                    <input type="date" name="end_date" required
                           value="{{ old('end_date', now()->addYear()->toDateString()) }}"
                           style="width:100%;padding:9px 12px;font-size:12px;">
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">
                    Catatan
                </label>
                <textarea name="notes" rows="3"
                          placeholder="catatan opsional..."
                          style="width:100%;padding:9px 12px;font-size:12px;resize:none;">{{ old('notes') }}</textarea>
            </div>

            <div style="display:flex;gap:8px;padding-top:4px;">
                <a href="{{ route('subscriptions.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
