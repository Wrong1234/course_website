<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('modules')->latest()->get();
        return view('courses.index', ['courses' => $courses,]);

    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:programming,design,business,marketing,other',
            'duration' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'modules' => 'required|array|min:1',
            'modules.*.title' => 'required|string|max:255',
            'modules.*.description' => 'nullable|string',
            'modules.*.order' => 'nullable|integer|min:1',
            'modules.*.contents' => 'nullable|array',
            'modules.*.contents.*.title' => 'required_with:modules.*.contents|string|max:255',
            'modules.*.contents.*.type' => 'required_with:modules.*.contents|string|in:text,video,image,link,file',
            'modules.*.contents.*.description' => 'nullable|string',
            'modules.*.contents.*.duration' => 'nullable|integer|min:1',
            'modules.*.contents.*.order' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Create course
            $course = Course::create([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'duration' => $request->duration,
                'price' => $request->price,
            ]);

            // Create modules and their contents
            foreach ($request->modules as $moduleData) {
                $module = $course->modules()->create([
                    'title' => $moduleData['title'],
                    'description' => $moduleData['description'] ?? null,
                    'order' => $moduleData['order'] ?? 1,
                ]);

                // Create contents for this module
                if (isset($moduleData['contents']) && is_array($moduleData['contents'])) {
                    foreach ($moduleData['contents'] as $contentData) {
                        $module->contents()->create([
                            'title' => $contentData['title'],
                            'type' => $contentData['type'],
                            'description' => $contentData['description'] ?? null,
                            'content' => $contentData['content'] ?? null,
                            'url' => $contentData['url'] ?? null,
                            'file_path' => $contentData['file_path'] ?? null,
                            'file_size' => $contentData['file_size'] ?? null,
                            'alt_text' => $contentData['alt_text'] ?? null,
                            'external' => isset($contentData['external']) ? 1 : 0,
                            'duration' => $contentData['duration'] ?? null,
                            'order' => $contentData['order'] ?? 1,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('courses.index')
                ->with('success', 'Course created successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'An error occurred while creating the course. Please try again.')
                ->withInput();
        }
    }

    public function show(Course $course)
    {
        $course->load(['modules.contents' => function($query) {
            $query->orderBy('order');
        }]);
        
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $course->load(['modules.contents']);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        // Similar validation and update logic as store method
        // Implementation would be similar to store but updating existing records
    }

    public function destroy(Course $course)
    {
        try {
            $course->delete();
            return redirect()->route('courses.index')
                ->with('success', 'Course deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while deleting the course.');
        }
    }
}