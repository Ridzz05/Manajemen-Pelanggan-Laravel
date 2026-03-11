@extends('layouts.admin')
@section('title', 'Edit Paket')
@section('page-title', 'Edit Paket Layanan')
@section('page-subtitle', 'service_package.edit')

@section('content')
<div style="max-width:520px;margin-top:8px;">
    <div style="border:1px solid #1a1a1a;background:#000;">
        <div style="padding:14px 20px;border-bottom:1px solid #1a1a1a;">
            <p style="font-size:10px;color:#444;letter-spacing:0.12em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;">form.edit — id:{{ $servicePackage->id }}</p>
        </div>
        <form method="POST" action="{{ route('service-packages.update', $servicePackage) }}" style="padding:20px;display:flex;flex-direction:column;gap:14px;">
            @csrf @method('PUT')

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div style="grid-column:1/-1;">
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Nama Paket *</label>
                    <input type="text" name="name" value="{{ old('name', $servicePackage->name) }}" required
                           style="width:100%;padding:9px 12px;font-size:12px;">
                </div>

                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Harga (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price', $servicePackage->price) }}" required min="0"
                           style="width:100%;padding:9px 12px;font-size:12px;">
                </div>

                <div>
                    <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Status</label>
                    <div style="display:flex;align-items:center;gap:10px;padding:9px 12px;border:1px solid #2a2a2a;">
                        <input type="checkbox" name="is_active" value="1" id="is_active"
                               {{ old('is_active', $servicePackage->is_active) ? 'checked' : '' }}
                               style="width:14px;height:14px;accent-color:#fff;cursor:pointer;">
                        <label for="is_active" style="font-size:12px;color:#777;cursor:pointer;font-family:'JetBrains Mono',monospace;">Paket Aktif</label>
                    </div>
                </div>
            </div>

            <div>
                <label style="display:block;font-size:10px;color:#555;letter-spacing:0.1em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">Deskripsi</label>
                <textarea name="description" rows="4"
                          style="width:100%;padding:9px 12px;font-size:12px;resize:vertical;">{{ old('description', $servicePackage->description) }}</textarea>
            </div>

            <div style="display:flex;gap:8px;padding-top:4px;">
                <a href="{{ route('service-packages.index') }}" class="btn-secondary">Batal</a>
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
