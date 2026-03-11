@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')
@section('page-subtitle', 'categories.edit')

@section('content')
<div style="max-width:500px;">
    <form action="{{ route('categories.update', $category) }}" method="POST" style="display:flex;flex-direction:column;gap:16px;">
        @csrf @method('PUT')

        <div>
            <label style="font-size:11px;font-weight:600;color:var(--text-muted);letter-spacing:0.05em;display:block;margin-bottom:6px;">NAMA KATEGORI</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required style="width:100%;padding:8px 12px;">
            @error('name') <p style="color:#888;font-size:11px;margin-top:4px;">{{ $message }}</p> @enderror
        </div>

        <div style="display:flex;align-items:center;gap:8px;">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} style="width:16px;height:16px;">
            <label style="font-size:12px;color:var(--text-secondary);">Aktif</label>
        </div>

        <div style="display:flex;gap:10px;margin-top:8px;">
            <button type="submit" class="btn-primary">Perbarui</button>
            <a href="{{ route('categories.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
