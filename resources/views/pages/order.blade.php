<!-- resources/views/pages/order.blade.php -->
@extends('components.layout')

@section('content')
    <div class="container">
        <h1>Order History</h1>
        @if ($orders->isEmpty())
            <p>You have no orders.</p>
        @else
            @foreach ($orders as $order)
                <div class="order">
                    <h2>Order #{{ $order->id }}</h2>
                    <p>Placed on: {{ $order->created_at }}</p>
                    <p>Total Amount: ${{ $order->total_amount }}</p>
                    <p>Status: {{ $order->status ?? 'Pending' }}</p>
                    <h3>Products:</h3>
                    <ul>
                        @foreach ($order->products as $product)
                            <li>
                                {{ $product->name }} - {{ $product->pivot->quantity }} x ${{ $product->pivot->price }}
                            </li>
                        @endforeach
                    </ul>
                    <form action="{{ route('orders.reorder', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Reorder</button>
                    </form>
                </div>
            @endforeach
        @endif
    </div>
@endsection
