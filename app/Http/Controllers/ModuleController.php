<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ModuleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Module::with(['course', 'contents']);
        
        if ($request->has('course_id')) {
            $query->forCourse($request->course_id);
        }
        
        $modules = $query->paginate($request->get('per_page', 15));
        
        return response()->json([
            'status' => 'success',
            'data' => $modules
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'course_id' => 'required|exists:courses,id',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'duration' => 'nullable|string|max:255',
            ]);

            $module = Module::create($validated);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Module created successfully',
                'data' => $module->load(['course', 'contents'])
            ], 201);
            
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function show(Module $module): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $module->load(['course', 'contents'])
        ]);
    }

    public function update(Request $request, Module $module): JsonResponse
    {
        try {
            $validated = $request->validate([
                'course_id' => 'sometimes|required|exists:courses,id',
                'title' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'duration' => 'sometimes|nullable|string|max:255',
            ]);

            $module->update($validated);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Module updated successfully',
                'data' => $module->fresh(['course', 'contents'])
            ]);
            
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function destroy(Module $module): JsonResponse
    {
        $module->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Module deleted successfully'
        ]);
    }

    public function getContents(Module $module): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $module->contents
        ]);
    }
}
