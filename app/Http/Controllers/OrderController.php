<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
{
    $user = Auth::user();
    if(!$user){
        return redirect()->route('user.login');
    }else if ($user->role === 'admin') {
        $orders = Order::with('user', 'products')->latest()->get();
    } else {
        $orders = Order::where('user_id', $user->id)->with('products')->latest()->get();
    }

    return view('pages.order', compact('orders'));
}


    public function reorder($orderId)
    {
        $order = Order::findOrFail($orderId);
        $user = Auth::user();

        if ($order->user_id !== $user->id && $user->role !== 'admin') {
            return redirect()->route('orders.index')->with('error', 'You do not have permission to reorder this order.');
        }

        foreach ($order->products as $product) {
            if ($product->stock < $product->pivot->quantity) {
                return redirect()->route('orders.index')->with('error', 'One of the products exceeds available stock.');
            }

            $user->cartItems()->updateOrCreate(
                ['product_id' => $product->id],
                ['quantity' => $product->pivot->quantity]
            );
        }

        return redirect()->route('cart.index')->with('success', 'Order added to cart.');
    }
}
