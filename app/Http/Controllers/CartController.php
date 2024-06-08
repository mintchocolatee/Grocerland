<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {   
        $user = Auth::user();
    if(!$user){
        return redirect()->route('user.login');
    }else{
        $userId = Auth::id();
        $cartItems = CartItem::where('user_id', $userId)
            ->with('product')
            ->latest() // Retrieve items in descending order based on creation date
            ->get();

        return view('pages.cart', compact('cartItems'));}
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $userId = Auth::id();
        $quantity = $request->input('quantity', 1);

        $cartItem = CartItem::updateOrCreate(
            ['user_id' => $userId, 'product_id' => $id],
            ['quantity' => DB::raw('quantity + ' . $quantity)]
        );

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request, $id)
{
    $cartItem = CartItem::findOrFail($id);

    if ($request->quantity < 1) {
        return response()->json(['success' => false, 'message' => 'Quantity must be at least 1.']);
    }

    $product = Product::findOrFail($cartItem->product_id);

    if ($request->quantity > $product->stock) {
        return response()->json(['success' => false, 'message' => 'Quantity exceeds available stock.']);
    }

    $cartItem->quantity = $request->quantity;
    $cartItem->save();

    return response()->json(['success' => true, 'message' => 'Cart updated successfully.']);
}

public function destroy($id)
{
    $cartItem = CartItem::findOrFail($id);
    $cartItem->delete();

    return response()->json(['success' => true, 'message' => 'Item removed from cart.']);
}

}
