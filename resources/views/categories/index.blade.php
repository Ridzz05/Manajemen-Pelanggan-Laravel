@extends('layouts.admin')

@section('title', 'Kategori')
@section('page-title', 'Kategori')
@section('page-subtitle', 'categories.index')

@section('content')
<div style="display:flex;flex-direction:column;gap:20px;">

    {{-- Header --}}
    <div class="r-flex-header">
        <p style="font-size:13px;font-weight:600;color:#555;">{{ $categories->total() }} kategori terdaftar</p>
        <a href="{{ route('categories.create') }}" class="btn-nb btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;">
                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/>
            </svg>
            Tambah Kategori
        </a>
    </div>

    {{-- Table --}}
    <div class="nb-card">
        <div class="nb-card-header" style="background:#000;color:#FFDD00;">
            <span>Daftar Kategori</span>
        </div>
        <div class="r-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th style="text-align:center;">Produk</th>
                        <th style="text-align:center;">Subscriptions</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td style="font-weight:700;font-size:13px;">{{ $category->name }}</td>
                        <td style="text-align:center;font-weight:700;font-family:'Space Mono',monospace;">{{ $category->products_count }}</td>
                        <td style="text-align:center;font-weight:700;font-family:'Space Mono',monospace;">{{ $category->subscriptions_count }}</td>
                        <td style="text-align:center;">
                            @if($category->is_active)
                                <span class="badge badge-success">AKTIF</span>
                            @else
                                <span class="badge badge-muted">NONAKTIF</span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            <div style="display:flex;gap:6px;justify-content:flex-end;">
                                <a href="{{ route('categories.edit', $category) }}" class="btn-nb btn-blue" style="padding:5px 10px;font-size:11px;">Edit</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-nb btn-danger" style="padding:5px 10px;font-size:11px;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;">
                            <p style="font-size:14px;color:#aaa;font-weight:600;">Belum ada kategori</p>
                            <a href="{{ route('categories.create') }}" class="btn-nb btn-primary" style="margin-top:14px;display:inline-flex;">+ Tambah Kategori</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
            <div style="padding:12px 16px;border-top:2px solid #000;background:#FFFBF0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;color:#555;font-family:'Space Mono',monospace;">{{ $categories->firstItem() }}–{{ $categories->lastItem() }} dari {{ $categories->total() }}</span>
                <div style="display:flex;gap:6px;">
                    @if($categories->onFirstPage())
                        <span style="padding:5px 12px;border:2px solid #ccc;font-size:12px;color:#ccc;cursor:default;">‹</span>
                    @else
                        <a href="{{ $categories->previousPageUrl() }}" class="btn-nb btn-secondary" style="padding:5px 12px;font-size:12px;">‹</a>
                    @endif
                    @if($categories->hasMorePages())
                        <a href="{{ $categories->nextPageUrl() }}" class="btn-nb btn-secondary" style="padding:5px 12px;font-size:12px;">›</a>
                    @else
                        <span style="padding:5px 12px;border:2px solid #ccc;font-size:12px;color:#ccc;cursor:default;">›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
