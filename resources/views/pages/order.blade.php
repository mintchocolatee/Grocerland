@extends('components.layout')

@section('content')
    <div class="container">
        <h1 class="order-title">Order History</h1>
        @if ($orders->isEmpty())
            <p>You have no orders.</p>
        @else
            @foreach ($orders as $order)
                <div class="order">
                    <h2>Order</h2>
                    <p class="place-p">Placed on: {{ $order->created_at }}</p>
                    <p class="pay-p">Payment Method: {{ $order->payment_method }}</p>
                    <div class="order-details">
                        <div class="delivery-details">
                            <h3>Delivery Details</h3>
                            <p>Address: {{ $order->deliver_to }}</p>
                            <p>Receiver: {{ $order->receiver }}</p>
                            <p>Phone Number: {{ $order->phone_number }}</p>
                        </div>
                        <div class="productbuy-details">
                            <h3>Products</h3>
                            <ul>
                                @foreach ($order->products as $product)
                                    <li>
                                        {{ $product->name }} - {{ $product->pivot->quantity }} x
                                        RM{{ $product->pivot->price }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="other-details">
                            <h3>Total Amount : </h3>
                            <h4>RM{{ $order->total_amount }}</h4>
                            @if(auth()->user() && auth()->user()->role === 'user')
                                <form action="{{ route('orders.reorder', $order->id) }}" method="POST">
                                    @csrf
                                    <div class="button-details">
                                        <button type="submit" class="reorder-button">Reorder</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
