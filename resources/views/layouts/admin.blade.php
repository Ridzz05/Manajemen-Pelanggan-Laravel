<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — AWBuilder</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Space Grotesk', 'sans-serif'],
                        mono: ['Space Mono', 'monospace'],
                    },
                    colors: {
                        'nb-yellow':  '#FFDD00',
                        'nb-lime':    '#00FF85',
                        'nb-blue':    '#0066FF',
                        'nb-red':     '#FF3B3B',
                        'nb-cream':   '#FFFBF0',
                        'nb-pink':    '#FF90E8',
                        'nb-orange':  '#FF6B35',
                    },
                    boxShadow: {
                        'nb':    '4px 4px 0 #000',
                        'nb-lg': '6px 6px 0 #000',
                        'nb-sm': '2px 2px 0 #000',
                        'nb-pressed': '0px 0px 0 #000',
                    }
                },
            },
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        * { box-sizing: border-box; }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: #FFFBF0;
            color: #000;
        }

        /* ── Scrollbar ─────────────────────────────────────────── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f0ead6; }
        ::-webkit-scrollbar-thumb { background: #000; border-radius: 0; }

        /* ── Sidebar Nav Items ─────────────────────────────────── */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            font-size: 14px;
            font-weight: 600;
            color: #555;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: background 0.1s, color 0.1s, border-color 0.1s;
            letter-spacing: 0.01em;
        }
        .nav-item:hover {
            background: #FFDD00;
            color: #000;
            border-left-color: #000;
        }
        .nav-item.active {
            background: #FFDD00;
            color: #000;
            border-left-color: #000;
            font-weight: 700;
        }
        .nav-item svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Neo Brutalist Button Styles ────────────────────────── */
        .btn-nb {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 700;
            border: 2px solid #000;
            box-shadow: 3px 3px 0 #000;
            cursor: pointer;
            text-decoration: none;
            transition: box-shadow 0.1s, transform 0.1s;
            letter-spacing: 0.02em;
        }
        .btn-nb:hover {
            box-shadow: 1px 1px 0 #000;
            transform: translate(2px, 2px);
        }
        .btn-nb:active {
            box-shadow: 0 0 0 #000;
            transform: translate(3px, 3px);
        }
        .btn-primary { background: #FFDD00; color: #000; }
        .btn-danger  { background: #FF3B3B; color: #fff; }
        .btn-secondary { background: #fff; color: #000; }
        .btn-blue { background: #0066FF; color: #fff; }
        .btn-lime { background: #00FF85; color: #000; }

        /* ── Input Styles ───────────────────────────────────────── */
        input, select, textarea {
            background: #fff !important;
            border: 2px solid #000 !important;
            color: #000 !important;
            font-size: 14px;
            font-family: 'Space Grotesk', sans-serif;
            outline: none;
            border-radius: 0 !important;
        }
        input:focus, select:focus, textarea:focus {
            box-shadow: 3px 3px 0 #000 !important;
            outline: none !important;
        }
        input::placeholder, textarea::placeholder { color: #999 !important; }
        select option { background: #fff; color: #000; }

        /* ── Table ─────────────────────────────────────────────── */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table th {
            background: #000;
            color: #FFDD00;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 10px 14px;
            text-align: left;
            white-space: nowrap;
        }
        table td {
            padding: 10px 14px;
            font-size: 13px;
            border-bottom: 1.5px solid #000;
            vertical-align: middle;
        }
        table tr:nth-child(even) td { background: #fff8e0; }
        table tr:hover td { background: #fff3b0; }

        /* ── Card / Panel ───────────────────────────────────────── */
        .nb-card {
            background: #fff;
            border: 2.5px solid #000;
            box-shadow: 5px 5px 0 #000;
        }
        .nb-card-header {
            padding: 12px 18px;
            border-bottom: 2.5px solid #000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* ── Badge ─────────────────────────────────────────────── */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            font-size: 10px;
            font-weight: 700;
            border: 1.5px solid #000;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-family: 'Space Mono', monospace;
        }
        .badge-success { background: #00FF85; color: #000; }
        .badge-danger  { background: #FF3B3B; color: #fff; }
        .badge-warning { background: #FFDD00; color: #000; }
        .badge-muted   { background: #e0e0e0; color: #555; }

        /* ── Responsive Utilities ──────────────────────────────── */
        .r-main-padding { padding: 20px 16px 40px; }
        .r-header-padding { padding: 12px 16px; }
        .r-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .r-grid-stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .r-grid-2 { display: grid; grid-template-columns: 1fr; gap: 16px; }
        .r-grid-recent { display: grid; grid-template-columns: 1fr; gap: 20px; }
        .r-flex-toolbar { display: flex; flex-direction: column; gap: 10px; }
        .r-flex-header  { display: flex; flex-direction: column; gap: 10px; align-items: flex-start; }
        .r-form-grid { display: grid; grid-template-columns: 1fr; gap: 16px; }
        .r-grid-pos { display: flex; flex-direction: column; gap: 16px; }
        .r-hide-mobile { display: none; }

        @media (min-width: 640px) {
            .r-grid-stats { grid-template-columns: repeat(3, 1fr); }
            .r-grid-2 { grid-template-columns: 1fr 1fr; }
            .r-form-grid { grid-template-columns: 1fr 1fr; }
            .r-flex-toolbar { flex-direction: row; align-items: center; }
            .r-flex-header  { flex-direction: row; align-items: center; justify-content: space-between; }
        }
        @media (min-width: 768px) {
            .r-hide-mobile { display: table-cell; }
            .r-main-padding { padding: 24px 28px 40px; }
            .r-header-padding { padding: 14px 28px; }
            .r-grid-recent { grid-template-columns: 1fr 1fr; }
        }
        @media (min-width: 1024px) {
            .r-grid-stats { grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); }
            .r-grid-pos { display: grid; grid-template-columns: 1fr 380px; gap: 20px; min-height: calc(100vh - 200px); }
        }
    </style>

    @stack('styles')
</head>
<body class="h-full" x-data="{ sidebarOpen: false }">

<div class="min-h-screen flex" style="background:#FFFBF0;">

    {{-- ── Mobile overlay ──────────────────────────────── --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen=false"
         class="fixed inset-0 z-20 lg:hidden"
         style="background:rgba(0,0,0,0.5);"></div>

    {{-- ── SIDEBAR ─────────────────────────────────────── --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-30 flex flex-col transition-transform duration-200 lg:static lg:inset-auto"
           style="width:230px; background:#fff; border-right:3px solid #000; flex-shrink:0;">

        {{-- Logo --}}
        <div style="padding:20px 18px; border-bottom:3px solid #000; background:#FFDD00;">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3" style="text-decoration:none;">
                <div style="width:36px;height:36px;background:#000;border:2px solid #000;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFDD00" style="width:18px;height:18px;">
                        <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.268a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <p style="color:#000;font-weight:800;font-size:15px;letter-spacing:0.05em;line-height:1;">AWBuilder</p>
                    <p style="color:#555;font-size:10px;letter-spacing:0.12em;margin-top:2px;font-family:'Space Mono',monospace;">ADMIN PANEL</p>
                </div>
            </a>
        </div>

        {{-- Nav --}}
        <nav style="padding:12px 0; flex:1; overflow-y:auto;">
            <p style="font-size:10px;font-weight:700;letter-spacing:0.15em;color:#999;padding:8px 14px 4px;text-transform:uppercase;font-family:'Space Mono',monospace;">Menu</p>

            <a href="{{ route('dashboard') }}"
               class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('customers.index') }}"
               class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                </svg>
                Pelanggan
            </a>

            <a href="{{ route('categories.index') }}"
               class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z"/>
                </svg>
                Kategori
            </a>

            <a href="{{ route('products.index') }}"
               class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/>
                </svg>
                Produk
            </a>

            <a href="{{ route('pos.index') }}"
               class="nav-item {{ request()->routeIs('pos.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                </svg>
                Kasir (POS)
            </a>

            <p style="font-size:10px;font-weight:700;letter-spacing:0.15em;color:#999;padding:16px 14px 4px;text-transform:uppercase;font-family:'Space Mono',monospace;">Data</p>

            <a href="{{ route('subscriptions.index') }}"
               class="nav-item {{ request()->routeIs('subscriptions.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                </svg>
                Subscription
            </a>

            <a href="{{ route('payments.index') }}"
               class="nav-item {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/>
                </svg>
                Pembayaran
            </a>

            <a href="{{ route('transactions.index') }}"
               class="nav-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15a2.251 2.251 0 0 1 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"/>
                </svg>
                Riwayat Transaksi
            </a>

            <p style="font-size:10px;font-weight:700;letter-spacing:0.15em;color:#999;padding:16px 14px 4px;text-transform:uppercase;font-family:'Space Mono',monospace;">Akun</p>

            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="nav-item" style="width:100%;text-align:left;background:none;border:none;border-left:3px solid transparent;cursor:pointer;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                    </svg>
                    Logout
                </button>
            </form>
        </nav>

        {{-- Sidebar footer --}}
        <div style="padding:12px 18px;border-top:2px solid #000;background:#f5f0dc;">
            <p style="font-size:10px;color:#888;letter-spacing:0.05em;font-family:'Space Mono',monospace;">AWBuilder © {{ date('Y') }}</p>
        </div>
    </aside>

    {{-- ── MAIN CONTENT ────────────────────────────────── --}}
    <div class="flex-1 flex flex-col min-w-0" style="overflow:hidden;">

        {{-- Top Bar --}}
        <header class="r-header-padding" style="border-bottom:3px solid #000;background:#fff;display:flex;align-items:center;gap:12px;position:sticky;top:0;z-index:10;">
            {{-- Hamburger --}}
            <button @click="sidebarOpen=!sidebarOpen"
                    class="lg:hidden"
                    style="color:#000;padding:6px;background:#FFDD00;border:2px solid #000;cursor:pointer;box-shadow:2px 2px 0 #000;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:18px;height:18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>

            <div>
                <h1 style="font-size:16px;font-weight:800;color:#000;line-height:1.2;letter-spacing:-0.01em;">@yield('page-title', 'Dashboard')</h1>
                <p style="font-size:11px;color:#888;margin-top:1px;font-family:'Space Mono',monospace;">@yield('page-subtitle', 'awbuilder.admin')</p>
            </div>

            {{-- Right side --}}
            <div style="margin-left:auto;display:flex;align-items:center;gap:10px;">
                <span style="font-size:11px;font-family:'Space Mono',monospace;background:#000;color:#FFDD00;padding:4px 10px;font-weight:700;letter-spacing:0.05em;">
                    {{ now()->format('d/m/Y') }}
                </span>
                <span style="font-size:11px;background:#0066FF;color:#fff;padding:4px 10px;font-weight:700;border:2px solid #000;letter-spacing:0.05em;font-family:'Space Mono',monospace;">
                    ADMIN
                </span>
            </div>
        </header>

        {{-- Flash Alerts (floating toast) --}}
        <div style="position:fixed;bottom:24px;right:24px;z-index:50;display:flex;flex-direction:column;gap:10px;width:320px;max-width:calc(100vw - 48px);">
            @if(session('success'))
                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 50); setTimeout(() => show = false, 3500)"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-4"
                     style="display:flex;align-items:center;gap:12px;padding:14px 16px;border:2.5px solid #000;background:#00FF85;box-shadow:4px 4px 0 #000;font-size:13px;font-weight:700;color:#000;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;flex-shrink:0;">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/>
                    </svg>
                    <span style="flex:1;">{{ session('success') }}</span>
                    <button @click="show=false" style="background:none;border:none;cursor:pointer;padding:2px;">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 50); setTimeout(() => show = false, 5000)"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-4"
                     style="display:flex;align-items:center;gap:12px;padding:14px 16px;border:2.5px solid #000;background:#FF3B3B;box-shadow:4px 4px 0 #000;font-size:13px;font-weight:700;color:#fff;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;flex-shrink:0;">
                        <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/>
                    </svg>
                    <span style="flex:1;">{{ session('error') }}</span>
                    <button @click="show=false" style="background:none;border:none;cursor:pointer;padding:2px;color:#fff;">✕</button>
                </div>
            @endif
        </div>

        {{-- Content --}}
        <main class="r-main-padding" style="flex:1;overflow-y:auto;">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
