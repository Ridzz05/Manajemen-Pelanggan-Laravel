<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — AWBuilder</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                },
            },
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ── Theme Variables ─────────────────────────────────────── */
        :root {
            --bg-page:     #000000;
            --bg-surface:  #000000;
            --bg-raised:   #0a0a0a;
            --bg-input:    #111111;
            --bg-hover:    #0d0d0d;
            --bg-primary:  #ffffff;

            --border:      #1a1a1a;
            --border-dim:  #0f0f0f;
            --border-mid:  #2a2a2a;

            --text-primary:   #ffffff;
            --text-secondary: #aaaaaa;
            --text-muted:     #555555;
            --text-dim:       #333333;
            --text-ghost:     #222222;
            --text-on-primary:#000000;

            --scrollbar-track: #0a0a0a;
            --scrollbar-thumb: #333333;

            --nav-active-bg:     #111111;
            --nav-active-border: #ffffff;
            --nav-hover-bg:      #111111;
        }

        [data-theme="light"] {
            --bg-page:     #f5f5f5;
            --bg-surface:  #ffffff;
            --bg-raised:   #fafafa;
            --bg-input:    #f0f0f0;
            --bg-hover:    #f9f9f9;
            --bg-primary:  #000000;

            --border:      #e0e0e0;
            --border-dim:  #ececec;
            --border-mid:  #d0d0d0;

            --text-primary:   #111111;
            --text-secondary: #444444;
            --text-muted:     #777777;
            --text-dim:       #aaaaaa;
            --text-ghost:     #cccccc;
            --text-on-primary:#ffffff;

            --scrollbar-track: #f0f0f0;
            --scrollbar-thumb: #cccccc;

            --nav-active-bg:     #f0f0f0;
            --nav-active-border: #000000;
            --nav-hover-bg:      #f5f5f5;
        }

        /* ── Global resets using vars ────────────────────────────── */
        [x-cloak] { display: none !important; }

        * { transition-property: background-color, border-color, color; transition-duration: 0.2s; transition-timing-function: ease; }

        html, body { background-color: var(--bg-page) !important; color: var(--text-primary) !important; }

        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: var(--scrollbar-track); }
        ::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 0; }

        /* Sidebar + Header structural overrides */
        aside { background: var(--bg-surface) !important; border-color: var(--border) !important; }
        header { background: var(--bg-surface) !important; border-color: var(--border) !important; }
        main { background: var(--bg-page) !important; }

        /* ── Nav items ───────────────────────────────────────────── */
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 12px;
            font-size: 13px; font-weight: 500;
            color: var(--text-muted); letter-spacing: 0.02em;
            transition: color 0.15s, background 0.15s;
            border-left: 2px solid transparent;
            text-decoration: none;
        }
        .nav-item:hover { color: var(--text-primary); background: var(--nav-hover-bg); }
        .nav-item.active { color: var(--text-primary); border-left-color: var(--nav-active-border); background: var(--nav-active-bg); }
        .nav-item svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* ── Table ───────────────────────────────────────────────── */
        table th { font-size: 11px; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--text-muted); }

        /* ── Inputs ──────────────────────────────────────────────── */
        input, select, textarea {
            background: var(--bg-input) !important;
            border: 1px solid var(--border-mid) !important;
            color: var(--text-primary) !important;
            font-size: 13px; outline: none;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--text-primary) !important;
            box-shadow: none !important;
        }
        input::placeholder, textarea::placeholder { color: var(--text-muted) !important; }
        select option { background: var(--bg-input); color: var(--text-primary); }

        /* ── Buttons ─────────────────────────────────────────────── */
        .btn-primary {
            background: var(--bg-primary); color: var(--text-on-primary);
            font-weight: 600; font-size: 13px;
            padding: 8px 18px; border: none; cursor: pointer;
            transition: opacity 0.15s;
            display: inline-flex; align-items: center; gap: 6px;
            text-decoration: none;
        }
        .btn-primary:hover { opacity: 0.85; }
        .btn-secondary {
            background: transparent; color: var(--text-muted);
            font-weight: 500; font-size: 13px;
            padding: 8px 18px;
            border: 1px solid var(--border-mid); cursor: pointer;
            transition: color 0.15s, border-color 0.15s;
            display: inline-flex; align-items: center; gap: 6px;
            text-decoration: none;
        }
        .btn-secondary:hover { color: var(--text-primary); border-color: var(--text-muted); }

        /* ── View content overrides ──────────────────────────────── */
        /* These catch hardcoded inline-style colors in view files */

        /* Dark surfaces / tables / cards in views */
        [data-theme="light"] [style*="background:#000"] { background: var(--bg-surface) !important; }
        [data-theme="light"] [style*="background: #000"] { background: var(--bg-surface) !important; }
        [data-theme="light"] [style*="background:#0a0a0a"] { background: var(--bg-raised) !important; }
        [data-theme="light"] [style*="background:#0d0d0d"] { background: var(--bg-hover) !important; }
        [data-theme="light"] [style*="background:#080808"] { background: #f7f7f7 !important; }
        [data-theme="light"] [style*="background:#111"] { background: var(--bg-input) !important; }
        [data-theme="light"] [style*="background:#0f0f0f"] { background: var(--bg-hover) !important; }

        /* Inline border colors */
        [data-theme="light"] [style*="border:1px solid #1a1a1a"] { border-color: var(--border) !important; }
        [data-theme="light"] [style*="border-bottom:1px solid #1a1a1a"] { border-bottom-color: var(--border) !important; }
        [data-theme="light"] [style*="border-top:1px solid #111"] { border-top-color: var(--border) !important; }
        [data-theme="light"] [style*="border:1px solid #333"] { border-color: var(--border-mid) !important; }
        [data-theme="light"] [style*="border:1px solid #2a2a2a"] { border-color: var(--border-mid) !important; }
        [data-theme="light"] [style*="border:1px solid #444"] { border-color: #999 !important; }
        [data-theme="light"] [style*="border-bottom:1px solid #0f0f0f"] { border-bottom-color: var(--border-dim) !important; }
        [data-theme="light"] [style*="border-bottom:1px solid #0a0a0a"] { border-bottom-color: var(--border-dim) !important; }
        [data-theme="light"] [style*="background:#1a1a1a"] { background: var(--border) !important; }

        /* Inline text colors */
        [data-theme="light"] [style*="color:#fff"] { color: var(--text-primary) !important; }
        [data-theme="light"] [style*="color:#ddd"] { color: #222 !important; }
        [data-theme="light"] [style*="color:#ccc"] { color: #333 !important; }
        [data-theme="light"] [style*="color:#bbb"] { color: #444 !important; }
        [data-theme="light"] [style*="color:#aaa"] { color: #555 !important; }
        [data-theme="light"] [style*="color:#999"] { color: #666 !important; }
        [data-theme="light"] [style*="color:#888"] { color: #777 !important; }
        [data-theme="light"] [style*="color:#777"] { color: #666 !important; }
        [data-theme="light"] [style*="color:#666"] { color: #888 !important; }
        [data-theme="light"] [style*="color:#555"] { color: #999 !important; }
        [data-theme="light"] [style*="color:#444"] { color: #aaa !important; }
        [data-theme="light"] [style*="color:#333"] { color: #bbb !important; }
        [data-theme="light"] [style*="color:#2a2a2a"] { color: #ccc !important; }
        [data-theme="light"] [style*="color:#222"] { color: #ddd !important; }

        /* Inverted badges — LUNAS badge (white bg/black text) stays correct */
        [data-theme="light"] [style*="background:#fff;color:#000"] { background: #000 !important; color: #fff !important; }
        [data-theme="light"] [style*="background:#fff"] { background: #000 !important; }

        /* Separators */
        [data-theme="light"] [style*="background:#111111"] { background: var(--border) !important; }
        [data-theme="light"] [style*="background:#111;"] { background: var(--border) !important; }
        [data-theme="light"] [style*="background:rgba(0,0,0"] { background: rgba(0,0,0,0.5) !important; }

        /* Toggle button */
        .theme-toggle {
            display: inline-flex; align-items: center; justify-content: center;
            width: 32px; height: 32px;
            background: none; border: 1px solid var(--border-mid);
            cursor: pointer; color: var(--text-muted);
            transition: color 0.15s, border-color 0.15s;
            padding: 0; flex-shrink: 0;
        }
        .theme-toggle:hover { color: var(--text-primary); border-color: var(--text-muted); }

        /* ── Responsive Utilities ────────────────────────────────── */

        /* Responsive grids */
        .r-grid-stats { display:grid;grid-template-columns:repeat(2,1fr);gap:1px; }
        .r-grid-2 { display:grid;grid-template-columns:1fr;gap:16px; }
        .r-grid-cards { display:grid;grid-template-columns:repeat(2,1fr);gap:10px; }
        .r-grid-pos { display:flex;flex-direction:column;gap:16px; }
        .r-grid-info { display:grid;grid-template-columns:1fr 1fr;gap:14px; }
        .r-grid-recent { display:grid;grid-template-columns:1fr;gap:20px; }
        .r-flex-toolbar { display:flex;flex-direction:column;gap:10px; }
        .r-flex-header { display:flex;flex-direction:column;gap:10px;align-items:flex-start; }

        /* Responsive table wrapper */
        .r-table-wrap { overflow-x:auto;-webkit-overflow-scrolling:touch; }

        /* Hide on mobile */
        .r-hide-mobile { display:none; }

        /* Main padding */
        .r-main-padding { padding:16px 14px 40px; }
        .r-header-padding { padding:12px 14px; }
        .r-alert-padding { padding:0 14px; }

        /* POS cart on mobile */
        .r-pos-cart { min-height:auto; }

        /* Forms */
        .r-form-grid { display:grid;grid-template-columns:1fr;gap:14px; }

        @media (min-width:640px) {
            .r-grid-stats { grid-template-columns:repeat(3,1fr); }
            .r-grid-cards { grid-template-columns:repeat(3,1fr); }
            .r-grid-2 { grid-template-columns:1fr 1fr; }
            .r-form-grid { grid-template-columns:1fr 1fr; }
            .r-flex-toolbar { flex-direction:row;align-items:center; }
            .r-flex-header { flex-direction:row;align-items:center;justify-content:space-between; }
        }

        @media (min-width:768px) {
            .r-hide-mobile { display:table-cell; }
            .r-main-padding { padding:20px 24px 40px; }
            .r-header-padding { padding:14px 24px; }
            .r-alert-padding { padding:0 24px; }
            .r-grid-recent { grid-template-columns:1fr 1fr; }
        }

        @media (min-width:1024px) {
            .r-grid-stats { grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); }
            .r-grid-cards { grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); }
            .r-grid-pos { display:grid;grid-template-columns:1fr 380px;gap:20px;min-height:calc(100vh - 180px); }
            .r-grid-info { grid-template-columns:1fr 1fr; }
        }
    </style>

    {{-- Apply theme immediately to prevent flash --}}
    <script>
        (function() {
            var saved = localStorage.getItem('awb-theme') || 'dark';
            document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>

    @stack('styles')
</head>
<body class="h-full" x-data="{
        sidebarOpen: false,
        theme: localStorage.getItem('awb-theme') || 'dark',
        toggleTheme() {
            this.theme = this.theme === 'dark' ? 'light' : 'dark';
            localStorage.setItem('awb-theme', this.theme);
            document.documentElement.setAttribute('data-theme', this.theme);
        }
    }">

<div class="min-h-screen flex" :style="theme === 'light' ? 'background:var(--bg-page)' : 'background:#000'">

    {{-- ── Mobile overlay ──────────────────────────────────────────── --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen=false"
         class="fixed inset-0 z-20 lg:hidden"
         style="background:rgba(0,0,0,0.75);backdrop-filter:blur(2px);"></div>

    {{-- ── SIDEBAR ──────────────────────────────────────────────────── --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           style="width:220px;border-right:1px solid var(--border);"
           class="fixed inset-y-0 left-0 z-30 flex flex-col transition-transform duration-200 lg:static lg:inset-auto">

        {{-- Logo --}}
        <div style="padding:24px 20px 20px; border-bottom:1px solid var(--border);">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                     style="width:20px;height:20px;color:var(--text-primary);flex-shrink:0;">
                    <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.268a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p style="color:var(--text-primary);font-weight:700;font-size:14px;letter-spacing:0.05em;line-height:1;">AWBuilder</p>
                    <p style="color:var(--text-dim);font-size:10px;letter-spacing:0.1em;margin-top:2px;font-family:'JetBrains Mono',monospace;">ADMIN</p>
                </div>
            </a>
        </div>

        {{-- Nav --}}
        <nav style="padding:16px 0;flex:1;">
            <p style="font-size:10px;font-weight:600;letter-spacing:0.15em;color:var(--text-dim);padding:0 20px 8px;text-transform:uppercase;">
                Menu
            </p>

            <a href="{{ route('dashboard') }}"
               class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('customers.index') }}"
               class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                </svg>
                Pelanggan
            </a>

            <a href="{{ route('categories.index') }}"
               class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z"/>
                </svg>
                Kategori
            </a>

            <a href="{{ route('products.index') }}"
               class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/>
                </svg>
                Produk
            </a>

            <a href="{{ route('pos.index') }}"
               class="nav-item {{ request()->routeIs('pos.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                </svg>
                Kasir (POS)
            </a>

            <p style="font-size:10px;font-weight:600;letter-spacing:0.15em;color:var(--text-dim);padding:16px 20px 8px;text-transform:uppercase;">
                Data
            </p>

            <a href="{{ route('subscriptions.index') }}"
               class="nav-item {{ request()->routeIs('subscriptions.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                </svg>
                Subscription
            </a>

            <a href="{{ route('payments.index') }}"
               class="nav-item {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/>
                </svg>
                Pembayaran
            </a>

            <a href="{{ route('transactions.index') }}"
               class="nav-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15a2.25 2.25 0 0 1 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"/>
                </svg>
                Riwayat Transaksi
            </a>
        </nav>

        {{-- Sidebar footer --}}
        <div style="padding:16px 20px;border-top:1px solid var(--border);">
            <p style="font-size:10px;color:var(--text-ghost);letter-spacing:0.05em;font-family:'JetBrains Mono',monospace;">
                AWBuilder © {{ date('Y') }}
            </p>
        </div>
    </aside>

    {{-- ── MAIN ─────────────────────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col min-w-0" style="overflow:hidden;">

        {{-- Top Bar --}}
        <header class="r-header-padding" style="border-bottom:1px solid var(--border);display:flex;align-items:center;gap:12px;position:sticky;top:0;z-index:10;">
            {{-- Hamburger --}}
            <button @click="sidebarOpen=!sidebarOpen"
                    class="lg:hidden"
                    style="color:var(--text-muted);padding:4px;background:none;border:none;cursor:pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>

            <div>
                <h1 style="font-size:14px;font-weight:600;color:var(--text-primary);line-height:1.2;">@yield('page-title', 'Dashboard')</h1>
                <p style="font-size:11px;color:var(--text-dim);margin-top:1px;font-family:'JetBrains Mono',monospace;">@yield('page-subtitle', 'awbuilder.admin')</p>
            </div>

            {{-- Right side --}}
            <div style="margin-left:auto;display:flex;align-items:center;gap:10px;">
                <div style="font-size:11px;color:var(--text-dim);font-family:'JetBrains Mono',monospace;">
                    {{ now()->format('d.m.Y') }}
                </div>
                <div style="width:1px;height:16px;background:var(--border);"></div>

                {{-- ── Theme Toggle ── --}}
                <button @click="toggleTheme()" class="theme-toggle" :title="theme === 'dark' ? 'Switch to Light' : 'Switch to Dark'">
                    {{-- Sun icon (shown in dark mode → click to go light) --}}
                    <svg x-show="theme === 'dark'"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>
                    </svg>
                    {{-- Moon icon (shown in light mode → click to go dark) --}}
                    <svg x-show="theme === 'light'"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" style="width:15px;height:15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z"/>
                    </svg>
                </button>

                <div style="width:1px;height:16px;background:var(--border);"></div>
                <div style="font-size:12px;font-weight:500;color:var(--text-muted);padding:4px 10px;border:1px solid var(--border);">
                    ADMIN
                </div>
            </div>
        </header>

        {{-- Flash Alerts --}}
        <div class="r-alert-padding">
            @if(session('success'))
                <div x-data="{ show:true }" x-show="show" x-cloak
                     style="display:flex;align-items:center;gap:10px;margin-top:16px;padding:10px 14px;border:1px solid var(--border-mid);background:var(--bg-raised);font-size:12px;color:var(--text-secondary);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;color:var(--text-primary);flex-shrink:0;">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                    <button @click="show=false" style="margin-left:auto;background:none;border:none;color:var(--text-muted);cursor:pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:12px;height:12px;">
                            <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div style="display:flex;align-items:center;gap:10px;margin-top:16px;padding:10px 14px;border:1px solid var(--border-mid);background:var(--bg-raised);font-size:12px;color:var(--text-muted);">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;color:var(--text-muted);flex-shrink:0;">
                        <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('error') }}</span>
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
