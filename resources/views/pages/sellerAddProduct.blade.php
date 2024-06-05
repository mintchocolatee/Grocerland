@extends('components.layout')

@section('content')
<div class="add-product-container">
    <div class="form-imageContainer">
        <div class="imageUploadContainer">
            <span id="uploaded-text">Uploaded Image</span>
            <img id="previewImage" src="" alt="Preview Image" style="display: none;"/>
            <img id="placeholderImage" src="{{ asset('assets/images/placeholder.jpg') }}" alt="Placeholder Image" style="display: block;"/>
        </div>

        <div class="add-product-form">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label for="productImage">Image</label>
                <input type="file" name="image" id="productImage" required>
                @error('image')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" value="{{ old('productName') }}" required>
                @error('productName')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="productDescription">Description:</label>
                <textarea id="productDescription" name="productDescription" required>{{ old('productDescription') }}</textarea>
                @error('productDescription')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="productPrice">Price:</label>
                <input type="text" id="productPrice" name="productPrice" value="{{ old('productPrice') }}" required>
                @error('productPrice')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="productStock">Stock:</label>
                <input type="number" id="productStock" name="productStock" value="{{ old('productStock') }}" required>
                @error('productStock')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="categoryId">Category:</label>
                <select id="categoryId" name="categoryId" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('categoryId') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('categoryId')
                    <div class="error">{{ $message }}</div>
                @enderror

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('productImage').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewImage = document.getElementById('previewImage');
        const placeholderImage = document.getElementById('placeholderImage');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                placeholderImage.style.display = 'none';
            }
            reader.readAsDataURL(file);
        } else {
            previewImage.src = '';
            previewImage.style.display = 'none';
            placeholderImage.style.display = 'block';
        }
    });
</script>
@endsection
