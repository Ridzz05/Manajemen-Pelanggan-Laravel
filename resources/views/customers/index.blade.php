@extends('layouts.admin')
@section('title', 'Pelanggan')
@section('page-title', 'Pelanggan')
@section('page-subtitle', 'customer.management')

@section('content')
<div style="display:flex;flex-direction:column;gap:24px;">

    {{-- Toolbar --}}
    <div class="nb-toolbar">
        <div class="nb-toolbar-left">
            <form method="GET" action="{{ route('customers.index') }}" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <div style="position:relative;">
                    <i class="ti ti-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:16px;color:#000;pointer-events:none;"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama, telegram, proyek..."
                           style="padding-left:40px;width:280px;">
                </div>
                <button type="submit" class="btn-nb btn-secondary">Cari</button>
                @if(request('search'))
                    <a href="{{ route('customers.index') }}" class="btn-nb btn-secondary">✕ Reset</a>
                @endif
            </form>
        </div>
        <a href="{{ route('customers.create') }}" class="btn-nb btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Pelanggan
        </a>
    </div>

    {{-- Table Card --}}
    <div class="nb-card">
        <div class="nb-card-header" style="background:#000;color:#FFDD00;">
            <span>Daftar Pelanggan</span>
            <span style="font-size:11px;font-family:'Space Mono',monospace;opacity:.7;">{{ $customers->total() }} total</span>
        </div>
        <div class="r-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Nama</th>
                        <th class="r-hide-mobile">Telegram ID</th>
                        <th class="r-hide-mobile">WhatsApp</th>
                        <th class="r-hide-mobile">Proyek</th>
                        <th style="text-align:center;">Sub.</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                        <tr>
                            <td style="font-size:11px;color:#888;font-family:'Space Mono',monospace;font-weight:700;">
                                {{ str_pad($customers->firstItem() + $loop->index, 2, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:12px;">
                                    <div class="nb-avatar" style="background:#FFDD00;">
                                        <span style="font-size:12px;font-weight:800;color:#000;">
                                            {{ strtoupper(substr($c->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p style="font-size:14px;font-weight:700;color:#000;line-height:1.2;">{{ $c->name }}</p>
                                        @if($c->company_name)
                                            <p style="font-size:11px;color:#888;margin-top:2px;font-family:'Space Mono',monospace;">{{ $c->company_name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="r-hide-mobile" style="font-family:'Space Mono',monospace;font-size:13px;font-weight:600;">
                                {{ $c->telegram_user_id ?? '—' }}
                            </td>
                            <td class="r-hide-mobile" style="font-family:'Space Mono',monospace;font-size:12px;color:#555;">
                                {{ $c->phone ?? '—' }}
                            </td>
                            <td class="r-hide-mobile">
                                @if($c->project_name)
                                    <span class="badge badge-warning">{{ $c->project_name }}</span>
                                @else
                                    <span style="color:#ccc;">—</span>
                                @endif
                            </td>
                            <td style="text-align:center;font-weight:800;font-size:14px;font-family:'Space Mono',monospace;">
                                {{ $c->subscriptions_count }}
                            </td>
                            <td style="text-align:right;">
                                <div style="display:inline-flex;align-items:center;gap:6px;">
                                    <a href="{{ route('customers.show', $c) }}" class="btn-nb btn-secondary btn-sm">Detail</a>
                                    <a href="{{ route('customers.edit', $c) }}" class="btn-nb btn-blue btn-sm">Edit</a>
                                    <form method="POST" action="{{ route('customers.destroy', $c) }}"
                                          onsubmit="return confirm('Hapus pelanggan ini?')" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-nb btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:56px;text-align:center;">
                                <p style="font-size:14px;color:#aaa;font-weight:600;font-family:'Space Mono',monospace;">TIDAK ADA PELANGGAN</p>
                                <a href="{{ route('customers.create') }}" class="btn-nb btn-primary" style="margin-top:16px;display:inline-flex;">
                                    + Tambah Pelanggan
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($customers->hasPages())
            <div style="padding:14px 18px;border-top:2.5px solid #000;background:#FFFBF0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;color:#555;font-family:'Space Mono',monospace;">
                    {{ $customers->firstItem() }}–{{ $customers->lastItem() }} dari {{ $customers->total() }}
                </span>
                <div style="display:flex;gap:6px;">
                    @if($customers->onFirstPage())
                        <span class="btn-nb btn-secondary btn-sm" style="opacity:0.4;cursor:default;">‹ Prev</span>
                    @else
                        <a href="{{ $customers->previousPageUrl() }}" class="btn-nb btn-secondary btn-sm">‹ Prev</a>
                    @endif
                    @if($customers->hasMorePages())
                        <a href="{{ $customers->nextPageUrl() }}" class="btn-nb btn-secondary btn-sm">Next ›</a>
                    @else
                        <span class="btn-nb btn-secondary btn-sm" style="opacity:0.4;cursor:default;">Next ›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
