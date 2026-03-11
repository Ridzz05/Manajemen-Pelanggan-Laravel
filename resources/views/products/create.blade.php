@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')
@section('page-subtitle', 'products.create')

@section('content')
<div style="max-width:600px;">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" style="display:flex;flex-direction:column;gap:16px;">
        @csrf

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div>
                <label style="font-size:11px;font-weight:600;color:var(--text-muted);letter-spacing:0.05em;display:block;margin-bottom:6px;">NAMA PRODUK</label>
                <input type="text" name="name" value="{{ old('name') }}" required style="width:100%;padding:8px 12px;">
                @error('name') <p style="color:#888;font-size:11px;margin-top:4px;">{{ $message }}</p> @enderror
            </div>
            <div>
                <label style="font-size:11px;font-weight:600;color:var(--text-muted);letter-spacing:0.05em;display:block;margin-bottom:6px;">SKU</label>
                <input type="text" name="sku" value="{{ old('sku') }}" required style="width:100%;padding:8px 12px;">
                @error('sku') <p style="color:#888;font-size:11px;margin-top:4px;">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label style="font-size:11px;font-weight:600;color:var(--text-muted);letter-spacing:0.05em;display:block;margin-bottom:6px;">KATEGORI</label>
            <select name="category_id" required style="width:100%;padding:8px 12px;">
                <option value="">— Pilih Kategori —</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p style="color:#888;font-size:11px;margin-top:4px;">{{ $message }}</p> @enderror
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div>
                <label style="font-size:11px;font-weight:600;color:var(--text-muted);letter-spacing:0.05em;display:block;margin-bottom:6px;">HARGA (Rp)</label>
                <input type="number" name="price" value="{{ old('price') }}" min="0" step="100" required style="width:100%;padding:8px 12px;">
                @error('price') <p style="color:#888;font-size:11px;margin-top:4px;">{{ $message }}</p> @enderror
            </div>
            <div>
                <label style="font-size:11px;font-weight:600;color:var(--text-muted);letter-spacing:0.05em;display:block;margin-bottom:6px;">STOK</label>
                <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required style="width:100%;padding:8px 12px;">
                @error('stock') <p style="color:#888;font-size:11px;margin-top:4px;">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label style="font-size:11px;font-weight:600;color:var(--text-muted);letter-spacing:0.05em;display:block;margin-bottom:6px;">GAMBAR PRODUK (opsional)</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp" style="width:100%;padding:8px 12px;font-size:12px;">
            <p style="font-size:10px;color:var(--text-dim);margin-top:4px;font-family:'JetBrains Mono',monospace;">Format: JPG, PNG, WEBP. Maks 2MB.</p>
            @error('image') <p style="color:#888;font-size:11px;margin-top:4px;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label style="font-size:11px;font-weight:600;color:var(--text-muted);letter-spacing:0.05em;display:block;margin-bottom:6px;">DESKRIPSI (opsional)</label>
            <textarea name="description" rows="3" style="width:100%;padding:8px 12px;">{{ old('description') }}</textarea>
        </div>

        <div style="display:flex;align-items:center;gap:8px;">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width:16px;height:16px;">
            <label style="font-size:12px;color:var(--text-secondary);">Aktif</label>
        </div>

        <div style="display:flex;gap:10px;margin-top:8px;">
            <button type="submit" class="btn-primary">Simpan</button>
            <a href="{{ route('products.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
