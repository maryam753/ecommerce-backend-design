<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Str;


class AdminController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
            $orderCount = Order::count();  

        return view('admin-panel', compact('products', 'categories','orderCount'));
    }

}
