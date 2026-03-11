@extends('layouts.admin')

@section('title', $product->name)
@section('page-title', $product->name)
@section('page-subtitle', 'products.show')

@section('content')
<div style="display:flex;flex-direction:column;gap:20px;max-width:600px;">

    <div style="border:1px solid var(--border);background:var(--bg-surface);">
        <div style="padding:18px;border-bottom:1px solid var(--border);">
            <span style="font-size:11px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-muted);">Detail Produk</span>
        </div>
        <div style="padding:18px;display:flex;flex-direction:column;gap:14px;">
            @if($product->image)
            <div style="margin-bottom:4px;">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width:200px;max-height:200px;object-fit:contain;border:1px solid var(--border);">
            </div>
            @endif
            <div style="display:flex;justify-content:space-between;">
                <span style="font-size:12px;color:var(--text-muted);">SKU</span>
                <span style="font-size:13px;color:var(--text-primary);font-family:'JetBrains Mono',monospace;">{{ $product->sku }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;">
                <span style="font-size:12px;color:var(--text-muted);">Kategori</span>
                <span style="font-size:13px;color:var(--text-primary);">{{ $product->category->name ?? '-' }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;">
                <span style="font-size:12px;color:var(--text-muted);">Harga</span>
                <span style="font-size:13px;font-weight:600;color:var(--text-primary);">{{ $product->formatted_price }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;">
                <span style="font-size:12px;color:var(--text-muted);">Stok</span>
                <span style="font-size:13px;color:var(--text-primary);font-family:'JetBrains Mono',monospace;">{{ $product->stock }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;">
                <span style="font-size:12px;color:var(--text-muted);">Status</span>
                <span style="font-size:13px;color:var(--text-primary);">{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</span>
            </div>
            @if($product->description)
            <div>
                <span style="font-size:12px;color:var(--text-muted);display:block;margin-bottom:4px;">Deskripsi</span>
                <p style="font-size:13px;color:var(--text-secondary);">{{ $product->description }}</p>
            </div>
            @endif
        </div>
    </div>

    <div style="display:flex;gap:10px;">
        <a href="{{ route('products.edit', $product) }}" class="btn-primary">Edit</a>
        <a href="{{ route('products.index') }}" class="btn-secondary">Kembali</a>
    </div>
</div>
@endsection
