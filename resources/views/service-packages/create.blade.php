@extends('layouts.admin')
@section('title', 'Tambah Paket')
@section('page-title', 'Tambah Paket Layanan')
@section('page-subtitle', 'service_package.create')

@section('content')
<div style="max-width:520px;margin-top:8px;">
    <div style="border:1px solid #1a1a1a;background:#000;">
        <div style="padding:14px 20px;border-bottom:1px solid #1a1a1a;">
            <p style="font-size:10px;color:#444;letter-spacing:0.12em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">form.new_package</p>
        </div>
        <form method="POST" action="{{ route('service-packages.store') }}" style="padding:20px;display:flex;flex-direction:column;gap:14px;">
            @csrf

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div style="grid-column:1/-1;">
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Nama Paket *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Website Company Profile"
                           style="width:100%;padding:9px 12px;font-size:12px;">
                    @error('name') <p style="font-size:11px;color:#666;margin-top:4px;font-family:'JetBrains Mono',monospace;">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Harga (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0" placeholder="1500000"
                           style="width:100%;padding:9px 12px;font-size:12px;">
                    @error('price') <p style="font-size:11px;color:#666;margin-top:4px;font-family:'JetBrains Mono',monospace;">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Status</label>
                    <div style="display:flex;align-items:center;gap:10px;padding:9px 12px;border:1px solid #2a2a2a;">
                        <input type="checkbox" name="is_active" value="1" id="is_active"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               style="width:14px;height:14px;accent-color:#fff;cursor:pointer;">
                        <label for="is_active" style="font-size:12px;color:#777;cursor:pointer;font-family:'JetBrains Mono',monospace;">Paket Aktif</label>
                    </div>
                </div>
            </div>

            <div>
                <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Deskripsi</label>
                <textarea name="description" rows="4" placeholder="Deskripsi fitur paket ini..."
                          style="width:100%;padding:9px 12px;font-size:12px;resize:vertical;">{{ old('description') }}</textarea>
            </div>

            <div style="display:flex;gap:8px;padding-top:4px;">
                <a href="{{ route('service-packages.index') }}" class="btn-secondary">Batal</a>
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
