@extends('components.layout')

@section('content')
    <div class="checkout-page">
        <h1 class="check-title">Check Out</h1>
        <h1 class="delivery-title">Delivery Details</h1>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="delivery-container">
                <div class="checkout-form-group">
                    <label for="deliver_to">Deliver To :</label>
                    <input type="text" id="deliver_to" name="deliver_to" placeholder="Please enter your address" required>
                </div>
                <div class="checkout-form-group">
                    <label for="receiver">Receiver :</label>
                    <input type="text" id="receiver" name="receiver" placeholder="Please enter receiver's name"
                        required>
                </div>
                <div class="checkout-form-group">
                    <label for="phone_number">Phone Number :</label>
                    <input type="text" id="phone_number" name="phone_number" placeholder="Please enter your phone number"
                        required>
                </div>
                <div class="checkout-form-group">
                    <label for="payment_method">Payment Method :</label>
                    <select id="payment_method" name="payment_method" required>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Touch N Go">Touch N Go</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                    </select>
                </div>
            </div>

            <div class="checkout-container">
                <h1 class="checkout-title">Checkout</h1>
                <div class="checkout-items">
                    @foreach ($cartItems as $cartItem)
                        <div class="checkout-item">
                            <img src="{{ asset('storage/' . $cartItem->product->image_path) }}"
                                alt="{{ $cartItem->product->name }}">
                            <div class="checkout-item-details">
                                <h2>{{ $cartItem->product->name }}</h2>
                                <p>Price: RM{{ $cartItem->product->price }}</p>
                                <p>Quantity: {{ $cartItem->quantity }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                @foreach ($cartItems as $cartItem)
                    <input type="hidden" name="selected_items[]" value="{{ $cartItem->id }}">
                @endforeach
                <div class="total-price">
                    <h2>Total Price: RM{{ number_format($totalPrice, 2) }}</h2>
                </div>
                <div class="pay-button-container">
                    <button type="submit" class="checkout-button">Confirm and Pay</button>
                </div>
            </div>
        </form>
    </div>
@endsection
