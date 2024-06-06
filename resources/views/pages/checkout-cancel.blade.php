@extends('components.layout')

@section('content')
    <div class="checkout-cancel-page">
        <h1>Order Cancelled</h1>
        <p>Your order has been cancelled.</p>
        <a href="{{ route('cart.index') }}">Go back to Cart</a>
    </div>
@endsection
