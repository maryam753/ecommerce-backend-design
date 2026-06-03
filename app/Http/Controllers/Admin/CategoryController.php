<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'description' => 'nullable',
        'icon' => 'nullable',
        'color' => 'nullable'
    ]);

    // store in database
    $category = Category::create([
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'description' => $request->description,
        'icon' => $request->icon,
        'color' => $request->color
    ]);

    return response()->json([
        'success' => true,
        'category' => $category
    ]);
}

public function show($id)
{
    return response()->json(
        Category::findOrFail($id)
    );
}
public function edit($id)
{
    return response()->json(
        Category::findOrFail($id)
    );
}
public function update(Request $request, $id)
{
    $category = Category::findOrFail($id);

    $category->update([
        'name' => $request->name,
        'description' => $request->description,
        'icon' => $request->icon,
        'color' => $request->color,
    ]);

  return response()->json([
        'success' => true,
        'category' => $category
    ]);
}
public function destroy($id)
{
    Category::findOrFail($id)->delete();

    return response()->json([
        'success' => true,
          
    ]);
}


}
