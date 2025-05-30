<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('educations')->get();
        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $category = Category::create($request->only(['name', 'description']));
        return new CategoryResource($category);
    }

    public function show($id)
    {
        $category = Category::withCount('educations')->findOrFail($id);
        return new CategoryResource($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $category->update($request->only(['name', 'description']));
        return new CategoryResource($category);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Eğer bu kategoriye ait eğitimler varsa silmeyi engelle
        if ($category->educations()->count() > 0) {
            return response()->json([
                'message' => 'Bu kategoriye ait eğitimler bulunduğu için silinemez.'
            ], 422);
        }
        
        $category->delete();
        return response()->json(['message' => 'Kategori başarıyla silindi'], 200);
    }
}
