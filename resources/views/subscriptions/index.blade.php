@extends('layouts.admin')

@section('title', 'Subscription')
@section('page-title', 'Subscription')
@section('page-subtitle', 'subscription.management')

@section('content')
<div style="display:flex;flex-direction:column;gap:20px;"
     x-data="{ showRenewModal:false, renewId:null, renewName:'' }">

    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:14px;">
        @foreach([
            ['label'=>'Total',       'val'=>$stats['total'],         'bg'=>'#000',    'color'=>'#FFDD00'],
            ['label'=>'Aktif',       'val'=>$stats['active'],        'bg'=>'#00FF85', 'color'=>'#000'],
            ['label'=>'7 Hari Lagi', 'val'=>$stats['expiring_soon'], 'bg'=>'#FFDD00', 'color'=>'#000'],
            ['label'=>'Expired',     'val'=>$stats['expired'],       'bg'=>'#fff',    'color'=>'#000'],
        ] as $s)
        <div class="nb-card" style="background:{{ $s['bg'] }};">
            <div style="padding:14px 18px;">
                <p style="font-size:10px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;color:{{ $s['color'] }};opacity:0.7;margin-bottom:6px;">{{ $s['label'] }}</p>
                <p style="font-size:28px;font-weight:800;color:{{ $s['color'] }};font-variant-numeric:tabular-nums;">{{ $s['val'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Toolbar --}}
    <div class="r-flex-header">
        <form method="GET" action="{{ route('subscriptions.index') }}"
              style="display:flex;align-items:center;gap:8px;flex:1;flex-wrap:wrap;">
            <div style="position:relative;flex:1;min-width:180px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                     style="position:absolute;left:11px;top:50%;transform:translateY(-50%);width:14px;height:14px;pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
                <input name="search" value="{{ request('search') }}" type="text" placeholder="Cari pelanggan, proyek..."
                       style="width:100%;padding:9px 12px 9px 34px;">
            </div>
            <select name="status" onchange="this.form.submit()" style="padding:9px 12px;">
                <option value="">Semua Status</option>
                <option value="active"    {{ request('status')==='active'    ? 'selected':'' }}>Aktif</option>
                <option value="expired"   {{ request('status')==='expired'   ? 'selected':'' }}>Expired</option>
                <option value="cancelled" {{ request('status')==='cancelled' ? 'selected':'' }}>Dibatalkan</option>
            </select>
            <button type="submit" class="btn-nb btn-secondary">Cari</button>
            @if(request('search') || request('status'))
                <a href="{{ route('subscriptions.index') }}" class="btn-nb btn-secondary">✕ Reset</a>
            @endif
        </form>
        <a href="{{ route('subscriptions.create') }}" class="btn-nb btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:14px;height:14px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tambah
        </a>
    </div>

    {{-- Table --}}
    <div class="nb-card">
        <div class="nb-card-header" style="background:#000;color:#FFDD00;">
            <span>Daftar Subscription</span>
            <span style="font-size:11px;font-family:'Space Mono',monospace;opacity:.7;">{{ $subscriptions->total() }} total</span>
        </div>
        <div class="r-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pelanggan</th>
                        <th class="r-hide-mobile">Kategori</th>
                        <th>Mulai</th>
                        <th>Berakhir</th>
                        <th>Sisa</th>
                        <th>Status</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $sub)
                        @php
                            $daysLeft  = $sub->days_remaining;
                            $isExpired = $sub->status === 'expired';
                            $isWarn    = !$isExpired && $daysLeft <= 7;
                        @endphp
                        <tr>
                            <td style="font-size:11px;color:#888;font-family:'Space Mono',monospace;">
                                {{ str_pad($subscriptions->firstItem() + $loop->index, 2, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>
                                <p style="font-size:13px;font-weight:700;color:#000;">{{ $sub->customer->name }}</p>
                                <p style="font-size:11px;color:#888;margin-top:2px;font-family:'Space Mono',monospace;">{{ $sub->customer->project_name }}</p>
                            </td>
                            <td class="r-hide-mobile">
                                <span class="badge badge-warning">{{ $sub->category->name ?? '-' }}</span>
                            </td>
                            <td style="font-size:12px;font-family:'Space Mono',monospace;white-space:nowrap;">{{ $sub->start_date->format('d.m.Y') }}</td>
                            <td style="font-size:12px;font-family:'Space Mono',monospace;white-space:nowrap;color:{{ $isExpired ? '#aaa' : ($isWarn ? '#FF6B35' : '#000') }};">
                                {{ $sub->end_date->format('d.m.Y') }}
                            </td>
                            <td>
                                @if($isExpired)
                                    <span style="color:#aaa;font-family:'Space Mono',monospace;font-size:12px;">—</span>
                                @elseif($isWarn)
                                    <span class="badge badge-danger">{{ $daysLeft }}d ⚠</span>
                                @else
                                    <span class="badge badge-success">{{ $daysLeft }}d</span>
                                @endif
                            </td>
                            <td>
                                @if($sub->status === 'active')
                                    <span class="badge badge-success">AKTIF</span>
                                @elseif($sub->status === 'expired')
                                    <span class="badge badge-muted">EXPIRED</span>
                                @else
                                    <span class="badge badge-danger">BATAL</span>
                                @endif
                            </td>
                            <td style="text-align:right;">
                                <div style="display:inline-flex;gap:4px;flex-wrap:wrap;justify-content:flex-end;">
                                    <a href="{{ route('subscriptions.show', $sub) }}" class="btn-nb btn-secondary" style="padding:5px 8px;font-size:11px;">Detail</a>
                                    <a href="{{ route('subscriptions.edit', $sub) }}" class="btn-nb btn-blue" style="padding:5px 8px;font-size:11px;">Edit</a>
                                    <button @click="showRenewModal=true;renewId={{ $sub->id }};renewName='{{ addslashes($sub->customer->name) }}'"
                                            class="btn-nb btn-lime" style="padding:5px 8px;font-size:11px;">↻ Perpanjang</button>
                                    <form method="POST" action="{{ route('subscriptions.destroy', $sub) }}"
                                          onsubmit="return confirm('Hapus subscription ini?')" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-nb btn-danger" style="padding:5px 8px;font-size:11px;">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding:48px;text-align:center;">
                                <p style="font-size:14px;color:#aaa;font-weight:600;">Tidak ada data subscription</p>
                                <a href="{{ route('subscriptions.create') }}" class="btn-nb btn-primary" style="margin-top:14px;display:inline-flex;">+ Tambah</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($subscriptions->hasPages())
            <div style="padding:12px 16px;border-top:2px solid #000;background:#FFFBF0;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;color:#555;font-family:'Space Mono',monospace;">{{ $subscriptions->firstItem() }}–{{ $subscriptions->lastItem() }} dari {{ $subscriptions->total() }}</span>
                <div style="display:flex;gap:6px;">
                    @if($subscriptions->onFirstPage())
                        <span style="padding:5px 12px;border:2px solid #ccc;font-size:12px;color:#ccc;cursor:default;">‹</span>
                    @else
                        <a href="{{ $subscriptions->previousPageUrl() }}" class="btn-nb btn-secondary" style="padding:5px 12px;font-size:12px;">‹</a>
                    @endif
                    @if($subscriptions->hasMorePages())
                        <a href="{{ $subscriptions->nextPageUrl() }}" class="btn-nb btn-secondary" style="padding:5px 12px;font-size:12px;">›</a>
                    @else
                        <span style="padding:5px 12px;border:2px solid #ccc;font-size:12px;color:#ccc;cursor:default;">›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    {{-- Renew Modal --}}
    <div x-show="showRenewModal" x-cloak
         style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;padding:16px;">
        <div @click="showRenewModal=false" style="position:absolute;inset:0;background:rgba(0,0,0,0.7);"></div>
        <div @click.stop style="position:relative;z-index:10;background:#fff;border:3px solid #000;box-shadow:8px 8px 0 #000;padding:28px;width:100%;max-width:380px;">
            <h2 style="font-size:16px;font-weight:800;margin-bottom:6px;">Perpanjang Subscription</h2>
            <p style="font-size:13px;color:#888;font-family:'Space Mono',monospace;margin-bottom:20px;" x-text="renewName"></p>

            <form method="POST" :action="`/subscriptions/${renewId}/renew`">
                @csrf @method('PATCH')
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:#000;letter-spacing:0.1em;text-transform:uppercase;font-family:'Space Mono',monospace;margin-bottom:6px;">Durasi</label>
                    <select name="duration_months" style="width:100%;padding:10px 12px;">
                        <option value="1">1 Bulan</option>
                        <option value="3">3 Bulan</option>
                        <option value="6">6 Bulan</option>
                        <option value="12" selected>12 Bulan (1 Tahun)</option>
                        <option value="24">24 Bulan (2 Tahun)</option>
                    </select>
                    <p style="font-size:10px;color:#aaa;margin-top:6px;font-family:'Space Mono',monospace;">Dihitung dari tanggal akhir saat ini</p>
                </div>
                <div style="display:flex;gap:10px;border-top:2px solid #000;padding-top:18px;">
                    <button type="button" @click="showRenewModal=false" class="btn-nb btn-secondary" style="flex:1;justify-content:center;">Batal</button>
                    <button type="submit" class="btn-nb btn-lime" style="flex:1;justify-content:center;">↻ Perpanjang</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
