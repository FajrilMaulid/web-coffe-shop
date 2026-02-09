@extends('layouts.master')

@section('title', 'Transaksi Baru')
@section('page-title', 'Point of Sale')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pos.css') }}">
@endpush

@section('content')
<div class="pos-container">
    <!-- Products Grid -->
    <div>
        <div class="card" style="margin-bottom: 16px;">
            <input type="text" id="searchProduct" class="form-control" placeholder="🔍 Cari produk..." onkeyup="filterProducts()">
        </div>

        <div class="products-grid" id="productsGrid">
            @foreach($products as $product)
                <div class="product-card-pos {{ $product->stock == 0 ? 'out-of-stock' : '' }}"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->price }}"
                    data-stock="{{ $product->stock }}"
                    data-image="{{ $product->image }}"
                    onclick="addToCart(this)">

                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
                    @else
                        <div class="product-img">☕</div>
                    @endif

                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    <div class="product-stock">Stok: {{ $product->stock }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Cart Panel -->
    <div class="cart-panel">
        <h3 class="cart-header">Keranjang</h3>

        <div class="cart-items" id="cartItems">
            <p style="text-align: center; color: #999; padding: 40px 0;">Keranjang kosong</p>
        </div>

        <div class="form-group">
            <label for="payment_method" class="form-label">Metode Pembayaran</label>
            <select id="payment_method" class="form-control">
                <option value="cash">Tunai</option>
                <option value="debit">Debit</option>
                <option value="credit">Kredit</option>
                <option value="qris">QRIS</option>
            </select>
        </div>

        <div class="form-group">
            <label for="customer_name" class="form-label">Nama Pelanggan (Opsional)</label>
            <input type="text" id="customer_name" class="form-control" placeholder="Nama pelanggan">
        </div>

        <div class="cart-total">
            <div class="total-label">Total:</div>
            <div class="total-amount" id="totalAmount">Rp 0</div>
        </div>

        <div class="cart-actions">
            <button type="button" class="btn btn-primary btn-lg" onclick="processTransaction()" id="btnProcess" disabled>
                Proses Transaksi
            </button>
            <button type="button" class="btn btn-danger" onclick="clearCart()">
                Batal
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let cart = [];

function addToCart(element) {
    const id = element.dataset.id;
    const name = element.dataset.name;
    const price = parseFloat(element.dataset.price);
    const stock = parseInt(element.dataset.stock);
    const image = element.dataset.image;

    if (stock === 0) {
        alert('Produk habis!');
        return;
    }

    const existingItem = cart.find(item => item.id === id);

    if (existingItem) {
        if (existingItem.quantity >= stock) {
            alert('Stok tidak mencukupi!');
            return;
        }
        existingItem.quantity++;
    } else {
        cart.push({ id, name, price, stock, image, quantity: 1 });
    }

    renderCart();
}

function updateQuantity(id, change) {
    const item = cart.find(i => i.id === id);
    if (!item) return;

    item.quantity += change;

    if (item.quantity <= 0) {
        removeFromCart(id);
    } else if (item.quantity > item.stock) {
        alert('Stok tidak mencukupi!');
        item.quantity = item.stock;
    }

    renderCart();
}

function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    renderCart();
}

function clearCart() {
    if (cart.length === 0 || confirm('Hapus semua item dari keranjang?')) {
        cart = [];
        renderCart();
    }
}

function renderCart() {
    const cartItemsEl = document.getElementById('cartItems');
    const totalAmountEl = document.getElementById('totalAmount');
    const btnProcess = document.getElementById('btnProcess');

    if (cart.length === 0) {
        cartItemsEl.innerHTML = '<p style="text-align: center; color: #999; padding: 40px 0;">Keranjang kosong</p>';
        totalAmountEl.textContent = 'Rp 0';
        btnProcess.disabled = true;
        return;
    }

    let html = '';
    let total = 0;

    cart.forEach(item => {
        const subtotal = item.price * item.quantity;
        total += subtotal;

        html += `
            <div class="cart-item">
                ${item.image
                    ? `<img src="/storage/${item.image}" class="cart-item-img">`
                    : '<div class="cart-item-img">☕</div>'
                }
                <div class="cart-item-details">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-price">Rp ${item.price.toLocaleString('id-ID')}</div>
                </div>
                <div class="cart-item-qty">
                    <button class="qty-btn" onclick="updateQuantity('${item.id}', -1)">-</button>
                    <span class="qty-value">${item.quantity}</span>
                    <button class="qty-btn" onclick="updateQuantity('${item.id}', 1)">+</button>
                </div>
                <button class="cart-remove" onclick="removeFromCart('${item.id}')">×</button>
            </div>
        `;
    });

    cartItemsEl.innerHTML = html;
    totalAmountEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    btnProcess.disabled = false;
}

function processTransaction() {
    if (cart.length === 0) {
        alert('Keranjang masih kosong!');
        return;
    }

    const paymentMethod = document.getElementById('payment_method').value;
    const customerName = document.getElementById('customer_name').value;

    const mappedItems = cart.map(item => ({
        product_id: item.id,
        quantity: item.quantity
    }));

    const formData = {
        _token: '{{ csrf_token() }}',
        items: mappedItems,
        payment_method: paymentMethod,
        customer_name: customerName
    };

    fetch('{{ route("transactions.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json', // Force JSON response
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(formData)
    })
    .then(async response => {
        const isJson = response.headers.get('content-type')?.includes('application/json');
        const data = isJson ? await response.json() : null;

        if (!response.ok) {
            // Get error message from JSON or use default text
            const error = (data && data.message) || response.statusText;
            return Promise.reject(error);
        }

        if (data.success) {
            window.location.href = data.redirect;
        } else {
            alert(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan: ' + error);
    });
}

function filterProducts() {
    const search = document.getElementById('searchProduct').value.toLowerCase();
    const products = document.querySelectorAll('.product-card-pos');

    products.forEach(product => {
        const name = product.dataset.name.toLowerCase();
        product.style.display = name.includes(search) ? 'block' : 'none';
    });
}
</script>
@endpush
