<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ContentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Content::with('module.course');
        
        if ($request->has('module_id')) {
            $query->forModule($request->module_id);
        }
        
        if ($request->has('type')) {
            $query->ofType($request->type);
        }
        
        if ($request->boolean('media_only')) {
            $query->mediaContent();
        }
        
        $contents = $query->paginate($request->get('per_page', 15));
        
        return response()->json([
            'status' => 'success',
            'data' => $contents
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'module_id' => 'required|exists:modules,id',
                'title' => 'required|string|max:255',
                'type' => 'required|in:' . implode(',', Content::getContentTypes()),
                'content' => 'nullable|string',
                'media_url' => 'nullable|string|max:255',
                'video_length' => 'nullable|string|max:255',
            ]);

            $content = Content::create($validated);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Content created successfully',
                'data' => $content->load('module.course')
            ], 201);
            
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function show(Content $content): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $content->load('module.course')
        ]);
    }

    public function update(Request $request, Content $content): JsonResponse
    {
        try {
            $validated = $request->validate([
                'module_id' => 'sometimes|required|exists:modules,id',
                'title' => 'sometimes|required|string|max:255',
                'type' => 'sometimes|required|in:' . implode(',', Content::getContentTypes()),
                'content' => 'sometimes|nullable|string',
                'media_url' => 'sometimes|nullable|string|max:255',
                'video_length' => 'sometimes|nullable|string|max:255',
            ]);

            $content->update($validated);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Content updated successfully',
                'data' => $content->fresh('module.course')
            ]);
            
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function destroy(Content $content): JsonResponse
    {
        $content->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Content deleted successfully'
        ]);
    }

    public function getContentTypes(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => Content::getContentTypes()
        ]);
    }
}