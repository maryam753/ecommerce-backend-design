<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
public function index()
{
    $isBuyNow = session()->has('buy_now_cart');

    if ($isBuyNow) {
        $cartItems = collect(session()->get('buy_now_cart'))->map(function ($item) {
            return (object) $item;
        });
    } else {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();
    }

    $subtotal = $cartItems->sum(function ($item) use ($isBuyNow) {

        if ($isBuyNow) {
            return $item->price * $item->qty;
        }

        return $item->product->price * $item->quantity;
    });

    $tax = $subtotal * 0.05;
    $total = $subtotal + $tax;

    return view('checkout', compact('cartItems', 'subtotal', 'tax', 'total'));
}
public function placeOrder(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required',
        'phone' => 'required',
        'country' => 'required',
        'city' => 'required',
        'address' => 'required',
        'shipping_method' => 'required',
        'payment_method' => 'required',
    ]);

    if (session()->has('buy_now_cart')) {
        $cartItems = collect(session()->get('buy_now_cart'));
        $isBuyNow = true;
    } else {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();
        $isBuyNow = false;
    }

    if ($cartItems->isEmpty()) {
        return back()->with('error', 'Cart is empty');
    }

    $total = 0;

    foreach ($cartItems as $item) {
        $price = $isBuyNow ? $item['price'] : $item->product->price;
        $qty = $isBuyNow ? $item['qty'] : $item->quantity;

        $total += $price * $qty;
    }

    $order = Order::create([
        'user_id' => auth()->id(),
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'country' => $request->country,
        'city' => $request->city,
        'address' => $request->address,
        'billing_address' => $request->billing_address,
        'shipping_method' => $request->shipping_method,
        'payment_method' => $request->payment_method,
        'total' => $total,
        'status' => 'pending',
    ]);

  foreach ($cartItems as $item) {

    if ($isBuyNow) {

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item['product_id'],
            'qty' => $item['qty'],
            'price' => $item['price'],
        ]);

    } else {

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'qty' => $item->quantity,
            'price' => $item->product->price,
        ]);
    }
}
    
    if ($isBuyNow) {
        session()->forget('buy_now_cart');
    } else {
        Cart::where('user_id', auth()->id())->delete();
    }

    return redirect('/checkout')->with('success', 'Order placed successfully!');
}
public function buyNow(Request $request)
{
    $product = Product::findOrFail($request->product_id);

    $buyNowCart = [
        [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'qty' => 1,
            'image' => $product->image,
        ]
    ];

    session()->put('buy_now_cart', $buyNowCart);

    return redirect()->route('checkout');
}
}