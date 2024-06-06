@extends('components.layout')

@section('content')
    <div class="checkout-success-page">
        <h1>Order Successful!</h1>
        <p>Your order has been placed successfully.</p>
        <a href="{{ route('products.index') }}">Continue Shopping</a>
    </div>
@endsection
