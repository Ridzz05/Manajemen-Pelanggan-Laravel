@extends('layouts.admin')
@section('title', 'Produk')
@section('page-title', 'Produk')
@section('page-subtitle', 'products.index')

@section('content')
<div style="display:flex;flex-direction:column;gap:24px;">

    {{-- Toolbar --}}
    <div class="nb-toolbar">
        <div class="nb-toolbar-left">
            <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari produk / SKU..."
                       style="width:220px;">
                <select name="category" style="width:170px;">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-nb btn-secondary">Filter</button>
                @if(request('search') || request('category'))
                    <a href="{{ route('products.index') }}" class="btn-nb btn-secondary">✕ Reset</a>
                @endif
            </form>
        </div>
        <a href="{{ route('products.create') }}" class="btn-nb btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Produk
        </a>
    </div>

    {{-- Table Card --}}
    <div class="nb-card">
        <div class="nb-card-header" style="background:#000;color:#FFDD00;">
            <span>Daftar Produk</span>
            <span style="font-size:11px;opacity:.7;font-family:'Space Mono',monospace;">{{ $products->total() }} total</span>
        </div>
        <div class="r-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>SKU / Produk</th>
                        <th class="r-hide-mobile">Kategori</th>
                        <th style="text-align:right;">Harga</th>
                        <th style="text-align:center;">Stok</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:12px;">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt=""
                                         style="width:40px;height:40px;object-fit:cover;border:2.5px solid #000;flex-shrink:0;">
                                @else
                                    <div class="nb-avatar" style="background:#FFDD00;width:40px;height:40px;">
                                        <i class="ti ti-package" style="font-size:18px;"></i>
                                    </div>
                                @endif
                                <div>
                                    <p style="font-weight:700;font-size:14px;line-height:1.2;">{{ $product->name }}</p>
                                    <p style="font-size:11px;color:#888;margin-top:2px;font-family:'Space Mono',monospace;">{{ $product->sku }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="r-hide-mobile">
                            <span class="badge badge-warning">{{ $product->category->name ?? '—' }}</span>
                        </td>
                        <td style="text-align:right;font-weight:800;font-family:'Space Mono',monospace;font-size:14px;">
                            {{ $product->formatted_price }}
                        </td>
                        <td style="text-align:center;">
                            @if($product->stock > 0)
                                <span class="badge badge-success">{{ $product->stock }}</span>
                            @else
                                <span class="badge badge-danger">HABIS</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($product->is_active)
                                <span class="badge badge-success">AKTIF</span>
                            @else
                                <span class="badge badge-muted">NONAKTIF</span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            <div style="display:flex;gap:6px;justify-content:flex-end;">
                                <a href="{{ route('products.edit', $product) }}" class="btn-nb btn-blue btn-sm">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                      onsubmit="return confirm('Hapus produk ini?')" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-nb btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:56px;text-align:center;">
                            <p style="font-size:14px;color:#aaa;font-weight:600;font-family:'Space Mono',monospace;">BELUM ADA PRODUK</p>
                            <a href="{{ route('products.create') }}" class="btn-nb btn-primary" style="margin-top:16px;display:inline-flex;">
                                + Tambah Produk
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
            <div style="padding:14px 18px;border-top:2.5px solid #000;background:#FFFBF0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;color:#555;font-family:'Space Mono',monospace;">
                    {{ $products->firstItem() }}–{{ $products->lastItem() }} dari {{ $products->total() }}
                </span>
                <div style="display:flex;gap:6px;">
                    @if($products->onFirstPage())
                        <span class="btn-nb btn-secondary btn-sm" style="opacity:0.4;cursor:default;">‹ Prev</span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="btn-nb btn-secondary btn-sm">‹ Prev</a>
                    @endif
                    @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="btn-nb btn-secondary btn-sm">Next ›</a>
                    @else
                        <span class="btn-nb btn-secondary btn-sm" style="opacity:0.4;cursor:default;">Next ›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
