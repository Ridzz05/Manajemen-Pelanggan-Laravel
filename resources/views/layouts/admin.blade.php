<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — AWBuilder</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

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
        * { box-sizing: border-box; margin: 0; padding: 0; }

        /* ── Base ───────────────────────────────────────────── */
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: #FFFBF0;
            color: #000;
            font-size: 14px;
            line-height: 1.5;
        }

        /* ── Scrollbar ──────────────────────────────────────── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f0ead6; }
        ::-webkit-scrollbar-thumb { background: #000; border-radius: 0; }

        /* ── Sidebar Nav ────────────────────────────────────── */
        .nav-section {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.18em;
            color: #999;
            padding: 14px 16px 4px;
            text-transform: uppercase;
            font-family: 'Space Mono', monospace;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #444;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: background 0.1s, color 0.1s, border-color 0.1s;
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
        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; }
        .nav-item i { font-size: 18px; flex-shrink: 0; line-height: 1; }

        /* ── Buttons ────────────────────────────────────────── */
        .btn-nb {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 22px;
            font-size: 14px;
            font-weight: 700;
            border: 2.5px solid #000;
            box-shadow: 4px 4px 0 #000;
            cursor: pointer;
            text-decoration: none;
            transition: box-shadow 0.08s, transform 0.08s;
            letter-spacing: 0.02em;
            line-height: 1;
            white-space: nowrap;
            font-family: 'Space Grotesk', sans-serif;
        }
        .btn-nb:hover {
            box-shadow: 2px 2px 0 #000;
            transform: translate(2px, 2px);
        }
        .btn-nb:active {
            box-shadow: 0 0 0 #000;
            transform: translate(4px, 4px);
        }
        .btn-nb svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* Button variants */
        .btn-primary   { background: #FFDD00; color: #000; }
        .btn-secondary { background: #fff; color: #000; }
        .btn-danger    { background: #FF3B3B; color: #fff; }
        .btn-blue      { background: #0066FF; color: #fff; }
        .btn-lime      { background: #00FF85; color: #000; }
        .btn-dark      { background: #000; color: #fff; }

        /* Small button variant (for table row actions) */
        .btn-nb.btn-sm {
            padding: 7px 15px;
            font-size: 12px;
            box-shadow: 3px 3px 0 #000;
        }
        .btn-nb.btn-sm:hover { box-shadow: 1px 1px 0 #000; transform: translate(2px, 2px); }
        .btn-nb.btn-sm:active { box-shadow: 0 0 0 #000; transform: translate(3px, 3px); }
        .btn-nb.btn-sm svg { width: 13px; height: 13px; }

        /* ── Inputs ─────────────────────────────────────────── */
        input, select, textarea {
            background: #fff !important;
            border: 2.5px solid #000 !important;
            color: #000 !important;
            font-size: 14px;
            font-family: 'Space Grotesk', sans-serif;
            outline: none;
            border-radius: 0 !important;
            padding: 11px 15px;
            width: 100%;
            display: block;
        }
        input:focus, select:focus, textarea:focus {
            box-shadow: 4px 4px 0 #000 !important;
        }
        input::placeholder, textarea::placeholder { color: #aaa !important; }
        select option { background: #fff; color: #000; }
        label.nb-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-family: 'Space Mono', monospace;
            margin-bottom: 7px;
            color: #000;
        }
        .nb-form-group { display: flex; flex-direction: column; }

        /* ── Table ──────────────────────────────────────────── */
        table { border-collapse: collapse; width: 100%; }
        table th {
            background: #000;
            color: #FFDD00;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 14px 18px;
            text-align: left;
            white-space: nowrap;
            font-family: 'Space Mono', monospace;
        }
        table td {
            padding: 14px 18px;
            font-size: 14px;
            border-bottom: 2px solid #000;
            vertical-align: middle;
        }
        table tr:hover td { background: #fff8d6; }

        /* ── Cards ──────────────────────────────────────────── */
        .nb-card {
            background: #fff;
            border: 2.5px solid #000;
            box-shadow: 5px 5px 0 #000;
        }
        .nb-card-header {
            padding: 15px 22px;
            border-bottom: 2.5px solid #000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-family: 'Space Mono', monospace;
        }

        /* ── Badges ─────────────────────────────────────────── */
        .badge {
            display: inline-block;
            padding: 4px 11px;
            font-size: 10px;
            font-weight: 700;
            border: 2px solid #000;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-family: 'Space Mono', monospace;
            white-space: nowrap;
        }
        .badge-success { background: #00FF85; color: #000; }
        .badge-danger  { background: #FF3B3B; color: #fff; }
        .badge-warning { background: #FFDD00; color: #000; }
        .badge-muted   { background: #e0e0e0; color: #555; }
        .badge-blue    { background: #0066FF; color: #fff; }

        /* ── Divider ────────────────────────────────────────── */
        .nb-divider { height: 2.5px; background: #000; }

        /* ── Toolbar ────────────────────────────────────────── */
        .nb-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }
        .nb-toolbar-left { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex: 1; }

        /* ── Avatar initials ────────────────────────────────── */
        .nb-avatar {
            width: 44px;
            height: 44px;
            border: 2.5px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 800;
            flex-shrink: 0;
            font-family: 'Space Grotesk', sans-serif;
        }

        /* ── Responsive Layout ──────────────────────────────── */
        .r-main-padding  { padding: 24px 20px 56px; }
        .r-header-padding { padding: 14px 20px; }
        .r-table-wrap    { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .r-grid-stats    { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .r-grid-2        { display: grid; grid-template-columns: 1fr; gap: 16px; }
        .r-grid-recent   { display: grid; grid-template-columns: 1fr; gap: 20px; }
        .r-form-grid     { display: grid; grid-template-columns: 1fr; gap: 18px; }
        .r-grid-pos      { display: flex; flex-direction: column; gap: 20px; }
        .r-hide-mobile   { display: none; }

        @media (min-width: 640px) {
            .r-grid-stats  { grid-template-columns: repeat(3, 1fr); }
            .r-grid-2      { grid-template-columns: 1fr 1fr; }
            .r-form-grid   { grid-template-columns: 1fr 1fr; }
        }
        @media (min-width: 768px) {
            .r-hide-mobile   { display: table-cell; }
            .r-main-padding  { padding: 32px 36px 64px; }
            .r-header-padding { padding: 16px 36px; }
            .r-grid-recent   { grid-template-columns: 1fr 1fr; }
        }
        @media (min-width: 1024px) {
            .r-grid-stats  { grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); }
            .r-grid-pos    { display: grid; grid-template-columns: 1fr 400px; gap: 24px; align-items: start; }
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
                <div style="width:38px;height:38px;background:#000;border:2px solid #000;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="ti ti-bolt" style="font-size:20px;color:#FFDD00;"></i>
                </div>
                <div>
                    <p style="color:#000;font-weight:800;font-size:15px;letter-spacing:0.05em;line-height:1;">AWBuilder</p>
                    <p style="color:#555;font-size:10px;letter-spacing:0.12em;margin-top:2px;font-family:'Space Mono',monospace;">ADMIN PANEL</p>
                </div>
            </a>
        </div>

        {{-- Nav --}}
        <nav style="padding:12px 0; flex:1; overflow-y:auto;">
            <p class="nav-section">Menu</p>

            <a href="{{ route('dashboard') }}"
               class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="ti ti-layout-dashboard"></i>
                Dashboard
            </a>

            <a href="{{ route('customers.index') }}"
               class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                <i class="ti ti-users"></i>
                Pelanggan
            </a>

            <a href="{{ route('categories.index') }}"
               class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="ti ti-category"></i>
                Kategori
            </a>

            <a href="{{ route('products.index') }}"
               class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="ti ti-package"></i>
                Produk
            </a>

            <a href="{{ route('pos.index') }}"
               class="nav-item {{ request()->routeIs('pos.*') ? 'active' : '' }}">
                <i class="ti ti-shopping-cart"></i>
                Kasir (POS)
            </a>

            <p class="nav-section">Data</p>

            <a href="{{ route('subscriptions.index') }}"
               class="nav-item {{ request()->routeIs('subscriptions.*') ? 'active' : '' }}">
                <i class="ti ti-calendar-event"></i>
                Subscription
            </a>

            <a href="{{ route('payments.index') }}"
               class="nav-item {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                <i class="ti ti-credit-card"></i>
                Pembayaran
            </a>

            <a href="{{ route('transactions.index') }}"
               class="nav-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                <i class="ti ti-receipt"></i>
                Riwayat Transaksi
            </a>

            <p class="nav-section">Akun</p>

            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="nav-item" style="width:100%;text-align:left;background:none;border:none;border-left:3px solid transparent;cursor:pointer;">
                    <i class="ti ti-logout"></i>
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
                    style="color:#000;padding:8px;background:#FFDD00;border:2.5px solid #000;cursor:pointer;box-shadow:3px 3px 0 #000;">
                <i class="ti ti-menu-2" style="font-size:20px;line-height:1;"></i>
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
                     <i class="ti ti-circle-check" style="font-size:20px;flex-shrink:0;"></i>
                     <span style="flex:1;">{{ session('success') }}</span>
                     <button @click="show=false" style="background:none;border:none;cursor:pointer;padding:2px;">
                         <i class="ti ti-x" style="font-size:16px;"></i>
                     </button>
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
                     <i class="ti ti-alert-triangle" style="font-size:20px;flex-shrink:0;"></i>
                     <span style="flex:1;">{{ session('error') }}</span>
                     <button @click="show=false" style="background:none;border:none;cursor:pointer;padding:2px;color:#fff;">
                         <i class="ti ti-x" style="font-size:16px;"></i>
                     </button>
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
