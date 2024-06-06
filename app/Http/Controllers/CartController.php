<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $userId = Auth::id();
        $quantity = $request->input('quantity');

        // Retrieve cart items for the user
        $cartItems = CartItem::where('user_id', $userId)
            ->where('product_id', $id)
            ->get();

        // Calculate total quantity in the cart
        $totalQuantityInCart = $quantity; // Start with the new quantity being added
        foreach ($cartItems as $cartItem) {
            $totalQuantityInCart += $cartItem->quantity;
        }
        
        // Check if total quantity exceeds available stock
        if ($totalQuantityInCart > $product->stock) {
            return redirect()->route('products.index')->with('error', 'Total quantity in cart exceeds available stock. You can add ' .(($product->stock)-($totalQuantityInCart-$quantity)). ' more');
        }

        // Update or create cart item
        $cartItem = CartItem::updateOrCreate(
            ['user_id' => $userId, 'product_id' => $id],
            ['quantity' => DB::raw('quantity + ' . $quantity)]
        );

        return redirect()->route('products.index')->with('success', 'Product added to cart.');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
