@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')
@section('page-subtitle', 'products.create')

@section('content')
<div style="max-width:640px;">
    <div class="nb-card" style="background:#FFDD00;">
        <div class="nb-card-header" style="background:#000;color:#00FF85;">
            <span style="font-size:11px;letter-spacing:0.12em;font-family:'Space Mono',monospace;text-transform:uppercase;">form.produk.baru</span>
        </div>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" style="padding:24px;display:flex;flex-direction:column;gap:18px;">
            @csrf

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Nama Produk *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                    @error('name') <p style="font-size:11px;color:#FF3B3B;margin-top:6px;font-weight:600;font-family:'Space Mono',monospace;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">SKU *</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" required style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                    @error('sku') <p style="font-size:11px;color:#FF3B3B;margin-top:6px;font-weight:600;font-family:'Space Mono',monospace;">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Kategori *</label>
                <select name="category_id" required style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                    <option value="">— Pilih Kategori —</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p style="font-size:11px;color:#FF3B3B;margin-top:6px;font-weight:600;font-family:'Space Mono',monospace;">{{ $message }}</p> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Harga (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" min="0" step="100" required style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                    @error('price') <p style="font-size:11px;color:#FF3B3B;margin-top:6px;font-weight:600;font-family:'Space Mono',monospace;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Stok *</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                    @error('stock') <p style="font-size:11px;color:#FF3B3B;margin-top:6px;font-weight:600;font-family:'Space Mono',monospace;">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Gambar Produk (Opsional)</label>
                <div style="background:#fff;padding:12px;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                    <input type="file" name="image" accept="image/jpeg,image/png,image/webp" style="width:100%;font-size:12px;font-family:'Space Mono',monospace;">
                </div>
                <p style="font-size:10px;color:#222;font-weight:600;margin-top:6px;font-family:'Space Mono',monospace;">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                @error('image') <p style="font-size:11px;color:#FF3B3B;margin-top:4px;font-weight:600;font-family:'Space Mono',monospace;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Deskripsi (Opsional)</label>
                <textarea name="description" rows="3" style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:4px 4px 0 #000;font-family:'Space Mono',monospace;">{{ old('description') }}</textarea>
            </div>

            <div style="display:flex;align-items:center;gap:10px;margin-top:4px;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width:20px;height:20px;accent-color:#000;cursor:pointer;">
                <label style="font-size:13px;font-weight:700;color:#000;cursor:pointer;">Aktif</label>
            </div>

            <div style="display:flex;gap:12px;margin-top:14px;padding-top:20px;border-top:3px solid #000;">
                <a href="{{ route('products.index') }}" class="btn-nb btn-secondary" style="flex:1;justify-content:center;background:#fff;">Batal</a>
                <button type="submit" class="btn-nb btn-primary" style="flex:1;justify-content:center;background:#0066FF;color:#fff;">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
