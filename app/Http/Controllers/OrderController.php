<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
{
    $orders = Order::with('items.product')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('recent-orders', compact('orders'));
}
}
