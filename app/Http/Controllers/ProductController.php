<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        
        $categoryId = $request->input('category'); // Get the selected category ID from the request
        
        $productsQuery = Product::query();
        
        if ($categoryId) {
            $productsQuery->where('category_id', $categoryId);
        }
        
        // Apply sorting based on the selected sort option
        $sort_by = $request->input('sort_by');
        if ($sort_by === 'name_asc') {
            $productsQuery->orderBy('name', 'asc');
        } elseif ($sort_by === 'name_desc') {
            $productsQuery->orderBy('name', 'desc');
        } elseif ($sort_by === 'price_asc') {
            $productsQuery->orderBy('price', 'asc');
        } elseif ($sort_by === 'price_desc') {
            $productsQuery->orderBy('price', 'desc');
        } elseif ($sort_by === 'date_asc') {
            $productsQuery->orderBy('created_at', 'asc');
        } elseif ($sort_by === 'date_desc') {
            $productsQuery->orderBy('created_at', 'desc');
        }

        // Apply price range filtering if provided
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');
        if ($price_from && $price_to) {
            $productsQuery->whereBetween('price', [$price_from, $price_to]);
        }

        $productsQuery->where('stock', '>', 0);
        
        // Fetch products based on the query
        $products = $productsQuery->paginate(20);
        
        return view('pages.products', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.sellerAddProduct', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'productName' => 'required|string|max:255',
            'productDescription' => 'required|string',
            'productPrice' => 'required|numeric',
            'productStock' => 'required|integer|min:1',
            'categoryId' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        $product = new Product();
        $product->name = $request->input('productName');
        $product->description = $request->input('productDescription');
        $product->price = $request->input('productPrice');
        $product->stock = $request->input('productStock');
        $product->category_id = $request->input('categoryId');
        $product->image_path =  $imagePath ??null;
        $product->save();

        // Redirect to a specific route with a success message
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categories = Category::all();
        
        $categoryId = request()->input('category');
        $productsQuery = Product::query();
        
        if ($categoryId) {
            $productsQuery->where('category_id', $categoryId);
        }
        
        $products = $productsQuery->paginate(10); // Change 10 to your desired per-page limit
        $product = Product::findOrFail($id);
        return view('pages.productDetails', compact('product','categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('pages.editProduct', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'productName' => 'required|string|max:255',
            'productDescription' => 'required|string',
            'productPrice' => 'required|numeric',
            'productStock' => 'required|integer|min:1',
            'categoryId' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Find the product by ID
        $product = Product::findOrFail($id);

        // If a new image is uploaded, handle the upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            // Store the new image
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image_path = $imagePath;
        }

        // Update the product details
        $product->name = $request->input('productName');
        $product->description = $request->input('productDescription');
        $product->price = $request->input('productPrice');
        $product->stock = $request->input('productStock');
        $product->category_id = $request->input('categoryId');
        $product->save();

        // Redirect to a specific route with a success message
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // If the search query is empty, fetch all products
        if (empty($query)) {
            $products = Product::paginate(20); // Fetch all products
        } else {
            // Search products by name or description
            $products = Product::where('name', 'LIKE', "%{$query}%")
                            ->orWhere('description', 'LIKE', "%{$query}%")
                            ->paginate(20);
        }

        // Fetch categories for sidebar
        $categories = Category::all();

        return view('pages.products', compact('products', 'categories'));
    }

}