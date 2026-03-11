@extends('layouts.admin')

@section('title', 'Kategori')
@section('page-title', 'Kategori')
@section('page-subtitle', 'categories.index')

@section('content')
<div style="display:flex;flex-direction:column;gap:20px;">

    {{-- Header --}}
    <div class="r-flex-header">
        <p style="font-size:12px;color:var(--text-muted);">{{ $categories->total() }} kategori</p>
        <a href="{{ route('categories.create') }}" class="btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;">
                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/>
            </svg>
            Tambah Kategori
        </a>
    </div>

    {{-- Table --}}
    <div class="r-table-wrap" style="border:1px solid var(--border);background:var(--bg-surface);">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid var(--border);">
                    <th style="text-align:left;padding:12px 18px;">Nama</th>
                    <th style="text-align:center;padding:12px 18px;">Produk</th>
                    <th style="text-align:center;padding:12px 18px;">Subscriptions</th>
                    <th style="text-align:center;padding:12px 18px;">Status</th>
                    <th style="text-align:right;padding:12px 18px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr style="border-bottom:1px solid var(--border-dim);">
                    <td style="padding:12px 18px;font-size:13px;font-weight:500;color:var(--text-primary);">{{ $category->name }}</td>
                    <td style="padding:12px 18px;text-align:center;font-size:13px;color:var(--text-secondary);font-family:'JetBrains Mono',monospace;">{{ $category->products_count }}</td>
                    <td style="padding:12px 18px;text-align:center;font-size:13px;color:var(--text-secondary);font-family:'JetBrains Mono',monospace;">{{ $category->subscriptions_count }}</td>
                    <td style="padding:12px 18px;text-align:center;">
                        @if($category->is_active)
                            <span style="font-size:10px;padding:2px 8px;border:1px solid var(--border-mid);color:var(--text-secondary);font-family:'JetBrains Mono',monospace;letter-spacing:0.05em;">AKTIF</span>
                        @else
                            <span style="font-size:10px;padding:2px 8px;border:1px solid var(--border-dim);color:var(--text-dim);font-family:'JetBrains Mono',monospace;letter-spacing:0.05em;">NONAKTIF</span>
                        @endif
                    </td>
                    <td style="padding:12px 18px;text-align:right;">
                        <div style="display:flex;gap:8px;justify-content:flex-end;">
                            <a href="{{ route('categories.edit', $category) }}" class="btn-secondary" style="padding:4px 12px;">Edit</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-secondary" style="padding:4px 12px;color:#666;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:40px;text-align:center;font-size:12px;color:var(--text-dim);font-family:'JetBrains Mono',monospace;">— belum ada kategori —</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $categories->links() }}
</div>
@endsection
