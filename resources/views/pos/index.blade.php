@extends('layouts.admin')

@section('title', 'Kasir (POS)')
@section('page-title', 'Kasir (POS)')
@section('page-subtitle', 'pos.index')

@section('content')
<div x-data="posApp()" class="r-grid-pos">

    {{-- LEFT: Product Grid --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Search + Filter --}}
        <div style="display:flex;gap:12px;">
            <input type="text" x-model="search" placeholder="Cari produk..." style="flex:1;padding:12px 16px;font-size:14px;border:3px solid #000;box-shadow:4px 4px 0 #000;font-family:'Space Mono',monospace;">
            <select x-model="filterCategory" style="padding:12px 16px;font-size:14px;border:3px solid #000;box-shadow:4px 4px 0 #000;font-family:'Space Mono',monospace;">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Product Cards --}}
        <div class="r-grid-cards" style="overflow-y:auto;flex:1;gap:16px;">
            @foreach($products as $product)
            <div x-show="matchesFilter({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->category_id }})"
                 @click="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock }})"
                 style="border:3px solid #000;background:#fff;cursor:pointer;padding:16px;box-shadow:4px 4px 0 #000;display:flex;flex-direction:column;transition:transform 0.1s;"
                 :style="getProductInCart({{ $product->id }}) ? 'background:#FFDD00;' : ''"
                 onmouseover="this.style.transform='translate(-2px, -2px)';this.style.boxShadow='6px 6px 0 #000'"
                 onmouseout="this.style.transform='none';this.style.boxShadow='4px 4px 0 #000'">

                @if($product->image)
                <div style="width:100%;height:100px;overflow:hidden;margin-bottom:12px;background:#000;display:flex;align-items:center;justify-content:center;border:2px solid #000;">
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" style="max-width:100%;max-height:100%;object-fit:contain;">
                </div>
                @endif

                <p style="font-size:14px;font-weight:800;color:#000;line-height:1.3;margin-bottom:4px;">{{ $product->name }}</p>
                <p style="font-size:11px;font-weight:700;color:#000;opacity:0.6;font-family:'Space Mono',monospace;margin-bottom:8px;">{{ $product->sku }}</p>
                <div style="margin-top:auto;">
                    <p style="font-size:16px;font-weight:800;color:#000;">{{ $product->formatted_price }}</p>
                    <p style="font-size:11px;font-weight:700;color:#000;margin-top:4px;font-family:'Space Mono',monospace;background:var(--bg-primary);display:inline-block;padding:2px 6px;color:var(--text-on-primary);">
                        STOK: {{ $product->stock }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- RIGHT: Cart --}}
    <div class="nb-card" style="display:flex;flex-direction:column;max-height:calc(100vh - 120px);position:sticky;top:20px;">

        {{-- Cart Header --}}
        <div class="nb-card-header" style="background:#000;color:#00FF85;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:13px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;font-family:'Space Mono',monospace;">Keranjang</span>
            <span x-show="cart.length > 0" style="font-size:13px;color:#00FF85;font-weight:700;font-family:'Space Mono',monospace;background:#222;padding:2px 8px;border:1px solid #00FF85;" x-text="cart.length + ' item'"></span>
        </div>

        {{-- Cart Items --}}
        <div style="flex:1;overflow-y:auto;padding:0;background:#fff;">
            <template x-if="cart.length === 0">
                <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px 20px;opacity:0.5;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:48px;height:48px;margin-bottom:12px;color:#000;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    <p style="font-size:13px;font-weight:700;color:#000;font-family:'Space Mono',monospace;text-transform:uppercase;letter-spacing:0.05em;">Keranjang Kosong</p>
                </div>
            </template>

            <template x-for="(item, index) in cart" :key="item.product_id">
                <div style="padding:16px 20px;border-bottom:3px solid #000;background:#FFDD00;">
                    <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:12px;">
                        <div style="min-width:0;flex:1;">
                            <p style="font-size:14px;font-weight:800;color:#000;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:4px;" x-text="item.name"></p>
                            <p style="font-size:13px;font-weight:600;color:#222;font-family:'Space Mono',monospace;" x-text="formatRupiah(item.price) + ' × ' + item.quantity"></p>
                        </div>
                        <button @click="removeFromCart(index)" style="background:#FF3B3B;border:2px solid #000;color:#fff;cursor:pointer;padding:4px;box-shadow:2px 2px 0 #000;display:flex;align-items:center;justify-content:center;transition:transform 0.1s;" onmousedown="this.style.transform='translate(2px,2px)';this.style.boxShadow='none'" onmouseup="this.style.transform='none';this.style.boxShadow='2px 2px 0 #000'">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;">
                                <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:0;border:2px solid #000;background:#fff;box-shadow:2px 2px 0 #000;">
                            <button @click="updateQty(index, -1)" style="background:none;border:none;border-right:2px solid #000;color:#000;cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:800;transition:background 0.1s;" onmouseover="this.style.background='#eee'" onmouseout="this.style.background='transparent'">−</button>
                            <span style="font-size:14px;font-weight:800;color:#000;width:40px;text-align:center;font-family:'Space Mono',monospace;" x-text="item.quantity"></span>
                            <button @click="updateQty(index, 1)" style="background:none;border:none;border-left:2px solid #000;color:#000;cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:800;transition:background 0.1s;" onmouseover="this.style.background='#eee'" onmouseout="this.style.background='transparent'">+</button>
                        </div>
                        <span style="font-size:16px;font-weight:800;color:#000;font-family:'Space Mono',monospace;background:#fff;padding:4px 8px;border:2px solid #000;box-shadow:2px 2px 0 #000;" x-text="formatRupiah(item.price * item.quantity)"></span>
                    </div>
                </div>
            </template>
        </div>

        {{-- Cart Footer --}}
        <div style="border-top:3px solid #000;padding:20px;display:flex;flex-direction:column;gap:16px;background:#fff;">

            {{-- Subtotal --}}
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <span style="font-size:13px;font-weight:700;color:#000;text-transform:uppercase;letter-spacing:0.05em;font-family:'Space Mono',monospace;">Subtotal</span>
                <span style="font-size:15px;font-weight:800;color:#000;font-family:'Space Mono',monospace;" x-text="formatRupiah(subtotal)"></span>
            </div>

            {{-- Discount --}}
            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
                <label style="font-size:13px;font-weight:700;color:#000;white-space:nowrap;text-transform:uppercase;letter-spacing:0.05em;font-family:'Space Mono',monospace;">Diskon (Rp)</label>
                <input type="number" x-model.number="discount" min="0" style="width:120px;padding:8px 12px;font-size:14px;font-weight:700;text-align:right;border:3px solid #000;box-shadow:3px 3px 0 #000;font-family:'Space Mono',monospace;">
            </div>

            {{-- Grand Total --}}
            <div style="display:flex;justify-content:space-between;align-items:center;padding:16px;background:#FFDD00;border:3px solid #000;box-shadow:4px 4px 0 #000;">
                <span style="font-size:18px;font-weight:800;color:#000;text-transform:uppercase;letter-spacing:0.05em;">TOTAL</span>
                <span style="font-size:24px;font-weight:800;color:#000;font-family:'Space Mono',monospace;" x-text="formatRupiah(grandTotal)"></span>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                {{-- Customer (optional) --}}
                <div>
                    <label style="font-size:11px;font-weight:700;color:#000;letter-spacing:0.05em;display:block;margin-bottom:6px;text-transform:uppercase;font-family:'Space Mono',monospace;">Pelanggan</label>
                    <select x-model="customerId" style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:3px 3px 0 #000;font-family:'Space Mono',monospace;cursor:pointer;">
                        <option value="">— Umum —</option>
                        @foreach($customers as $cust)
                        <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Payment Method --}}
                <div>
                    <label style="font-size:11px;font-weight:700;color:#000;letter-spacing:0.05em;display:block;margin-bottom:6px;text-transform:uppercase;font-family:'Space Mono',monospace;">Metode</label>
                    <select x-model="paymentMethod" style="width:100%;padding:10px 14px;font-size:13px;border:3px solid #000;box-shadow:3px 3px 0 #000;font-family:'Space Mono',monospace;cursor:pointer;">
                        <option value="Cash">Cash</option>
                        <option value="QRIS">QRIS</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="Virtual Account">Virtual Account</option>
                        <option value="E-Wallet">E-Wallet</option>
                    </select>
                </div>
            </div>

            {{-- Pay Button --}}
            <button @click="submitTransaction()"
                    :disabled="cart.length === 0"
                    class="btn-nb btn-primary"
                    style="width:100%;justify-content:center;padding:16px;font-size:18px;margin-top:8px;background:#0066FF;color:#fff;"
                    :style="cart.length === 0 ? 'opacity:0.5;cursor:not-allowed;box-shadow:none;transform:translate(4px,4px)' : ''">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:20px;height:20px;">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/>
                </svg>
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
                if(stock > 0) {
                   this.cart.push({ product_id: productId, name, price, quantity: 1, maxStock: stock });
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
</script>
@endpush
@endsection
