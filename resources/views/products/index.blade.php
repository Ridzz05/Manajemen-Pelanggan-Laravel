@extends('layouts.admin')

@section('title', 'Produk')
@section('page-title', 'Produk')
@section('page-subtitle', 'products.index')

@section('content')
<div style="display:flex;flex-direction:column;gap:20px;">

    {{-- Header --}}
    <div class="r-flex-header">
        <p style="font-size:12px;color:var(--text-muted);">{{ $products->total() }} produk</p>
        <div class="r-flex-toolbar" style="flex-wrap:wrap;">
            <form method="GET" style="display:flex;gap:8px;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk / SKU..." style="padding:6px 12px;width:200px;">
                <select name="category" style="padding:6px 12px;">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-secondary" style="padding:6px 14px;">Filter</button>
            </form>
            <a href="{{ route('products.create') }}" class="btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/>
                </svg>
                Tambah Produk
            </a>
        </div>
    </div>

    {{-- Table --}}
    <div class="r-table-wrap" style="border:1px solid var(--border);background:var(--bg-surface);">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid var(--border);">
                    <th style="text-align:left;padding:12px 18px;">SKU</th>
                    <th style="text-align:left;padding:12px 18px;">Nama</th>
                    <th style="text-align:left;padding:12px 18px;">Kategori</th>
                    <th style="text-align:right;padding:12px 18px;">Harga</th>
                    <th style="text-align:center;padding:12px 18px;">Stok</th>
                    <th style="text-align:center;padding:12px 18px;">Status</th>
                    <th style="text-align:right;padding:12px 18px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr style="border-bottom:1px solid var(--border-dim);">
                    <td style="padding:12px 18px;font-size:11px;color:var(--text-muted);font-family:'JetBrains Mono',monospace;">{{ $product->sku }}</td>
                    <td style="padding:12px 18px;font-size:13px;font-weight:500;color:var(--text-primary);">{{ $product->name }}</td>
                    <td style="padding:12px 18px;font-size:12px;color:var(--text-secondary);">{{ $product->category->name ?? '-' }}</td>
                    <td style="padding:12px 18px;text-align:right;font-size:13px;font-weight:600;color:var(--text-primary);font-family:'JetBrains Mono',monospace;">{{ $product->formatted_price }}</td>
                    <td style="padding:12px 18px;text-align:center;font-size:13px;color:{{ $product->stock > 0 ? 'var(--text-secondary)' : 'var(--text-dim)' }};font-family:'JetBrains Mono',monospace;">{{ $product->stock }}</td>
                    <td style="padding:12px 18px;text-align:center;">
                        @if($product->is_active)
                            <span style="font-size:10px;padding:2px 8px;border:1px solid var(--border-mid);color:var(--text-secondary);font-family:'JetBrains Mono',monospace;">AKTIF</span>
                        @else
                            <span style="font-size:10px;padding:2px 8px;border:1px solid var(--border-dim);color:var(--text-dim);font-family:'JetBrains Mono',monospace;">NONAKTIF</span>
                        @endif
                    </td>
                    <td style="padding:12px 18px;text-align:right;">
                        <div style="display:flex;gap:8px;justify-content:flex-end;">
                            <a href="{{ route('products.edit', $product) }}" class="btn-secondary" style="padding:4px 12px;">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-secondary" style="padding:4px 12px;color:#666;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:40px;text-align:center;font-size:12px;color:var(--text-dim);font-family:'JetBrains Mono',monospace;">— belum ada produk —</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $products->links() }}
</div>
@endsection
