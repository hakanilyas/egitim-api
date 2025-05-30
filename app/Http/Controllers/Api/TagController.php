<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('educations')->get();
        return TagResource::collection($tags);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $tag = Tag::create($request->only(['name', 'description']));
        return new TagResource($tag);
    }

    public function show($id)
    {
        $tag = Tag::withCount('educations')->findOrFail($id);
        return new TagResource($tag);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $tag->update($request->only(['name', 'description']));
        return new TagResource($tag);
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        
        // Tag'leri eğitimlerden ayır
        $tag->educations()->detach();
        $tag->delete();
        
        return response()->json(['message' => 'Etiket başarıyla silindi'], 200);
    }
}
