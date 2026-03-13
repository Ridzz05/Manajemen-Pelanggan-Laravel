@extends('layouts.admin')

@section('title', 'Kasir (POS)')
@section('page-title', 'Kasir (POS)')
@section('page-subtitle', 'pos.index')

@push('styles')
<style>
    /* POS specific styles — mobile first */
    .pos-wrap {
        display: flex;
        flex-direction: column;
        gap: 0;
        height: calc(100vh - 80px);
        overflow: hidden;
    }

    /* Tab toggle (mobile only) */
    .pos-tabs {
        display: flex;
        border-bottom: 2.5px solid #000;
        background: #fff;
        flex-shrink: 0;
    }
    .pos-tab {
        flex: 1;
        padding: 14px;
        text-align: center;
        font-size: 13px;
        font-weight: 800;
        font-family: 'Space Mono', monospace;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        cursor: pointer;
        border: none;
        background: #f5f0dc;
        color: #666;
        position: relative;
        transition: background 0.15s, color 0.15s;
    }
    .pos-tab.active {
        background: #FFDD00;
        color: #000;
    }
    .pos-tab .cart-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 20px;
        height: 20px;
        padding: 0 5px;
        border-radius: 999px;
        background: #FF3B3B;
        color: #fff;
        font-size: 10px;
        font-weight: 800;
        margin-left: 6px;
        border: 1.5px solid #000;
    }

    /* Panels */
    .pos-panel-products,
    .pos-panel-cart {
        flex: 1;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }
    .pos-panel-cart { display: none; }
    .pos-panel-products.hidden-panel { display: none; }
    .pos-panel-cart.shown-panel { display: flex; }

    /* Product grid — mobile 2 cols */
    .pos-product-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        padding: 14px;
        align-content: start;
    }

    /* Product card */
    .pos-product-card {
        border: 2.5px solid #000;
        background: #fff;
        cursor: pointer;
        padding: 10px;
        box-shadow: 3px 3px 0 #000;
        display: flex;
        flex-direction: column;
        transition: transform 0.1s, box-shadow 0.1s;
    }
    .pos-product-card:active {
        transform: translate(2px, 2px);
        box-shadow: 1px 1px 0 #000;
    }
    .pos-product-card.in-cart { background: #FFDD00; }
    .pos-product-card .prod-img {
        width: 100%;
        height: 56px;
        overflow: hidden;
        margin-bottom: 6px;
        background: #f0ead6;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #000;
    }
    .pos-product-card .prod-img img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .pos-product-card .prod-name {
        font-size: 12px;
        font-weight: 800;
        color: #000;
        line-height: 1.25;
        margin-bottom: 2px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .pos-product-card .prod-sku {
        font-size: 9px;
        font-weight: 700;
        color: #888;
        font-family: 'Space Mono', monospace;
        margin-bottom: 6px;
    }
    .pos-product-card .prod-price {
        font-size: 13px;
        font-weight: 800;
        color: #000;
    }
    .pos-product-card .prod-stock {
        font-size: 9px;
        font-weight: 700;
        color: #000;
        font-family: 'Space Mono', monospace;
        background: #00FF85;
        display: inline-block;
        padding: 2px 6px;
        margin-top: 4px;
        border: 1.5px solid #000;
    }
    .pos-product-card .prod-stock.empty { background: #FF3B3B; color: #fff; }

    /* Search bar */
    .pos-search {
        display: flex;
        gap: 8px;
        padding: 12px 14px;
        border-bottom: 2.5px solid #000;
        background: #fff;
        flex-shrink: 0;
    }
    .pos-search input,
    .pos-search select {
        border: 2.5px solid #000 !important;
        box-shadow: 3px 3px 0 #000 !important;
        font-family: 'Space Mono', monospace;
        font-size: 13px !important;
    }

    /* Cart items */
    .cart-item {
        padding: 14px 16px;
        border-bottom: 2.5px solid #000;
        background: #FFDD00;
    }
    .cart-item-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
    }
    .cart-item-name {
        font-size: 14px;
        font-weight: 800;
        color: #000;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 2px;
    }
    .cart-item-price-info {
        font-size: 12px;
        font-weight: 600;
        color: #222;
        font-family: 'Space Mono', monospace;
    }
    .cart-rm-btn {
        background: #FF3B3B;
        border: 2px solid #000;
        color: #fff;
        cursor: pointer;
        padding: 5px;
        box-shadow: 2px 2px 0 #000;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .cart-rm-btn:active {
        transform: translate(2px, 2px);
        box-shadow: none;
    }
    .cart-qty-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .cart-qty-group {
        display: flex;
        align-items: center;
        border: 2px solid #000;
        background: #fff;
        box-shadow: 2px 2px 0 #000;
    }
    .cart-qty-btn {
        background: none;
        border: none;
        color: #000;
        cursor: pointer;
        width: 36px;
        height: 36px;
        font-size: 18px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cart-qty-btn:first-child { border-right: 2px solid #000; }
    .cart-qty-btn:last-child { border-left: 2px solid #000; }
    .cart-qty-val {
        font-size: 15px;
        font-weight: 800;
        color: #000;
        width: 44px;
        text-align: center;
        font-family: 'Space Mono', monospace;
    }
    .cart-item-total {
        font-size: 15px;
        font-weight: 800;
        color: #000;
        font-family: 'Space Mono', monospace;
        background: #fff;
        padding: 5px 10px;
        border: 2px solid #000;
        box-shadow: 2px 2px 0 #000;
    }

    /* Cart footer */
    .cart-footer {
        border-top: 2.5px solid #000;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        background: #fff;
        flex-shrink: 0;
    }
    .cart-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .cart-row-label {
        font-size: 12px;
        font-weight: 700;
        color: #000;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-family: 'Space Mono', monospace;
    }
    .cart-total-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 16px;
        background: #FFDD00;
        border: 2.5px solid #000;
        box-shadow: 4px 4px 0 #000;
    }
    .cart-total-label {
        font-size: 16px;
        font-weight: 800;
        color: #000;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .cart-total-val {
        font-size: 22px;
        font-weight: 800;
        color: #000;
        font-family: 'Space Mono', monospace;
    }
    .cart-fields {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .cart-fields label {
        font-size: 10px;
        font-weight: 700;
        color: #000;
        letter-spacing: 0.06em;
        display: block;
        margin-bottom: 5px;
        text-transform: uppercase;
        font-family: 'Space Mono', monospace;
    }
    .pos-pay-btn {
        width: 100%;
        justify-content: center;
        padding: 16px;
        font-size: 16px;
        background: #0066FF;
        color: #fff;
        border: 2.5px solid #000;
        box-shadow: 4px 4px 0 #000;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Space Grotesk', sans-serif;
        transition: box-shadow 0.08s, transform 0.08s;
    }
    .pos-pay-btn:hover {
        box-shadow: 2px 2px 0 #000;
        transform: translate(2px, 2px);
    }
    .pos-pay-btn:active {
        box-shadow: 0 0 0 #000;
        transform: translate(4px, 4px);
    }
    .pos-pay-btn:disabled {
        opacity: 0.45;
        cursor: not-allowed;
        box-shadow: none;
        transform: translate(4px, 4px);
    }

    /* Empty cart */
    .cart-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 56px 20px;
        opacity: 0.4;
    }
    .cart-empty i { font-size: 48px; margin-bottom: 12px; }
    .cart-empty p {
        font-size: 13px;
        font-weight: 700;
        font-family: 'Space Mono', monospace;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    /* ─── Desktop (≥768px) ────────────────────────── */
    @media (min-width: 768px) {
        .pos-wrap {
            flex-direction: row;
            gap: 0;
        }
        .pos-tabs { display: none; }
        .pos-panel-products,
        .pos-panel-cart {
            display: flex !important;
        }
        .pos-panel-products {
            flex: 1;
            border-right: 2.5px solid #000;
        }
        .pos-panel-cart {
            width: 380px;
            flex-shrink: 0;
            max-height: none;
        }
        .pos-product-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            padding: 18px;
        }
        .pos-product-card .prod-img { height: 90px; }
        .pos-product-card .prod-name { font-size: 13px; }
        .pos-search { padding: 14px 18px; gap: 10px; }
    }

    @media (min-width: 1024px) {
        .pos-panel-cart { width: 420px; }
        .pos-product-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            padding: 20px;
        }
        .pos-product-card .prod-img { height: 100px; }
    }
</style>
@endpush

@section('content')
<div x-data="posApp()" class="pos-wrap">

    {{-- Mobile Tab Toggle --}}
    <div class="pos-tabs">
        <button class="pos-tab" :class="activeTab === 'products' ? 'active' : ''" @click="activeTab='products'">
            <i class="ti ti-package"></i> Produk
        </button>
        <button class="pos-tab" :class="activeTab === 'cart' ? 'active' : ''" @click="activeTab='cart'">
            <i class="ti ti-shopping-cart"></i> Keranjang
            <span class="cart-badge" x-show="cart.length > 0" x-text="cart.length" x-cloak></span>
        </button>
    </div>

    {{-- LEFT: Product Panel --}}
    <div class="pos-panel-products" :class="activeTab !== 'products' ? 'hidden-panel' : ''">

        {{-- Search + Filter --}}
        <div class="pos-search">
            <div style="position:relative;flex:1;">
                <i class="ti ti-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);font-size:15px;pointer-events:none;color:#888;"></i>
                <input type="text" x-model="search" placeholder="Cari produk..."
                       style="padding-left:36px !important;width:100%;">
            </div>
            <select x-model="filterCategory" style="width:auto;min-width:120px;">
                <option value="">Semua</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Product Grid --}}
        <div class="pos-product-grid" style="overflow-y:auto;flex:1;">
            @foreach($products as $product)
            <div x-show="matchesFilter({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->category_id }})"
                 @click="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock }})"
                 class="pos-product-card"
                 :class="getProductInCart({{ $product->id }}) ? 'in-cart' : ''">

                @if($product->image)
                <div class="prod-img">
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                </div>
                @else
                <div class="prod-img">
                    <i class="ti ti-package" style="font-size:24px;color:#aaa;"></i>
                </div>
                @endif

                <p class="prod-name">{{ $product->name }}</p>
                <p class="prod-sku">{{ $product->sku }}</p>
                <p class="prod-price">{{ $product->formatted_price }}</p>
                <span class="prod-stock {{ $product->stock <= 0 ? 'empty' : '' }}">
                    {{ $product->stock > 0 ? 'STOK: '.$product->stock : 'HABIS' }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- RIGHT: Cart Panel --}}
    <div class="pos-panel-cart" :class="activeTab === 'cart' ? 'shown-panel' : ''">

        {{-- Cart Header (desktop only) --}}
        <div class="nb-card-header" style="background:#000;color:#00FF85;flex-shrink:0;display:none;"
             id="cart-header-desktop">
            <span>Keranjang</span>
            <span x-show="cart.length > 0" style="font-size:12px;color:#00FF85;background:#222;padding:2px 8px;border:1px solid #00FF85;"
                  x-text="cart.length + ' item'"></span>
        </div>

        {{-- Cart Items --}}
        <div style="flex:1;overflow-y:auto;background:#fff;">
            <template x-if="cart.length === 0">
                <div class="cart-empty">
                    <i class="ti ti-shopping-cart-off"></i>
                    <p>Keranjang Kosong</p>
                </div>
            </template>

            <template x-for="(item, index) in cart" :key="item.product_id">
                <div class="cart-item">
                    <div class="cart-item-row">
                        <div style="min-width:0;flex:1;margin-right:10px;">
                            <p class="cart-item-name" x-text="item.name"></p>
                            <p class="cart-item-price-info" x-text="formatRupiah(item.price) + ' × ' + item.quantity"></p>
                        </div>
                        <button @click="removeFromCart(index)" class="cart-rm-btn">
                            <i class="ti ti-x" style="font-size:14px;"></i>
                        </button>
                    </div>
                    <div class="cart-qty-wrap">
                        <div class="cart-qty-group">
                            <button @click="updateQty(index, -1)" class="cart-qty-btn">−</button>
                            <span class="cart-qty-val" x-text="item.quantity"></span>
                            <button @click="updateQty(index, 1)" class="cart-qty-btn">+</button>
                        </div>
                        <span class="cart-item-total" x-text="formatRupiah(item.price * item.quantity)"></span>
                    </div>
                </div>
            </template>
        </div>

        {{-- Cart Footer --}}
        <div class="cart-footer">
            {{-- Subtotal --}}
            <div class="cart-row">
                <span class="cart-row-label">Subtotal</span>
                <span style="font-size:14px;font-weight:800;font-family:'Space Mono',monospace;" x-text="formatRupiah(subtotal)"></span>
            </div>

            {{-- Discount --}}
            <div class="cart-row">
                <label class="cart-row-label" style="margin:0;">Diskon (Rp)</label>
                <input type="number" x-model.number="discount" min="0"
                       style="width:110px !important;padding:8px 10px !important;font-size:13px !important;font-weight:700;text-align:right;font-family:'Space Mono',monospace;">
            </div>

            {{-- Grand Total --}}
            <div class="cart-total-box">
                <span class="cart-total-label">TOTAL</span>
                <span class="cart-total-val" x-text="formatRupiah(grandTotal)"></span>
            </div>

            {{-- Customer & Payment --}}
            <div class="cart-fields">
                <div>
                    <label>Pelanggan</label>
                    <select x-model="customerId">
                        <option value="">— Umum —</option>
                        @foreach($customers as $cust)
                        <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Metode</label>
                    <select x-model="paymentMethod">
                        <option value="Cash">Cash</option>
                        <option value="QRIS">QRIS</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="Virtual Account">VA</option>
                        <option value="E-Wallet">E-Wallet</option>
                    </select>
                </div>
            </div>

            {{-- Pay Button --}}
            <button @click="submitTransaction()"
                    :disabled="cart.length === 0"
                    class="pos-pay-btn">
                <i class="ti ti-circle-check" style="font-size:22px;"></i>
                PROSES BAYAR
            </button>
        </div>
    </div>

    {{-- Hidden Form --}}
    <form id="pos-form" method="POST" action="{{ route('pos.store') }}" style="display:none;">
        @csrf
        <input type="hidden" name="customer_id" :value="customerId">
        <input type="hidden" name="payment_method" :value="paymentMethod">
        <input type="hidden" name="discount" :value="discount">
        <template x-for="(item, i) in cart" :key="item.product_id">
            <div>
                <input type="hidden" :name="'items['+i+'][product_id]'" :value="item.product_id">
                <input type="hidden" :name="'items['+i+'][quantity]'" :value="item.quantity">
            </div>
        </template>
    </form>
</div>

@push('scripts')
<script>
function posApp() {
    return {
        cart: [],
        discount: 0,
        customerId: '',
        paymentMethod: 'Cash',
        search: '',
        filterCategory: '',
        activeTab: 'products',

        get subtotal() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },
        get grandTotal() {
            return Math.max(0, this.subtotal - this.discount);
        },

        matchesFilter(id, name, categoryId) {
            const searchMatch = name.toLowerCase().includes(this.search.toLowerCase());
            const catMatch = !this.filterCategory || categoryId == this.filterCategory;
            return searchMatch && catMatch;
        },

        getProductInCart(productId) {
            return this.cart.find(item => item.product_id === productId);
        },

        addToCart(productId, name, price, stock) {
            const existing = this.cart.find(item => item.product_id === productId);
            if (existing) {
                if (existing.quantity < stock) {
                    existing.quantity++;
                }
            } else {
                if (stock > 0) {
                    this.cart.push({ product_id: productId, name, price, quantity: 1, maxStock: stock });
                    // On mobile, show badge animation
                } else {
                    alert('Stok produk habis!');
                }
            }
        },

        removeFromCart(index) {
            this.cart.splice(index, 1);
        },

        updateQty(index, delta) {
            const item = this.cart[index];
            const newQty = item.quantity + delta;
            if (newQty <= 0) {
                this.removeFromCart(index);
            } else if (newQty <= item.maxStock) {
                item.quantity = newQty;
            } else {
                alert('Stok tidak mencukupi!');
            }
        },

        formatRupiah(amount) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
        },

        submitTransaction() {
            if (this.cart.length === 0) return;
            if (!confirm('Proses transaksi senilai ' + this.formatRupiah(this.grandTotal) + '?')) return;
            document.getElementById('pos-form').submit();
        }
    };
}

// Show desktop cart header on >=768
(function() {
    const mq = window.matchMedia('(min-width: 768px)');
    function toggle(e) {
        const el = document.getElementById('cart-header-desktop');
        if (el) el.style.display = e.matches ? 'flex' : 'none';
    }
    mq.addEventListener('change', toggle);
    toggle(mq);
})();
</script>
@endpush
@endsection
