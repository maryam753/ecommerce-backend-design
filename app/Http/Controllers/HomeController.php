<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
{
    $categories = Category::all();
     $products = Product::all(); 
     $deals = Product::where('is_deal', 1)->get();
      $homeDecor = Product::whereHas('category', function ($q) { $q->where('name', 'home &decor'); })->get(); 
      $computer = Product::whereHas('category', function ($q) { $q->where('name', 'computer and tech'); })->get();
    $recommended = Product::latest()->take(10)->get();

    return view('home', compact(
        'categories',
        'products',
        'deals',
        'computer',
        'homeDecor',
        'recommended'
    ));
}
public function allProducts(Request $request)
{
    $categories = Category::all();

    $query = Product::query();

    // CATEGORY FILTER
    if ($request->filled('category')) {
        $query->whereIn('category_id', $request->category);
    }

    // CONDITION FILTER
    if ($request->filled('condition')) {
        $query->whereIn('condition', $request->condition);
    }

    // RATING FILTER
    if ($request->filled('rating')) {
        $query->where(function ($q) use ($request) {
            foreach ($request->rating as $r) {
                $q->orWhere('rating', '>=', $r);
            }
        });
    }

    // VERIFIED
    if ($request->filled('verified')) {
        $query->where('is_verified', 1);
    }

    // SORTING
    if ($request->sort == 'price_low') {
        $query->orderBy('price', 'asc');
    }

    if ($request->sort == 'price_high') {
        $query->orderBy('price', 'desc');
    }

    if ($request->sort == 'newest') {
        $query->orderBy('created_at', 'desc');
    }

    if ($request->sort == 'rating') {
        $query->orderBy('rating', 'desc');
    }

    $products = $query->get();

    return view('product-listing', compact('products', 'categories'));
}
public function productDetail($id)
{
    $product = Product::with('category')->findOrFail($id);

    $youMayLike = Product::where('category_id', $product->category_id)
                    ->where('id', '!=', $product->id)
                    ->limit(5)
                    ->get();

    $relatedProducts = Product::where('category_id', $product->category_id)
                    ->where('id', '!=', $product->id)
                    ->limit(8)
                    ->get();

    return view('product-detail', compact('product', 'youMayLike', 'relatedProducts'));
}
 
}
