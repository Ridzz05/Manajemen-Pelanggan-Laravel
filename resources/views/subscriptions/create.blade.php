@extends('layouts.admin')
@section('title', 'Tambah Subscription')
@section('page-title', 'Tambah Subscription')
@section('page-subtitle', 'subscription.create')

@section('content')
<div style="max-width:640px;margin-top:8px;">
    <div class="nb-card" style="background:#00FF85;">
        <div class="nb-card-header" style="background:#000;color:#00FF85;">
            <span style="font-size:11px;letter-spacing:0.12em;font-family:'Space Mono',monospace;text-transform:uppercase;">form.subscription.baru</span>
        </div>

        <form method="POST" action="{{ route('subscriptions.store') }}" style="padding:24px;display:flex;flex-direction:column;gap:18px;">
            @csrf

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
                {{-- Pelanggan --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">
                        Pelanggan *
                    </label>
                    <select name="customer_id" required style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}" {{ old('customer_id')==$c->id ? 'selected':'' }}>
                                {{ $c->name }} / {{ $c->project_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id') <p style="font-size:11px;color:#FF3B3B;margin-top:6px;font-weight:600;font-family:'Space Mono',monospace;">{{ $message }}</p> @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">
                        Kategori *
                    </label>
                    <select name="category_id" required style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id ? 'selected':'' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p style="font-size:11px;color:#FF3B3B;margin-top:6px;font-weight:600;font-family:'Space Mono',monospace;">{{ $message }}</p> @enderror
                </div>

                {{-- Start Date --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">
                        Tanggal Mulai *
                    </label>
                    <input type="date" name="start_date" required
                           value="{{ old('start_date', now()->toDateString()) }}"
                           style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                </div>

                {{-- End Date --}}
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">
                        Tanggal Berakhir *
                    </label>
                    <input type="date" name="end_date" required
                           value="{{ old('end_date', now()->addYear()->toDateString()) }}"
                           style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">
                    Catatan (Opsional)
                </label>
                <textarea name="notes" rows="3"
                          placeholder="Catatan opsional..."
                          style="width:100%;padding:10px 14px;font-size:13px;resize:none;border:3px solid #000;box-shadow:4px 4px 0 #000;font-family:'Space Mono',monospace;">{{ old('notes') }}</textarea>
            </div>

            <div style="display:flex;gap:12px;padding-top:20px;border-top:3px solid #000;margin-top:4px;">
                <a href="{{ route('subscriptions.index') }}" class="btn-nb btn-secondary" style="flex:1;justify-content:center;background:#fff;">Batal</a>
                <button type="submit" class="btn-nb btn-primary" style="flex:1;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:14px;height:14px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
