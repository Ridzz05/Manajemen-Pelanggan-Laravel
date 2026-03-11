@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')
@section('page-subtitle', 'products.edit')

@section('content')
<div style="max-width:600px;">
    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" style="display:flex;flex-direction:column;gap:16px;">
        @csrf @method('PUT')

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div>
                <label style="font-size:11px;font-weight:600;color:var(--text-muted);letter-spacing:0.05em;display:block;margin-bottom:6px;">NAMA PRODUK</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required style="width:100%;padding:8px 12px;">
                @error('name') <p style="color:#888;font-size:11px;margin-top:4px;">{{ $message }}</p> @enderror
            </div>
            <div>
                <label style="font-size:11px;font-weight:600;color:var(--text-muted);letter-spacing:0.05em;display:block;margin-bottom:6px;">SKU</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required style="width:100%;padding:8px 12px;">
                @error('sku') <p style="color:#888;font-size:11px;margin-top:4px;">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label style="font-size:11px;font-weight:600;color:var(--text-muted);letter-spacing:0.05em;display:block;margin-bottom:6px;">KATEGORI</label>
            <select name="category_id" required style="width:100%;padding:8px 12px;">
                <option value="">— Pilih Kategori —</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div>
                <label style="font-size:11px;font-weight:600;color:var(--text-muted);letter-spacing:0.05em;display:block;margin-bottom:6px;">HARGA (Rp)</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="100" required style="width:100%;padding:8px 12px;">
            </div>
            <div>
                <label style="font-size:11px;font-weight:600;color:var(--text-muted);letter-spacing:0.05em;display:block;margin-bottom:6px;">STOK</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required style="width:100%;padding:8px 12px;">
            </div>
        </div>

        <div>
            <label style="font-size:11px;font-weight:600;color:var(--text-muted);letter-spacing:0.05em;display:block;margin-bottom:6px;">GAMBAR PRODUK (opsional)</label>
            @if($product->image)
            <div style="margin-bottom:8px;display:flex;align-items:center;gap:12px;">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width:80px;height:80px;object-fit:cover;border:1px solid var(--border);">
                <div style="display:flex;align-items:center;gap:6px;">
                    <input type="checkbox" name="remove_image" value="1" id="remove_image" style="width:14px;height:14px;">
                    <label for="remove_image" style="font-size:11px;color:var(--text-muted);">Hapus gambar</label>
                </div>
            </div>
            @endif
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp" style="width:100%;padding:8px 12px;font-size:12px;">
            <p style="font-size:10px;color:var(--text-dim);margin-top:4px;font-family:'JetBrains Mono',monospace;">Format: JPG, PNG, WEBP. Maks 2MB.</p>
            @error('image') <p style="color:#888;font-size:11px;margin-top:4px;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label style="font-size:11px;font-weight:600;color:var(--text-muted);letter-spacing:0.05em;display:block;margin-bottom:6px;">DESKRIPSI (opsional)</label>
            <textarea name="description" rows="3" style="width:100%;padding:8px 12px;">{{ old('description', $product->description) }}</textarea>
        </div>

        <div style="display:flex;align-items:center;gap:8px;">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} style="width:16px;height:16px;">
            <label style="font-size:12px;color:var(--text-secondary);">Aktif</label>
        </div>

        <div style="display:flex;gap:10px;margin-top:8px;">
            <button type="submit" class="btn-primary">Perbarui</button>
            <a href="{{ route('products.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
