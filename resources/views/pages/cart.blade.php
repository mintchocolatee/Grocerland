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
            <div class="cart-items">
                @foreach ($cartItems as $cartItem)
                    <div class="cart-item">
                        <img src="{{ asset('storage/' . $cartItem->product->image) }}" alt="{{ $cartItem->product->name }}">
                        <div class="cart-item-details">
                            <h2>{{ $cartItem->product->name }}</h2>
                            <p>Price: ${{ $cartItem->product->price }}</p>
                            <form action="{{ route('cart.update', $cartItem->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <label for="quantity">Quantity:</label>
                                <input type="number" name="quantity" value="{{ $cartItem->quantity }}" min="1">
                                <button type="submit">Update</button>
                            </form>
                        </div>
                        <form action="{{ route('cart.destroy', $cartItem->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">Delete</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
