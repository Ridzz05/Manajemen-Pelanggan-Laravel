@extends('layouts.admin')
@section('title', 'Paket Layanan')
@section('page-title', 'Paket Layanan')
@section('page-subtitle', 'service_package.management')

@section('content')
<div style="display:flex;flex-direction:column;gap:16px;">

    {{-- Toolbar --}}
    <div style="display:flex;align-items:center;justify-content:flex-end;">
        <a href="{{ route('service-packages.create') }}" class="btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tambah Paket
        </a>
    </div>

    {{-- Cards Grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1px;background:#1a1a1a;">
        @forelse($packages as $pkg)
            <div style="background:#000;padding:20px;display:flex;flex-direction:column;gap:12px;position:relative;">

                {{-- Status dot --}}
                <div style="position:absolute;top:16px;right:16px;">
                    @if($pkg->is_active)
                        <span style="font-size:10px;padding:2px 8px;border:1px solid #333;color:#777;letter-spacing:0.08em;font-family:'JetBrains Mono',monospace;">AKTIF</span>
                    @else
                        <span style="font-size:10px;padding:2px 8px;border:1px solid #1a1a1a;color:#222;letter-spacing:0.08em;font-family:'JetBrains Mono',monospace;">NONAKTIF</span>
                    @endif
                </div>

                {{-- Icon --}}
                <div style="width:36px;height:36px;border:1px solid #1a1a1a;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;color:#444;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/>
                    </svg>
                </div>

                {{-- Name --}}
                <div>
                    <p style="font-size:15px;font-weight:600;color:#ddd;">{{ $pkg->name }}</p>
                    <p style="font-size:18px;font-weight:700;color:#fff;margin-top:4px;font-variant-numeric:tabular-nums;">
                        Rp {{ number_format($pkg->price, 0, ',', '.') }}
                    </p>
                </div>

                {{-- Description --}}
                @if($pkg->description)
                    <p style="font-size:12px;color:#444;line-height:1.6;">{{ $pkg->description }}</p>
                @endif

                {{-- Subscriptions count --}}
                <div style="display:flex;align-items:center;gap:6px;padding-top:8px;border-top:1px solid #111;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:12px;height:12px;color:#333;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                    </svg>
                    <span style="font-size:11px;color:#333;font-family:'JetBrains Mono',monospace;">{{ $pkg->subscriptions_count }} subscription</span>

                    <div style="margin-left:auto;display:flex;gap:6px;">
                        <a href="{{ route('service-packages.edit', $pkg) }}"
                           style="display:inline-flex;padding:4px;color:#333;text-decoration:none;transition:color 0.15s;"
                           onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#333'">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('service-packages.destroy', $pkg) }}"
                              onsubmit="return confirm('Hapus paket ini?')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    style="display:inline-flex;padding:4px;background:none;border:none;cursor:pointer;color:#333;transition:color 0.15s;"
                                    onmouseover="this.style.color='#888'" onmouseout="this.style.color='#333'">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div style="background:#000;padding:56px;text-align:center;grid-column:1/-1;">
                <p style="font-size:12px;color:#333;font-family:'JetBrains Mono',monospace;">— belum ada paket layanan —</p>
                <a href="{{ route('service-packages.create') }}"
                   style="display:inline-block;margin-top:12px;font-size:12px;color:#555;text-decoration:none;border:1px solid #1a1a1a;padding:6px 14px;">
                    + tambah paket
                </a>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($packages->hasPages())
        <div style="display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:11px;color:#333;font-family:'JetBrains Mono',monospace;">{{ $packages->firstItem() }}–{{ $packages->lastItem() }} dari {{ $packages->total() }}</span>
            <div style="display:flex;gap:4px;">
                @if($packages->onFirstPage())
                    <span style="padding:4px 10px;border:1px solid #111;font-size:11px;color:#222;font-family:'JetBrains Mono',monospace;">‹</span>
                @else
                    <a href="{{ $packages->previousPageUrl() }}" style="padding:4px 10px;border:1px solid #333;font-size:11px;color:#666;text-decoration:none;font-family:'JetBrains Mono',monospace;">‹</a>
                @endif
                @if($packages->hasMorePages())
                    <a href="{{ $packages->nextPageUrl() }}" style="padding:4px 10px;border:1px solid #333;font-size:11px;color:#666;text-decoration:none;font-family:'JetBrains Mono',monospace;">›</a>
                @else
                    <span style="padding:4px 10px;border:1px solid #111;font-size:11px;color:#222;font-family:'JetBrains Mono',monospace;">›</span>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
