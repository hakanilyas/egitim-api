<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EducationResource;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::with(['category', 'tags'])
            ->paginate(10);
        
        return EducationResource::collection($educations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'content_type' => 'required|in:video,document,image',
            'start_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'tag_ids' => 'array',
            'tag_ids.*' => 'exists:tags,id'
        ]);

        $education = Education::create($request->only([
            'title', 'description', 'content_type', 'start_date', 'category_id'
        ]));

        if ($request->has('tag_ids')) {
            $education->tags()->sync($request->tag_ids);
        }

        return new EducationResource($education->load(['category', 'tags']));
    }

    public function show($id)
    {
        $education = Education::with(['category', 'tags'])->findOrFail($id);
        return new EducationResource($education);
    }

    public function update(Request $request, $id)
    {
        $education = Education::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'content_type' => 'sometimes|required|in:video,document,image',
            'start_date' => 'sometimes|required|date',
            'category_id' => 'sometimes|required|exists:categories,id',
            'tag_ids' => 'array',
            'tag_ids.*' => 'exists:tags,id'
        ]);

        $education->update($request->only([
            'title', 'description', 'content_type', 'start_date', 'category_id'
        ]));

        if ($request->has('tag_ids')) {
            $education->tags()->sync($request->tag_ids);
        }

        return new EducationResource($education->load(['category', 'tags']));
    }

    public function destroy($id)
    {
        $education = Education::findOrFail($id);
        $education->tags()->detach();
        $education->delete();

        return response()->json(['message' => 'Eğitim başarıyla silindi'], 200);
    }
}
