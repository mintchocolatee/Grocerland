<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
            return redirect()->route('cart.index')->with('error', 'No items selected for checkout.');
        }

        $cartItems = CartItem::where('user_id', $userId)
            ->whereIn('id', $selectedItems)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'No items selected for checkout.');
        }

        return view('pages.checkout', compact('cartItems'));
    }

    public function process(Request $request)
    {
        $userId = Auth::id();
        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
            return redirect()->route('cart.index')->with('error', 'No selected items selected for checkout.');
        }

        $cartItems = CartItem::where('user_id', $userId)
            ->whereIn('id', $selectedItems)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'No cart items selected for checkout.');
        }

        // Create an Order
        $order = Order::create(['user_id' => $userId, 'total_amount' => 0]); // Adjust total calculation as needed

        $total_amount = 0;
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;

            if ($cartItem->quantity > $product->stock) {
                return redirect()->route('cart.index')->with('error', 'One of the products exceeds available stock.');
            }

            $total_amount += $product->price * $cartItem->quantity;

            // Create OrderProduct
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $cartItem->quantity,
                'price' => $product->price,
            ]);

            // Reduce stock
            $product->stock -= $cartItem->quantity;
            $product->save();
        }

        $order->total_amount = $total_amount;
        $order->save();

        // Clear the selected cart items
        CartItem::whereIn('id', $selectedItems)->delete();

        return redirect()->route('checkout.success');
    }

    public function success()
    {
        return view('pages.checkout-success');
    }

    public function cancel()
    {
        return view('pages.checkout-cancel');
    }
}
