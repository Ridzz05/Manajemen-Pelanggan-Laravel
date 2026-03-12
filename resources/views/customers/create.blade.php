@extends('layouts.admin')
@section('title', 'Tambah Pelanggan')
@section('page-title', 'Tambah Pelanggan')
@section('page-subtitle', 'customer.create')

@section('content')
<div style="max-width:640px;">
    <div class="nb-card">
        <div class="nb-card-header" style="background:#0066FF;color:#fff;">
            <span>Form Pelanggan Baru</span>
            <a href="{{ route('customers.index') }}" style="font-size:12px;color:#fff;text-decoration:none;opacity:.8;">← Kembali</a>
        </div>
        <form method="POST" action="{{ route('customers.store') }}" style="padding:24px;display:flex;flex-direction:column;gap:18px;">
            @csrf

            <div class="r-form-grid">
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:6px;">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="John Doe" style="width:100%;padding:10px 13px;">
                    @error('name') <p style="font-size:11px;color:#FF3B3B;margin-top:4px;font-weight:600;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:6px;">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="john@example.com" style="width:100%;padding:10px 13px;">
                    @error('email') <p style="font-size:11px;color:#FF3B3B;margin-top:4px;font-weight:600;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:6px;">No. WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" style="width:100%;padding:10px 13px;">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:6px;">Nama Perusahaan</label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="PT. Contoh (opsional)" style="width:100%;padding:10px 13px;">
                </div>
            </div>

            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:6px;">Nama Proyek *</label>
                <input type="text" name="project_name" value="{{ old('project_name') }}" required placeholder="Website Toko Online" style="width:100%;padding:10px 13px;">
                @error('project_name') <p style="font-size:11px;color:#FF3B3B;margin-top:4px;font-weight:600;">{{ $message }}</p> @enderror
            </div>

            <div style="display:flex;gap:10px;padding-top:4px;border-top:2px solid #000;margin-top:6px;">
                <a href="{{ route('customers.index') }}" class="btn-nb btn-secondary">Batal</a>
                <button type="submit" class="btn-nb btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:14px;height:14px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    Simpan Pelanggan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
