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
                    <li><a href="{{ route('products.index', array_merge(request()->query(), ['category' => $category->id])) }}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="product-container">
            <div class="title-button-container">
                <h1>Product List</h1>
                @if(auth()->user() && auth()->user()->role === 'admin')
                    <button class="add-product-button">
                        <a href="{{ route('products.create') }}" class="btn btn-success">
                            <img width="40" height="40" src="https://img.icons8.com/?size=100&id=Xb6BIWuGB9xH&format=png&color=000000" alt="add"/>
                        </a>
                    </button>
                @endif
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

                                @if((auth()->check() && auth()->user()->role !== 'admin')|| !auth()->check())
                                    <form id="add-to-cart-form" action="{{ route('cart.add', $product->id) }}" method="POST" data-product-id="{{ $product->id }}" data-product-stock="{{ $product->stock }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="quantity">Quantity:</label>
                                            <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stock }}" required>
                                        </div>
                                        <button type="submit" class="add-to-cart-button">Add to Cart</button>
                                    </form>
                                @endif

                                @if(auth()->user() && auth()->user()->role === 'admin')
                                    <a href="{{ route('products.edit', $product->id) }}" class="edit-button">Edit product</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="delete-button" data-product-name="{{ $product->name }}">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="custom-pagination">
                <div class="productPageIndicator">
                    <div class="prevButtonContainer">
                        @if(!$products->onFirstPage())
                        <a href="{{ $products->appends(request()->query())->previousPageUrl() }}">
                            <button class="prevButton"><</button>
                        </a>
                        @endif
                    </div>
                    <div class="pageNumber">
                        {{ $products->currentPage() }}/{{ $products->lastPage() }}
                    </div>
                    <div class="nextButtonContainer">
                        @if($products->hasMorePages())
                        <a href="{{ $products->appends(request()->query())->nextPageUrl() }}">
                            <button class="nextButton">></button>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success and Error Modals -->
    @if (session('success'))
        <div class="modal-overlay">
            <div class="modal-content">
                <h2>Success!</h2>
                <p>{{ Session::get('success') }}</p>
                <button id="close-btn">Close</button>
            </div>
        </div>
    @elseif (session('error'))
        <div class="modal-overlay">
            <div class="modal-content">
                <h2>Fail to add!</h2>
                <p>{{ Session::get('error') }}</p>
                <button id="close-btn">Close</button>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <h2>Confirm Delete</h2>
            <p>Are you sure you want to delete this product?</p>
            <p id="product-name"></p>
            <button id="confirm-delete-btn">Delete</button>
            <button id="cancel-delete-btn">Cancel</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle success/error modals
            const closeButton = document.getElementById("close-btn");
            if (closeButton) {
                closeButton.onclick = function() {
                    window.location.href = "{{ route('products.index') }}";
                };
            }

            // Handle delete confirmation modal
            const deleteButtons = document.querySelectorAll('.delete-button');
            const deleteModal = document.getElementById('delete-modal');
            const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
            const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
            const productNameElement = document.getElementById('product-name');

            let currentForm;

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    currentForm = this.closest('form');
                    const productName = this.dataset.productName;
                    productNameElement.textContent = productName;
                    deleteModal.style.display = 'flex';
                });
            });

            confirmDeleteBtn.addEventListener('click', function() {
                currentForm.submit();
            });

            cancelDeleteBtn.addEventListener('click', function() {
                deleteModal.style.display = 'none';
                currentForm = null;
            });

            // Handle add-to-cart forms
            document.querySelectorAll('.add-to-cart-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); 

                    const productId = this.dataset.productId; 
                    const stock = parseInt(this.dataset.productStock); 
                    const quantity = parseInt(this.querySelector('#quantity').value);

                    if (quantity > stock) {
                        alert('Not enough stock available.');
                    } else {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endsection
