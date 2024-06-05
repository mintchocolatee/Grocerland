@extends('components.layout')

@section('content')
    <div class="slider">
        <div class="slides">
            <img src="../assets/images/imageSlide1.svg" alt="Image 1">
            <img src="../assets/images/imageSlide2.svg" alt="Image 2">
            <img src="../assets/images/imageSlide3.svg" alt="Image 3">
        </div>
    </div>
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
        <div class="product-container">
            <div class="title-button-container">
                <h1>Product List</h1>
                {{-- only admin --}}
                <button class="add-product-button">
                    <a href="{{ route('products.create') }}" class="btn btn-success">
                        <img width="40" height="40" src="https://img.icons8.com/?size=100&id=Xb6BIWuGB9xH&format=png&color=000000" alt="add"/>
                    </a>
                </button>
            </div>
            <form action="{{ route('products.index') }}" method="GET" class="sort-filter-form">
                <label for="sortBy">Sort By:</label>
                <select name="sort_by" id="sortBy">
                    <option value="date_desc">Date Posted (Newest First)</option>
                    <option value="date_asc">Date Posted (Oldest First)</option>
                    <option value="name_asc">Name (A-Z)</option>
                    <option value="name_desc">Name (Z-A)</option>
                    <option value="price_asc">Price (Low to High)</option>
                    <option value="price_desc">Price (High to Low)</option>
                </select>
                <label for="priceFrom">Price Range:</label>
                <input type="number" name="price_from" id="priceFrom" min="0" step="any">
                <label for="priceTo">to</label>
                <input type="number" name="price_to" id="priceTo" min="0" step="any">
                <input type="hidden" name="category" value="{{ request()->input('category') }}">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </form>

            <div class="products">
                @foreach($products as $product)
                    <div class="product-card-container">
                        <div class="product-card">
                            <div class="product-image-container">
                                <img src="{{ asset('storage/' . $product->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                            </div>
                            <div class="product-card-body">
                                <a href="{{ route('products.show', $product->id) }}" class="card-title">{{ $product->name }}</a>
                                <p class="card-price">RM {{ $product->price }}</p>

                                {{-- only user --}}
                                {{-- <form id="add-to-cart-form" action="{{ route('cart.add', $product->id) }}" method="POST" data-product-id="{{ $product->id }}" data-product-stock="{{ $product->stock }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="quantity">Quantity:</label>
                                        <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stock }}" required>
                                    </div>
                                    <button type="submit" class="add-to-cart-button">Add to Cart</button>
                                </form> --}}
                                
                                {{-- only admin --}}
                                <a href="{{ route('products.edit', $product->id) }}" class="edit-button">Edit product</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="custom-pagination">
                <div class="productPageIndicator">
                    <div class="prevButtonContainer">
                        @if(!$products->onFirstPage())
                        <a href="{{ $products->previousPageUrl() }}">
                            <button class="prevButton"><</button>
                        </a>
                        @endif
                    </div>
                    <div class="pageNumber">
                        {{ $products->currentPage() }}/{{ $products->lastPage() }}
                    </div>
                    <div class="nextButtonContainer">
                        @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}">
                            <button class="nextButton">></button>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <script>
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent form submission for now
                
                const productId = this.dataset.productId; // Get the product ID from data attribute
                const stock = parseInt(this.dataset.productStock); // Get the product's stock from data attribute
                const quantity = parseInt(this.querySelector('#quantity').value); // Get the quantity entered by the user
                
                if (quantity > stock) {
                    alert('Not enough stock available.');
                } else {
                    // Proceed with form submission if stock is sufficient
                    this.submit();
                }
            });
        });
    </script>
@endsection
