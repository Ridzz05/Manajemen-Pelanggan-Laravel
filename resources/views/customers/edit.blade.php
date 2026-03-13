@extends('layouts.admin')
@section('title', 'Edit Pelanggan')
@section('page-title', 'Edit Pelanggan')
@section('page-subtitle', 'customer.edit')

@section('content')
<div style="max-width:560px;margin-top:8px;">
    <div class="nb-card">
        <div class="nb-card-header" style="background:#000;color:#00FF85;">
            <span style="font-size:11px;letter-spacing:0.12em;font-family:'Space Mono',monospace;">form.edit — id:{{ $customer->id }}</span>
        </div>
        <form method="POST" action="{{ route('customers.update', $customer) }}" style="padding:24px;display:flex;flex-direction:column;gap:18px;">
            @csrf @method('PUT')

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name', $customer->name) }}" required
                           style="width:100%;padding:10px 14px;font-size:13px;">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;margin-bottom:6px;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;">Telegram User ID *</label>
                    <input type="text" name="telegram_user_id" value="{{ old('telegram_user_id', $customer->telegram_user_id) }}" required style="width:100%;padding:10px 13px;border:3px solid #000;box-shadow:4px 4px 0 #000;font-size:13px;font-family:'Space Mono',monospace;">
                    @error('telegram_user_id') <p style="font-size:11px;color:#FF3B3B;margin-top:6px;font-weight:600;font-family:'Space Mono',monospace;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">No. WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                           style="width:100%;padding:10px 14px;font-size:13px;">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Nama Perusahaan</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $customer->company_name) }}"
                           style="width:100%;padding:10px 14px;font-size:13px;">
                </div>
            </div>

            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Nama Proyek *</label>
                <input type="text" name="project_name" value="{{ old('project_name', $customer->project_name) }}" required
                       style="width:100%;padding:10px 14px;font-size:13px;">
            </div>

            <div style="display:flex;gap:12px;padding-top:10px;border-top:2px solid #000;margin-top:8px;">
                <a href="{{ route('customers.index') }}" class="btn-nb btn-secondary" style="flex:1;justify-content:center;">Batal</a>
                <button type="submit" class="btn-nb btn-primary" style="flex:1;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:14px;height:14px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
