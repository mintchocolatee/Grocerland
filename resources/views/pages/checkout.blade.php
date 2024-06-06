@extends('components.layout')

@section('content')
    <div class="checkout-page">
        <h1>Checkout</h1>
        <div class="checkout-items">
            @foreach ($cartItems as $cartItem)
                <div class="checkout-item">
                    <img src="{{ asset('storage/' . $cartItem->product->image_path) }}" alt="{{ $cartItem->product->name }}">
                    <div class="checkout-item-details">
                        <h2>{{ $cartItem->product->name }}</h2>
                        <p>Price: ${{ $cartItem->product->price }}</p>
                        <p>Quantity: {{ $cartItem->quantity }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            @foreach ($cartItems as $cartItem)
                <input type="hidden" name="selected_items[]" value="{{ $cartItem->id }}">
            @endforeach
            <button type="submit" class="checkout-button">Confirm and Pay</button>
        </form>
    </div>
@endsection
