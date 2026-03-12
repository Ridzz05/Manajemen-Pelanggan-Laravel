@extends('layouts.admin')

@section('title', 'Produk')
@section('page-title', 'Produk')
@section('page-subtitle', 'products.index')

@section('content')
<div style="display:flex;flex-direction:column;gap:20px;">

    {{-- Header --}}
    <div class="r-flex-header">
        <p style="font-size:13px;font-weight:600;color:#555;">{{ $products->total() }} produk terdaftar</p>
        <div class="r-flex-toolbar" style="flex-wrap:wrap;">
            <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk / SKU..." style="padding:8px 12px;width:200px;">
                <select name="category" style="padding:8px 12px;">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-nb btn-secondary" style="padding:8px 14px;">Filter</button>
            </form>
            <a href="{{ route('products.create') }}" class="btn-nb btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/>
                </svg>
                Tambah Produk
            </a>
        </div>
    </div>

    {{-- Table --}}
    <div class="nb-card">
        <div class="nb-card-header" style="background:#000;color:#FFDD00;">
            <span>Daftar Produk</span>
        </div>
        <div class="r-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Nama</th>
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
                        <td style="font-size:11px;font-family:'Space Mono',monospace;color:#888;">{{ $product->sku }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="" style="width:36px;height:36px;object-fit:cover;border:2px solid #000;flex-shrink:0;">
                                @else
                                    <div style="width:36px;height:36px;border:2px solid #000;background:#F0E68C;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <span style="font-size:9px;font-weight:800;color:#000;">IMG</span>
                                    </div>
                                @endif
                                <p style="font-weight:700;font-size:13px;">{{ $product->name }}</p>
                            </div>
                        </td>
                        <td class="r-hide-mobile">
                            <span class="badge badge-warning">{{ $product->category->name ?? '-' }}</span>
                        </td>
                        <td style="text-align:right;font-weight:800;font-family:'Space Mono',monospace;font-size:13px;">{{ $product->formatted_price }}</td>
                        <td style="text-align:center;font-weight:700;font-family:'Space Mono',monospace;">
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
                                <a href="{{ route('products.edit', $product) }}" class="btn-nb btn-blue" style="padding:5px 10px;font-size:11px;">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-nb btn-danger" style="padding:5px 10px;font-size:11px;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding:48px;text-align:center;">
                            <p style="font-size:14px;color:#aaa;font-weight:600;">Belum ada produk</p>
                            <a href="{{ route('products.create') }}" class="btn-nb btn-primary" style="margin-top:14px;display:inline-flex;">+ Tambah Produk</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
            <div style="padding:12px 16px;border-top:2px solid #000;background:#FFFBF0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;color:#555;font-family:'Space Mono',monospace;">{{ $products->firstItem() }}–{{ $products->lastItem() }} dari {{ $products->total() }}</span>
                <div style="display:flex;gap:6px;">
                    @if($products->onFirstPage())
                        <span style="padding:5px 12px;border:2px solid #ccc;font-size:12px;color:#ccc;cursor:default;">‹</span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="btn-nb btn-secondary" style="padding:5px 12px;font-size:12px;">‹</a>
                    @endif
                    @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="btn-nb btn-secondary" style="padding:5px 12px;font-size:12px;">›</a>
                    @else
                        <span style="padding:5px 12px;border:2px solid #ccc;font-size:12px;color:#ccc;cursor:default;">›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
