@extends('layouts.admin')
@section('title', 'Kategori')
@section('page-title', 'Kategori')
@section('page-subtitle', 'categories.index')

@section('content')
<div style="display:flex;flex-direction:column;gap:24px;">

    {{-- Toolbar --}}
    <div class="nb-toolbar">
        <p style="font-size:13px;font-weight:600;color:#555;font-family:'Space Mono',monospace;">
            {{ $categories->total() }} kategori terdaftar
        </p>
        <a href="{{ route('categories.create') }}" class="btn-nb btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Kategori
        </a>
    </div>

    {{-- Table Card --}}
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
                        <th style="text-align:center;">Subscription</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td style="font-weight:700;font-size:14px;">{{ $category->name }}</td>
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
                                <a href="{{ route('categories.edit', $category) }}" class="btn-nb btn-blue btn-sm">Edit</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-nb btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:56px;text-align:center;">
                            <p style="font-size:14px;color:#aaa;font-weight:600;font-family:'Space Mono',monospace;">BELUM ADA KATEGORI</p>
                            <a href="{{ route('categories.create') }}" class="btn-nb btn-primary" style="margin-top:16px;display:inline-flex;">
                                + Tambah Kategori
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div style="padding:14px 18px;border-top:2.5px solid #000;background:#FFFBF0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;color:#555;font-family:'Space Mono',monospace;">
                    {{ $categories->firstItem() }}–{{ $categories->lastItem() }} dari {{ $categories->total() }}
                </span>
                <div style="display:flex;gap:6px;">
                    @if($categories->onFirstPage())
                        <span class="btn-nb btn-secondary btn-sm" style="opacity:0.4;cursor:default;">‹ Prev</span>
                    @else
                        <a href="{{ $categories->previousPageUrl() }}" class="btn-nb btn-secondary btn-sm">‹ Prev</a>
                    @endif
                    @if($categories->hasMorePages())
                        <a href="{{ $categories->nextPageUrl() }}" class="btn-nb btn-secondary btn-sm">Next ›</a>
                    @else
                        <span class="btn-nb btn-secondary btn-sm" style="opacity:0.4;cursor:default;">Next ›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
