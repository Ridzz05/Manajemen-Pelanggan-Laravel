@extends('layouts.admin')
@section('title', 'Pelanggan')
@section('page-title', 'Pelanggan')
@section('page-subtitle', 'customer.management')

@section('content')
<div style="display:flex;flex-direction:column;gap:16px;">

    {{-- Toolbar --}}
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <form method="GET" action="{{ route('customers.index') }}"
              style="display:flex;align-items:center;gap:8px;flex:1;flex-wrap:wrap;">
            <div style="position:relative;flex:1;min-width:180px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     style="position:absolute;left:10px;top:50%;transform:translateY(-50%);width:14px;height:14px;color:#444;pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
                <input name="search" value="{{ request('search') }}" type="text"
                       placeholder="Cari nama, email, proyek..."
                       style="width:100%;padding:8px 12px 8px 32px;font-size:12px;">
            </div>
            <button type="submit" class="btn-secondary" style="padding:8px 14px;">Cari</button>
            @if(request('search'))
                <a href="{{ route('customers.index') }}"
                   style="font-size:12px;color:#444;text-decoration:none;padding:8px 10px;border:1px solid #1a1a1a;">✕</a>
            @endif
        </form>
        <a href="{{ route('customers.create') }}" class="btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tambah
        </a>
    </div>

    {{-- Table --}}
    <div style="border:1px solid #1a1a1a;overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid #1a1a1a;background:#000;">
                    <th style="padding:10px 16px;text-align:left;">#</th>
                    <th style="padding:10px 16px;text-align:left;">Nama</th>
                    <th style="padding:10px 16px;text-align:left;">Email</th>
                    <th style="padding:10px 16px;text-align:left;">No. WhatsApp</th>
                    <th style="padding:10px 16px;text-align:left;">Nama Proyek</th>
                    <th style="padding:10px 16px;text-align:left;">Sub.</th>
                    <th style="padding:10px 16px;text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $c)
                    <tr style="border-bottom:1px solid #0f0f0f;background:#000;transition:background 0.1s;"
                        onmouseover="this.style.background='#0d0d0d'" onmouseout="this.style.background='#000'">
                        <td style="padding:12px 16px;font-size:11px;color:#333;font-family:'JetBrains Mono',monospace;">
                            {{ str_pad($customers->firstItem() + $loop->index, 2, '0', STR_PAD_LEFT) }}
                        </td>
                        <td style="padding:12px 16px;">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:30px;height:30px;border:1px solid #1a1a1a;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <span style="font-size:10px;font-weight:700;color:#444;letter-spacing:0.05em;">
                                        {{ strtoupper(substr($c->name, 0, 2)) }}
                                    </span>
                                </div>
                                <div>
                                    <p style="font-size:13px;font-weight:500;color:#ddd;">{{ $c->name }}</p>
                                    @if($c->company_name)
                                        <p style="font-size:11px;color:#333;margin-top:1px;font-family:'JetBrains Mono',monospace;">{{ $c->company_name }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="padding:12px 16px;font-size:12px;color:#555;font-family:'JetBrains Mono',monospace;">{{ $c->email }}</td>
                        <td style="padding:12px 16px;font-size:12px;color:#555;font-family:'JetBrains Mono',monospace;">{{ $c->phone ?? '—' }}</td>
                        <td style="padding:12px 16px;">
                            <span style="font-size:11px;color:#666;border:1px solid #1a1a1a;padding:2px 8px;font-family:'JetBrains Mono',monospace;">{{ $c->project_name }}</span>
                        </td>
                        <td style="padding:12px 16px;font-size:12px;color:#444;font-family:'JetBrains Mono',monospace;text-align:center;">
                            {{ $c->subscriptions_count }}
                        </td>
                        <td style="padding:12px 16px;text-align:right;">
                            <div style="display:inline-flex;align-items:center;gap:4px;">
                                {{-- Detail --}}
                                <a href="{{ route('customers.show', $c) }}" title="Detail"
                                   style="display:inline-flex;padding:5px;color:#333;text-decoration:none;transition:color 0.15s;"
                                   onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#333'">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                </a>
                                {{-- Edit --}}
                                <a href="{{ route('customers.edit', $c) }}" title="Edit"
                                   style="display:inline-flex;padding:5px;color:#333;text-decoration:none;transition:color 0.15s;"
                                   onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#333'">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                    </svg>
                                </a>
                                {{-- Hapus --}}
                                <form method="POST" action="{{ route('customers.destroy', $c) }}"
                                      onsubmit="return confirm('Hapus pelanggan ini?')" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" title="Hapus"
                                            style="display:inline-flex;padding:5px;background:none;border:none;cursor:pointer;color:#333;transition:color 0.15s;"
                                            onmouseover="this.style.color='#888'" onmouseout="this.style.color='#333'">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding:48px;text-align:center;">
                            <p style="font-size:12px;color:#333;font-family:'JetBrains Mono',monospace;">— tidak ada data —</p>
                            <a href="{{ route('customers.create') }}"
                               style="display:inline-block;margin-top:12px;font-size:12px;color:#555;text-decoration:none;border:1px solid #1a1a1a;padding:6px 14px;">
                                + tambah pelanggan
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($customers->hasPages())
            <div style="padding:12px 16px;border-top:1px solid #111;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;color:#333;font-family:'JetBrains Mono',monospace;">
                    {{ $customers->firstItem() }}–{{ $customers->lastItem() }} dari {{ $customers->total() }}
                </span>
                <div style="display:flex;gap:4px;">
                    @if($customers->onFirstPage())
                        <span style="padding:4px 10px;border:1px solid #111;font-size:11px;color:#222;cursor:default;font-family:'JetBrains Mono',monospace;">‹</span>
                    @else
                        <a href="{{ $customers->previousPageUrl() }}"
                           style="padding:4px 10px;border:1px solid #333;font-size:11px;color:#666;text-decoration:none;font-family:'JetBrains Mono',monospace;">‹</a>
                    @endif
                    @if($customers->hasMorePages())
                        <a href="{{ $customers->nextPageUrl() }}"
                           style="padding:4px 10px;border:1px solid #333;font-size:11px;color:#666;text-decoration:none;font-family:'JetBrains Mono',monospace;">›</a>
                    @else
                        <span style="padding:4px 10px;border:1px solid #111;font-size:11px;color:#222;cursor:default;font-family:'JetBrains Mono',monospace;">›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
