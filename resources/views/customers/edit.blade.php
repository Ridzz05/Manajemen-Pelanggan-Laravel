@extends('layouts.admin')
@section('title', 'Edit Pelanggan')
@section('page-title', 'Edit Pelanggan')
@section('page-subtitle', 'customer.edit')

@section('content')
<div style="max-width:560px;margin-top:8px;">
    <div style="border:1px solid #1a1a1a;background:#000;">
        <div style="padding:14px 20px;border-bottom:1px solid #1a1a1a;">
            <p style="font-size:10px;color:#444;letter-spacing:0.12em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">form.edit — id:{{ $customer->id }}</p>
        </div>
        <form method="POST" action="{{ route('customers.update', $customer) }}" style="padding:20px;display:flex;flex-direction:column;gap:14px;">
            @csrf @method('PUT')

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name', $customer->name) }}" required
                           style="width:100%;padding:9px 12px;font-size:12px;">
                </div>
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}" required
                           style="width:100%;padding:9px 12px;font-size:12px;">
                    @error('email') <p style="font-size:11px;color:#666;margin-top:4px;font-family:'JetBrains Mono',monospace;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">No. WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                           style="width:100%;padding:9px 12px;font-size:12px;">
                </div>
                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Nama Perusahaan</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $customer->company_name) }}"
                           style="width:100%;padding:9px 12px;font-size:12px;">
                </div>
            </div>

            <div>
                <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Nama Proyek *</label>
                <input type="text" name="project_name" value="{{ old('project_name', $customer->project_name) }}" required
                       style="width:100%;padding:9px 12px;font-size:12px;">
            </div>

            <div style="display:flex;gap:8px;padding-top:4px;">
                <a href="{{ route('customers.index') }}" class="btn-secondary">Batal</a>
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
