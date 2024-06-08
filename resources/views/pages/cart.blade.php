@extends('components.layout')

@section('content')
    <div class="container">
        <h1 class="cart-title">My Cart</h1>
        @if ($cartItems->count() > 0)
            <div class="cart-items">
                @foreach ($cartItems as $cartItem)
                    <div class="cart-item" data-cart-item-id="{{ $cartItem->id }}" data-price="{{ $cartItem->product->price }}">
                        <input class="cart-checkbox" type="checkbox" name="selected_items[]" value="{{ $cartItem->id }}"
                            onchange="updateTotalAmount()">
                        <img src="{{ asset('storage/' . $cartItem->product->image_path) }}"
                            alt="{{ $cartItem->product->name }}">
                        <div class="product-details">
                            <h2>{{ $cartItem->product->name }}</h2>
                            <div class="quantity-controls">
                                <button class="decrease" onclick="updateQuantity({{ $cartItem->id }}, -1)">-</button>
                                <input type="number" name="quantity" value="{{ $cartItem->quantity }}" min="1" readonly>
                                <button class="increase" onclick="updateQuantity({{ $cartItem->id }}, 1)">+</button>
                            </div>
                            <p class="price">RM {{ $cartItem->product->price }}</p>
                        </div>
                        <button class="remove-item" onclick="removeItem({{ $cartItem->id }})">Remove</button>
                    </div>
                @endforeach
            </div>
            <div class="total-amount">
                Total Amount: RM <span id="total-amount">0.00</span>
            </div>
            <div class="checkout-cart-container">
                <button class="checkout-cart" onclick="proceedToCheckout()">Checkout</button>
            </div>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>

    <script>
        function updateQuantity(cartItemId, delta) {
            const cartItemElement = document.querySelector(`.cart-item[data-cart-item-id='${cartItemId}']`);
            const quantityInput = cartItemElement.querySelector('input[name="quantity"]');
            let newQuantity = parseInt(quantityInput.value) + delta;
            if (newQuantity < 1) return;

            fetch(`{{ url('cart/update') }}/${cartItemId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        quantity: newQuantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        quantityInput.value = newQuantity;
                        updateTotalAmount();
                    } else {
                        alert(data.message);
                    }
                });
        }

        function removeItem(cartItemId) {
            fetch(`{{ url('cart/remove') }}/${cartItemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`.cart-item[data-cart-item-id='${cartItemId}']`).remove();
                        updateTotalAmount();
                    } else {
                        alert(data.message);
                    }
                });
        }

        function updateTotalAmount() {
            let totalAmount = 0;
            document.querySelectorAll('.cart-item').forEach(cartItemElement => {
                const checkbox = cartItemElement.querySelector('.cart-checkbox');
                const quantityInput = cartItemElement.querySelector('input[name="quantity"]');
                const price = parseFloat(cartItemElement.dataset.price);
                if (checkbox.checked) {
                    totalAmount += parseInt(quantityInput.value) * price;
                }
            });
            document.getElementById('total-amount').textContent = totalAmount.toFixed(2);
        }

        function proceedToCheckout() {
            const selectedItems = [];
            document.querySelectorAll('input[name="selected_items[]"]:checked').forEach(checkbox => {
                selectedItems.push(checkbox.value);
            });

            if (selectedItems.length === 0) {
                alert('Please select at least one item to proceed.');
                return;
            }

            const url = new URL('{{ route('checkout.index') }}');
            selectedItems.forEach(item => url.searchParams.append('selected_items[]', item));

            window.location.href = url;
        }

        // Initial calculation of total amount
        updateTotalAmount();
    </script>
@endsection
