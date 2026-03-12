@extends('layouts.admin')
@section('title', 'Pelanggan')
@section('page-title', 'Pelanggan')
@section('page-subtitle', 'customer.management')

@section('content')
<div style="display:flex;flex-direction:column;gap:20px;">

    {{-- Toolbar --}}
    <div class="r-flex-header">
        <form method="GET" action="{{ route('customers.index') }}"
              style="display:flex;align-items:center;gap:8px;flex:1;flex-wrap:wrap;">
            <div style="position:relative;flex:1;min-width:200px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                     style="position:absolute;left:11px;top:50%;transform:translateY(-50%);width:14px;height:14px;color:#000;pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
                <input name="search" value="{{ request('search') }}" type="text"
                       placeholder="Cari nama, email, proyek..."
                       style="width:100%;padding:9px 12px 9px 34px;font-size:13px;">
            </div>
            <button type="submit" class="btn-nb btn-secondary">Cari</button>
            @if(request('search'))
                <a href="{{ route('customers.index') }}" class="btn-nb btn-secondary">✕ Reset</a>
            @endif
        </form>
        <a href="{{ route('customers.create') }}" class="btn-nb btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:14px;height:14px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
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
                        <th>#</th>
                        <th>Nama</th>
                        <th class="r-hide-mobile">Email</th>
                        <th class="r-hide-mobile">No. WhatsApp</th>
                        <th class="r-hide-mobile">Nama Proyek</th>
                        <th style="text-align:center;">Sub.</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                        <tr>
                            <td style="font-size:11px;color:#888;font-family:'Space Mono',monospace;">
                                {{ str_pad($customers->firstItem() + $loop->index, 2, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div style="width:34px;height:34px;border:2px solid #000;background:#FFDD00;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:2px 2px 0 #000;">
                                        <span style="font-size:11px;font-weight:800;color:#000;">
                                            {{ strtoupper(substr($c->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p style="font-size:13px;font-weight:700;color:#000;">{{ $c->name }}</p>
                                        @if($c->company_name)
                                            <p style="font-size:11px;color:#888;margin-top:1px;font-family:'Space Mono',monospace;">{{ $c->company_name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="r-hide-mobile" style="font-size:12px;color:#555;font-family:'Space Mono',monospace;">{{ $c->email }}</td>
                            <td class="r-hide-mobile" style="font-size:12px;color:#555;font-family:'Space Mono',monospace;">{{ $c->phone ?? '—' }}</td>
                            <td class="r-hide-mobile">
                                @if($c->project_name)
                                    <span class="badge badge-warning">{{ $c->project_name }}</span>
                                @else
                                    <span style="color:#ccc;">—</span>
                                @endif
                            </td>
                            <td style="text-align:center;font-weight:700;font-size:13px;">
                                {{ $c->subscriptions_count }}
                            </td>
                            <td style="text-align:right;">
                                <div style="display:inline-flex;align-items:center;gap:6px;">
                                    <a href="{{ route('customers.show', $c) }}" class="btn-nb btn-secondary" style="padding:5px 10px;font-size:11px;">Detail</a>
                                    <a href="{{ route('customers.edit', $c) }}" class="btn-nb btn-blue" style="padding:5px 10px;font-size:11px;">Edit</a>
                                    <form method="POST" action="{{ route('customers.destroy', $c) }}"
                                          onsubmit="return confirm('Hapus pelanggan ini?')" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-nb btn-danger" style="padding:5px 10px;font-size:11px;">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:48px;text-align:center;">
                                <p style="font-size:14px;color:#aaa;font-weight:600;">Tidak ada data pelanggan</p>
                                <a href="{{ route('customers.create') }}" class="btn-nb btn-primary" style="margin-top:14px;display:inline-flex;">
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
            <div style="padding:12px 16px;border-top:2px solid #000;background:#FFFBF0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;color:#555;font-family:'Space Mono',monospace;">
                    {{ $customers->firstItem() }}–{{ $customers->lastItem() }} dari {{ $customers->total() }}
                </span>
                <div style="display:flex;gap:6px;">
                    @if($customers->onFirstPage())
                        <span style="padding:5px 12px;border:2px solid #ccc;font-size:12px;color:#ccc;font-family:'Space Mono',monospace;cursor:default;">‹</span>
                    @else
                        <a href="{{ $customers->previousPageUrl() }}" class="btn-nb btn-secondary" style="padding:5px 12px;font-size:12px;">‹</a>
                    @endif
                    @if($customers->hasMorePages())
                        <a href="{{ $customers->nextPageUrl() }}" class="btn-nb btn-secondary" style="padding:5px 12px;font-size:12px;">›</a>
                    @else
                        <span style="padding:5px 12px;border:2px solid #ccc;font-size:12px;color:#ccc;font-family:'Space Mono',monospace;cursor:default;">›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>
@endsection
