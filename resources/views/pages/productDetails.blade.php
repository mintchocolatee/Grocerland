@extends('components.layout')

@section('content')
    <div class="category-product-container">
        <div class="category-container">
            <h3>Categories</h3>
            <ul>
                <li><a href="{{ route('products.index') }}">All</a></li>
                @foreach($categories as $category)
                    <li><a href="{{ route('products.index', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="product-image-name">
            <h1>{{ $product->name }}</h1>
            <div class="product-details-image">
                @if($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" width="300">
                @else
                    <p>No Image Available</p>
                @endif
            </div>
        </div>
        <div class="product-details-info">
            <p class="product-details-description"><strong>Description:</strong> {{ $product->description }}</p>
            <p class="product-details-price"><strong>Price:</strong> RM{{ $product->price }}</p>
            <p class="product-details-stock"><strong>Stock:</strong> {{ $product->stock }}</p>
            <form id="product-details-add-to-cart-form" action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stock }}" required>
                </div>
                <button type="submit" class="add-to-cart-button">Add to Cart</button>
            </form>
        </div>
    <script>
        document.getElementById('add-to-cart-form').addEventListener('submit', function(event) {
            const quantity = parseInt(document.getElementById('quantity').value);
            const stock = {{ $product->stock }};
            if (quantity > stock) {
                alert('Not enough stock available.');
                event.preventDefault();
            }
        });
    </script>
@endsection
