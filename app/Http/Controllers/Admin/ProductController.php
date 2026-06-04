<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Cloudinary\Cloudinary;

class ProductController extends Controller
{
  public function store(Request $request)
{
    $request->validate([
    'name'        => 'required',
    'sku'         => 'required|unique:products,sku',
    'category_id' => 'required|integer|exists:categories,id',
    'price'       => 'required|numeric',  
    'stock'       => 'required|integer',  
    'is_deal'     => 'nullable|boolean',
    'rating'      => 'nullable|numeric|min:0|max:5',
    'condition'   => 'nullable|string',
    'discount_price' => 'nullable|numeric',
    ]);

    $imagePath = null;

  if ($request->hasFile('image')) {
    try {
       $cloudinary = new Cloudinary([
    'cloud' => [
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
        'api_key'    => env('CLOUDINARY_API_KEY'),
        'api_secret' => env('CLOUDINARY_API_SECRET'),
    ]
]);
        
        $result = $cloudinary->uploadApi()->upload(
            $request->file('image')->getRealPath()
        );
        $imagePath = $result['secure_url'];
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}

    $product = Product::create([
        'name'           => $request->name,
        'sku'            => $request->sku,
        'category_id'    => $request->category_id,
        'price'          => $request->price,
        'stock'          => $request->stock,
        'rating'         => $request->rating,
        'condition'      => $request->condition,
        'description'    => $request->description,
        'image'          => $imagePath,
        'status'         => $request->status ?? 'Active',
        'is_deal'        => $request->is_deal ? 1 : 0,
'discount_price' => $request->discount_price ? $request->discount_price : null,
    ]);

    if ($request->expectsJson() || $request->ajax()) {
        $product->load('category');
        return response()->json([
            'message' => 'Product added',
            'product' => $product
        ], 201);
    }

    return redirect()->back()->with('success', 'Product added successfully');
}
    
    public function show($id, Request $request)
    {
        $product = Product::with('category')->findOrFail($id);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['product' => $product]);
        }

        return view('admin.product-show', compact('product'));
    }

    public function update(Request $request, $id)
    {
       $request->validate([
    'name'        => 'required',
    'sku'         => [
        'required',
        Rule::unique('products', 'sku')->ignore($id),
    ],
    'category_id' => 'required|integer|exists:categories,id',
    'price'       => 'required|numeric',
    'stock'       => 'required|integer',
    'is_deal'     => 'nullable|boolean',
    'rating'      => 'nullable|numeric|min:0|max:5',
    'condition'   => 'nullable|string',
    'discount_price' => 'nullable|numeric',
]);

        $product = Product::findOrFail($id);

        $data = [
            'name'        => $request->name,
            'sku'         => $request->sku,
            'category_id' => $request->category_id,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'rating'         => $request->rating,
            'condition'      => $request->condition,
            'description' => $request->description,
            'status'      => $request->status ?? $product->status,
            'is_deal'        => $request->is_deal ? 1 : 0,
'discount_price' => $request->discount_price ? $request->discount_price : null,            
        ];
if ($request->hasFile('image')) {
    try {
        $cloudinary = new Cloudinary([
    'cloud' => [
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
        'api_key'    => env('CLOUDINARY_API_KEY'),
        'api_secret' => env('CLOUDINARY_API_SECRET'),
    ]
]);
        
        $result = $cloudinary->uploadApi()->upload(
            $request->file('image')->getRealPath()
        );
        $data['image'] = $result['secure_url'];
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}

        $product->update($data);
        $product->load('category');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['message' => 'Product updated', 'product' => $product]);
        }

        return redirect()->back()->with('success', 'Product updated');
    }

    // DELETE /product/{id}
    public function destroy($id, Request $request)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['message' => 'Product deleted']);
        }

        return redirect()->back()->with('success', 'Product deleted');
    }
    public function getCategoryProducts($id)
{
    $products = Product::where('category_id', $id)->get();

    return response()->json($products);
}
public function search(Request $request)
{
    $q        = $request->get('q', '');
    $category = $request->get('category', '');

    $products = Product::with('category')
        ->where('name', 'LIKE', "%{$q}%")
        ->when($category, fn($query) => $query->where('category_id', $category))
        ->limit(8)
        ->get(['id', 'name', 'category_id']);

    return response()->json($products);
}
}