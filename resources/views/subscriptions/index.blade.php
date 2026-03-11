@extends('layouts.admin')

@section('title', 'Subscription')
@section('page-title', 'Subscription')
@section('page-subtitle', 'subscription.management')

@section('content')
<div style="display:flex;flex-direction:column;gap:16px;"
     x-data="{ showRenewModal:false, renewId:null, renewName:'' }">

    {{-- ── Stat Bar ──────────────────────────────────────────────── --}}
    <div class="r-grid-stats" style="background:#1a1a1a;border:1px solid #1a1a1a;">
        @foreach([
            ['label'=>'TOTAL',    'val'=>$stats['total'],         'dim'=>false],
            ['label'=>'AKTIF',    'val'=>$stats['active'],        'dim'=>false],
            ['label'=>'7 HARI',   'val'=>$stats['expiring_soon'], 'dim'=>false],
            ['label'=>'EXPIRED',  'val'=>$stats['expired'],       'dim'=>true],
        ] as $s)
            <div style="background:#000;padding:14px 18px;">
                <p style="font-size:10px;color:#333;letter-spacing:0.12em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:6px;">{{ $s['label'] }}</p>
                <p style="font-size:26px;font-weight:700;color:{{ $s['dim'] ? '#444' : '#fff' }};font-variant-numeric:tabular-nums;">{{ $s['val'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- ── Toolbar ──────────────────────────────────────────────── --}}
    <div class="r-flex-toolbar" style="flex-wrap:wrap;">
        <form method="GET" action="{{ route('subscriptions.index') }}"
              style="display:flex;align-items:center;gap:8px;flex:1;flex-wrap:wrap;">

            {{-- Search --}}
            <div style="position:relative;flex:1;min-width:180px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     style="position:absolute;left:10px;top:50%;transform:translateY(-50%);width:14px;height:14px;color:#444;pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
                <input name="search" value="{{ request('search') }}" type="text"
                       placeholder="Cari pelanggan, proyek..."
                       style="width:100%;padding:8px 12px 8px 32px;font-size:12px;">
            </div>

            {{-- Status filter --}}
            <select name="status" onchange="this.form.submit()"
                    style="padding:8px 12px;font-size:12px;cursor:pointer;">
                <option value="">semua status</option>
                <option value="active"    {{ request('status')==='active'    ? 'selected':'' }}>aktif</option>
                <option value="expired"   {{ request('status')==='expired'   ? 'selected':'' }}>kadaluarsa</option>
                <option value="cancelled" {{ request('status')==='cancelled' ? 'selected':'' }}>dibatalkan</option>
            </select>

            <button type="submit" class="btn-secondary" style="padding:8px 14px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
                Cari
            </button>

            @if(request('search') || request('status'))
                <a href="{{ route('subscriptions.index') }}"
                   style="font-size:12px;color:#444;text-decoration:none;padding:8px 10px;border:1px solid #1a1a1a;">
                    ✕ Reset
                </a>
            @endif
        </form>

        <a href="{{ route('subscriptions.create') }}" class="btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:13px;height:13px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tambah
        </a>
    </div>

    {{-- ── Table ──────────────────────────────────────────────────── --}}
    <div class="r-table-wrap" style="border:1px solid #1a1a1a;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid #1a1a1a;background:#000;">
                    <th style="padding:10px 16px;text-align:left;">#</th>
                    <th style="padding:10px 16px;text-align:left;">Pelanggan</th>
                    <th style="padding:10px 16px;text-align:left;display:none;" class="md-show">Kategori</th>
                    <th style="padding:10px 16px;text-align:left;">Mulai</th>
                    <th style="padding:10px 16px;text-align:left;">Berakhir</th>
                    <th style="padding:10px 16px;text-align:left;">Sisa</th>
                    <th style="padding:10px 16px;text-align:left;">Status</th>
                    <th style="padding:10px 16px;text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscriptions as $sub)
                    @php
                        $daysLeft  = $sub->days_remaining;
                        $isExpired = $sub->status === 'expired';
                        $isWarn    = !$isExpired && $daysLeft <= 7;
                        $rowBg     = $isExpired ? '#080808' : '#000';
                    @endphp
                    <tr style="border-bottom:1px solid #0f0f0f;background:{{ $rowBg }};transition:background 0.1s;"
                        onmouseover="this.style.background='#0d0d0d'"
                        onmouseout="this.style.background='{{ $rowBg }}'">

                        {{-- # --}}
                        <td style="padding:12px 16px;font-size:11px;color:#333;font-family:'JetBrains Mono',monospace;">
                            {{ str_pad($subscriptions->firstItem() + $loop->index, 2, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- Pelanggan --}}
                        <td style="padding:12px 16px;">
                            <p style="font-size:13px;font-weight:500;color:#ddd;">{{ $sub->customer->name }}</p>
                            <p style="font-size:11px;color:#444;margin-top:2px;font-family:'JetBrains Mono',monospace;">{{ $sub->customer->project_name }}</p>
                        </td>

                        {{-- Kategori --}}
                        <td style="padding:12px 16px;">
                            <span style="font-size:11px;color:#666;border:1px solid #1a1a1a;padding:2px 8px;font-family:'JetBrains Mono',monospace;">
                                {{ $sub->category->name ?? '-' }}
                            </span>
                        </td>

                        {{-- Start --}}
                        <td style="padding:12px 16px;font-size:12px;color:#555;white-space:nowrap;font-family:'JetBrains Mono',monospace;">
                            {{ $sub->start_date->format('d.m.Y') }}
                        </td>

                        {{-- End --}}
                        <td style="padding:12px 16px;font-size:12px;white-space:nowrap;font-family:'JetBrains Mono',monospace;color:{{ $isExpired ? '#333' : ($isWarn ? '#999' : '#777') }};">
                            {{ $sub->end_date->format('d.m.Y') }}
                        </td>

                        {{-- Sisa --}}
                        <td style="padding:12px 16px;">
                            @if($isExpired)
                                <span style="font-size:11px;color:#2a2a2a;font-family:'JetBrains Mono',monospace;">—</span>
                            @elseif($isWarn)
                                <span style="font-size:11px;color:#aaa;font-family:'JetBrains Mono',monospace;font-weight:600;">
                                    {{ $daysLeft }}d ⚠
                                </span>
                            @else
                                <span style="font-size:11px;color:#555;font-family:'JetBrains Mono',monospace;">{{ $daysLeft }}d</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td style="padding:12px 16px;">
                            @if($sub->status === 'active')
                                <span style="font-size:10px;padding:2px 8px;border:1px solid #444;color:#ccc;letter-spacing:0.08em;font-family:'JetBrains Mono',monospace;">AKTIF</span>
                            @elseif($sub->status === 'expired')
                                <span style="font-size:10px;padding:2px 8px;border:1px solid #1a1a1a;color:#333;letter-spacing:0.08em;font-family:'JetBrains Mono',monospace;">EXPIRED</span>
                            @else
                                <span style="font-size:10px;padding:2px 8px;border:1px solid #1a1a1a;color:#2a2a2a;letter-spacing:0.08em;font-family:'JetBrains Mono',monospace;">BATAL</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:12px 16px;text-align:right;">
                            <div style="display:inline-flex;align-items:center;gap:4px;">

                                {{-- Detail --}}
                                <a href="{{ route('subscriptions.show', $sub) }}"
                                   title="Detail"
                                   style="display:inline-flex;padding:5px;color:#333;transition:color 0.15s;text-decoration:none;"
                                   onmouseover="this.style.color='#fff'"
                                   onmouseout="this.style.color='#333'">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('subscriptions.edit', $sub) }}"
                                   title="Edit"
                                   style="display:inline-flex;padding:5px;color:#333;transition:color 0.15s;text-decoration:none;"
                                   onmouseover="this.style.color='#fff'"
                                   onmouseout="this.style.color='#333'">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                    </svg>
                                </a>

                                {{-- Perpanjang --}}
                                <button @click="showRenewModal=true;renewId={{ $sub->id }};renewName='{{ addslashes($sub->customer->name) }}'"
                                        title="Perpanjang"
                                        style="display:inline-flex;padding:5px;background:none;border:none;cursor:pointer;color:#333;transition:color 0.15s;"
                                        onmouseover="this.style.color='#fff'"
                                        onmouseout="this.style.color='#333'">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                    </svg>
                                </button>

                                {{-- Hapus --}}
                                <form method="POST" action="{{ route('subscriptions.destroy', $sub) }}"
                                      onsubmit="return confirm('Hapus subscription ini?')"
                                      style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            title="Hapus"
                                            style="display:inline-flex;padding:5px;background:none;border:none;cursor:pointer;color:#333;transition:color 0.15s;"
                                            onmouseover="this.style.color='#888'"
                                            onmouseout="this.style.color='#333'">
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
                        <td colspan="8" style="padding:48px;text-align:center;">
                            <p style="font-size:12px;color:#333;font-family:'JetBrains Mono',monospace;">— tidak ada data —</p>
                            <a href="{{ route('subscriptions.create') }}"
                               style="display:inline-block;margin-top:12px;font-size:12px;color:#555;text-decoration:none;border:1px solid #1a1a1a;padding:6px 14px;">
                                + tambah subscription
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($subscriptions->hasPages())
            <div style="padding:12px 16px;border-top:1px solid #111;display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:11px;color:#333;font-family:'JetBrains Mono',monospace;">
                    {{ $subscriptions->firstItem() }}–{{ $subscriptions->lastItem() }} dari {{ $subscriptions->total() }}
                </span>
                <div style="display:flex;gap:4px;">
                    @if($subscriptions->onFirstPage())
                        <span style="padding:4px 10px;border:1px solid #111;font-size:11px;color:#222;cursor:default;font-family:'JetBrains Mono',monospace;">‹</span>
                    @else
                        <a href="{{ $subscriptions->previousPageUrl() }}"
                           style="padding:4px 10px;border:1px solid #333;font-size:11px;color:#666;text-decoration:none;font-family:'JetBrains Mono',monospace;">‹</a>
                    @endif

                    @if($subscriptions->hasMorePages())
                        <a href="{{ $subscriptions->nextPageUrl() }}"
                           style="padding:4px 10px;border:1px solid #333;font-size:11px;color:#666;text-decoration:none;font-family:'JetBrains Mono',monospace;">›</a>
                    @else
                        <span style="padding:4px 10px;border:1px solid #111;font-size:11px;color:#222;cursor:default;font-family:'JetBrains Mono',monospace;">›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    {{-- ── Renew Modal ──────────────────────────────────────────────── --}}
    <div x-show="showRenewModal" x-cloak
         style="position:fixed;inset:0;z-index:50;display:flex;align-items:center;justify-content:center;padding:16px;">

        {{-- Backdrop --}}
        <div @click="showRenewModal=false"
             style="position:absolute;inset:0;background:rgba(0,0,0,0.85);backdrop-filter:blur(2px);"></div>

        {{-- Modal --}}
        <div @click.stop
             style="position:relative;z-index:10;background:#000;border:1px solid #333;padding:28px;width:100%;max-width:380px;">

            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;color:#fff;flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                </svg>
                <div>
                    <p style="font-size:14px;font-weight:600;color:#fff;">Perpanjang Subscription</p>
                    <p style="font-size:11px;color:#444;margin-top:1px;font-family:'JetBrains Mono',monospace;" x-text="renewName"></p>
                </div>
            </div>

            <form method="POST" :action="`/subscriptions/${renewId}/renew`">
                @csrf @method('PATCH')

                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:11px;color:#555;letter-spacing:0.08em;text-transform:uppercase;font-family:'JetBrains Mono',monospace;margin-bottom:8px;">
                        Durasi
                    </label>
                    <select name="duration_months" style="width:100%;padding:10px 12px;font-size:13px;cursor:pointer;">
                        <option value="1">1 Bulan</option>
                        <option value="3">3 Bulan</option>
                        <option value="6">6 Bulan</option>
                        <option value="12" selected>12 Bulan (1 Tahun)</option>
                        <option value="24">24 Bulan (2 Tahun)</option>
                    </select>
                    <p style="font-size:10px;color:#333;margin-top:6px;font-family:'JetBrains Mono',monospace;">
                        dihitung dari end_date saat ini
                    </p>
                </div>

                <div style="display:flex;gap:8px;">
                    <button type="button" @click="showRenewModal=false" class="btn-secondary" style="flex:1;justify-content:center;">
                        Batal
                    </button>
                    <button type="submit" class="btn-primary" style="flex:1;justify-content:center;">
                        Perpanjang
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
