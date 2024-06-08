<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $selectedItems = $request->input('selected_items', []);
        $cartItems = CartItem::where('user_id', $userId)
            ->whereIn('id', $selectedItems)
            ->with('product')
            ->get();

        // Calculate the total price
        $totalPrice = $cartItems->sum(function($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });

        return view('pages.checkout', compact('cartItems', 'totalPrice'));
    }

    public function process(Request $request)
    {
        $userId = Auth::id();
        $selectedItems = $request->input('selected_items', []);
        $cartItems = CartItem::where('user_id', $userId)
            ->whereIn('id', $selectedItems)
            ->with('product')
            ->get();

        // Begin transaction
        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => $userId,
                'total_amount' => $cartItems->sum(function ($cartItem) {
                    return $cartItem->quantity * $cartItem->product->price;
                }),
                'deliver_to' => $request->input('deliver_to'),
                'receiver' => $request->input('receiver'),
                'phone_number' => $request->input('phone_number'),
                'payment_method' => $request->input('payment_method'),
            ]);

            foreach ($cartItems as $cartItem) {
                $order->products()->attach($cartItem->product_id, [
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price
                ]);

                // Reduce stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Delete cart items after order is placed
            CartItem::where('user_id', $userId)->whereIn('id', $selectedItems)->delete();

            // Commit transaction
            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollback();

            return redirect()->route('checkout.index')->with('error', 'Failed to place order. Please try again.');
        }
    }
}


