@extends('layouts.admin')

@section('title', 'Kasir (POS)')
@section('page-title', 'Kasir (POS)')
@section('page-subtitle', 'pos.index')

@section('content')
<div x-data="posApp()" class="r-grid-pos">

    {{-- LEFT: Product Grid --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Search + Filter --}}
        <div style="display:flex;gap:10px;">
            <input type="text" x-model="search" placeholder="Cari produk..." style="flex:1;padding:8px 14px;">
            <select x-model="filterCategory" style="padding:8px 14px;">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Product Cards --}}
        <div class="r-grid-cards" style="overflow-y:auto;flex:1;">
            @foreach($products as $product)
            <div x-show="matchesFilter({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->category_id }})"
                 @click="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock }})"
                 style="border:1px solid var(--border);background:var(--bg-surface);cursor:pointer;transition:border-color 0.15s;padding:14px;"
                 :style="getProductInCart({{ $product->id }}) ? 'border-color:var(--text-primary)' : ''"
                 onmouseover="this.style.borderColor='var(--border-mid)'" onmouseout="if(!this.getAttribute('data-active'))this.style.borderColor='var(--border)'">

                @if($product->image)
                <div style="width:100%;height:80px;overflow:hidden;margin-bottom:10px;background:var(--bg-raised);display:flex;align-items:center;justify-content:center;">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width:100%;max-height:100%;object-fit:contain;">
                </div>
                @endif

                <p style="font-size:12px;font-weight:600;color:var(--text-primary);line-height:1.3;margin-bottom:4px;">{{ $product->name }}</p>
                <p style="font-size:10px;color:var(--text-dim);font-family:'JetBrains Mono',monospace;margin-bottom:6px;">{{ $product->sku }}</p>
                <p style="font-size:13px;font-weight:700;color:var(--text-primary);">{{ $product->formatted_price }}</p>
                <p style="font-size:10px;color:var(--text-muted);margin-top:4px;font-family:'JetBrains Mono',monospace;">Stok: {{ $product->stock }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- RIGHT: Cart --}}
    <div style="border:1px solid var(--border);background:var(--bg-surface);display:flex;flex-direction:column;">

        {{-- Cart Header --}}
        <div style="padding:16px 18px;border-bottom:1px solid var(--border);">
            <span style="font-size:11px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-muted);">Keranjang</span>
            <span x-show="cart.length > 0" style="font-size:10px;color:var(--text-dim);font-family:'JetBrains Mono',monospace;margin-left:8px;" x-text="cart.length + ' item'"></span>
        </div>

        {{-- Cart Items --}}
        <div style="flex:1;overflow-y:auto;padding:0;">
            <template x-if="cart.length === 0">
                <p style="text-align:center;padding:40px 18px;font-size:12px;color:var(--text-dim);font-family:'JetBrains Mono',monospace;">— keranjang kosong —</p>
            </template>

            <template x-for="(item, index) in cart" :key="item.product_id">
                <div style="padding:12px 18px;border-bottom:1px solid var(--border-dim);">
                    <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:8px;">
                        <div style="min-width:0;flex:1;">
                            <p style="font-size:12px;font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" x-text="item.name"></p>
                            <p style="font-size:11px;color:var(--text-muted);font-family:'JetBrains Mono',monospace;" x-text="formatRupiah(item.price) + ' × ' + item.quantity"></p>
                        </div>
                        <button @click="removeFromCart(index)" style="background:none;border:none;color:var(--text-dim);cursor:pointer;padding:2px;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;">
                                <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:6px;">
                            <button @click="updateQty(index, -1)" style="background:none;border:1px solid var(--border-mid);color:var(--text-muted);cursor:pointer;width:24px;height:24px;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;">−</button>
                            <span style="font-size:13px;font-weight:600;color:var(--text-primary);width:30px;text-align:center;font-family:'JetBrains Mono',monospace;" x-text="item.quantity"></span>
                            <button @click="updateQty(index, 1)" style="background:none;border:1px solid var(--border-mid);color:var(--text-muted);cursor:pointer;width:24px;height:24px;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;">+</button>
                        </div>
                        <span style="font-size:13px;font-weight:600;color:var(--text-primary);font-family:'JetBrains Mono',monospace;" x-text="formatRupiah(item.price * item.quantity)"></span>
                    </div>
                </div>
            </template>
        </div>

        {{-- Cart Footer --}}
        <div style="border-top:1px solid var(--border);padding:16px 18px;display:flex;flex-direction:column;gap:12px;">

            {{-- Subtotal --}}
            <div style="display:flex;justify-content:space-between;">
                <span style="font-size:12px;color:var(--text-muted);">Subtotal</span>
                <span style="font-size:13px;color:var(--text-secondary);font-family:'JetBrains Mono',monospace;" x-text="formatRupiah(subtotal)"></span>
            </div>

            {{-- Discount --}}
            <div style="display:flex;align-items:center;gap:8px;">
                <label style="font-size:12px;color:var(--text-muted);white-space:nowrap;">Diskon (Rp)</label>
                <input type="number" x-model.number="discount" min="0" style="flex:1;padding:6px 10px;font-size:12px;text-align:right;font-family:'JetBrains Mono',monospace;">
            </div>

            {{-- Grand Total --}}
            <div style="display:flex;justify-content:space-between;padding-top:8px;border-top:1px solid var(--border);">
                <span style="font-size:13px;font-weight:700;color:var(--text-primary);">TOTAL</span>
                <span style="font-size:18px;font-weight:700;color:var(--text-primary);font-family:'JetBrains Mono',monospace;" x-text="formatRupiah(grandTotal)"></span>
            </div>

            {{-- Customer (optional) --}}
            <div>
                <label style="font-size:10px;font-weight:600;color:var(--text-dim);letter-spacing:0.05em;display:block;margin-bottom:4px;">PELANGGAN (OPSIONAL)</label>
                <select x-model="customerId" style="width:100%;padding:6px 10px;font-size:12px;">
                    <option value="">— Umum —</option>
                    @foreach($customers as $cust)
                    <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Payment Method --}}
            <div>
                <label style="font-size:10px;font-weight:600;color:var(--text-dim);letter-spacing:0.05em;display:block;margin-bottom:4px;">METODE BAYAR</label>
                <select x-model="paymentMethod" style="width:100%;padding:6px 10px;font-size:12px;">
                    <option value="Cash">Cash</option>
                    <option value="QRIS">QRIS</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="Virtual Account">Virtual Account</option>
                    <option value="E-Wallet">E-Wallet</option>
                </select>
            </div>

            {{-- Pay Button --}}
            <button @click="submitTransaction()"
                    :disabled="cart.length === 0"
                    class="btn-primary"
                    style="width:100%;justify-content:center;padding:12px;font-size:14px;"
                    :style="cart.length === 0 ? 'opacity:0.3;cursor:not-allowed' : ''">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/>
                </svg>
                BAYAR
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
                this.cart.push({ product_id: productId, name, price, quantity: 1, maxStock: stock });
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
</script>
@endpush
@endsection
