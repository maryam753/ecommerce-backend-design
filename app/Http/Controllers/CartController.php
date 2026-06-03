<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // ADD TO CART
    public function add(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'login_required' => true
            ]);
        }

        $product = Product::findOrFail($request->product_id);

        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        $count = Cart::where('user_id', auth()->id())->sum('quantity');

return response()->json([
    'success' => true,
    'message' => 'Product added to cart',
    'count' => $count,
    'cartCount' => $count
]);
    }

    // CART PAGE
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $tax = $subtotal * 0.05;
        $total = $subtotal + $tax;

        return view('cart', compact(
            'cartItems',
            'subtotal',
            'tax',
            'total'
        ));
    }
    public function remove($id)
{
    $cartItem = Cart::find($id);

    if (!$cartItem) {
        return back()->with('error', 'Item not found in cart');
    }

    $cartItem->delete();

    return back()->with('success', 'Item removed from cart');
}
public function updateQty(Request $request, $id)
{
    $request->validate([
        'qty' => 'required|integer|min:1|max:20'
    ]);

    $cartItem = Cart::find($id);

    if (!$cartItem) {
        return back()->with('error', 'Cart item not found');
    }

    $cartItem->quantity = $request->qty;
    $cartItem->save();

    return back()->with('success', 'Quantity updated successfully');
}
public function clear()
{
    Cart::where('user_id', auth()->id())->delete();

    return back()->with('success', 'Cart cleared successfully');
}
}