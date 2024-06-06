@extends('components.layout')

@section('content')
    <div class="cart-page">
        <h1>Your Cart</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($cartItems->isEmpty())
            <p>Your cart is empty.</p>
        @else
            <form id="cart-form" action="{{ route('checkout.index') }}" method="GET">
                <div class="cart-items">
                    @foreach ($cartItems as $cartItem)
                        <div class="cart-item">
                            @if ($cartItem->product)
                                <input type="checkbox" name="selected_items[]" value="{{ $cartItem->id }}">
                                <img src="{{ asset('storage/' . $cartItem->product->image_path) }}"
                                    alt="{{ $cartItem->product->name }}">
                                <div class="cart-item-details">
                                    <h2>{{ $cartItem->product->name }}</h2>
                                    <p>Price: ${{ $cartItem->product->price }}</p>
                                    <form action="{{ route('cart.update', $cartItem->id) }}" method="POST"
                                        class="update-form">
                                        @csrf
                                        @method('PATCH')
                                        <label for="quantity">Quantity:</label>
                                        <input type="number" name="quantity" value="{{ $cartItem->quantity }}"
                                            min="1">
                                        <button type="submit">Update</button>
                                    </form>
                                </div>
                                <form action="{{ route('cart.destroy', $cartItem->id) }}" method="POST"
                                    class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button">Delete</button>
                                </form>
                            @else
                                <p>Product information not available.</p>
                            @endif
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="checkout-button">Proceed to Checkout</button>
            </form>
        @endif
    </div>
@endsection

{{-- @section('scripts')
    <script>
        document.getElementById('checkout-button').forEach(button => {
            button.addEventListener('click', function(event) {
                let checkboxes = document.querySelectorAll('input[name="selected_items[]"]:checked');
                if (checkboxes.length === 0) {
                    e.preventDefault();
                    alert('No items selected for checkout.');
                }
            });
        });
    </script>
@endsection --}}
