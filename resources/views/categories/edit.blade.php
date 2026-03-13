@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')
@section('page-subtitle', 'categories.edit')

@section('content')
<div style="max-width:500px;">
    <div class="nb-card">
        <div class="nb-card-header" style="background:#000;color:#00FF85;">
            <span style="font-size:11px;letter-spacing:0.12em;font-family:'Space Mono',monospace;text-transform:uppercase;">form.kategori.edit — id:{{ $category->id }}</span>
        </div>
        <form action="{{ route('categories.update', $category) }}" method="POST" style="padding:24px;display:flex;flex-direction:column;gap:18px;">
            @csrf @method('PUT')

            <div>
                <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:8px;">Nama Kategori *</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required style="width:100%;padding:10px 14px;font-size:13px;">
                @error('name') <p style="font-size:11px;color:#FF3B3B;margin-top:6px;font-weight:600;font-family:'Space Mono',monospace;">{{ $message }}</p> @enderror
            </div>

            <div style="display:flex;align-items:center;gap:10px;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#000;cursor:pointer;">
                <label style="font-size:13px;font-weight:700;color:#000;cursor:pointer;">Aktif</label>
            </div>

            <div style="display:flex;gap:12px;margin-top:10px;padding-top:18px;border-top:2px solid #000;">
                <a href="{{ route('categories.index') }}" class="btn-nb btn-secondary" style="flex:1;justify-content:center;">Batal</a>
                <button type="submit" class="btn-nb btn-primary" style="flex:1;justify-content:center;">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection
