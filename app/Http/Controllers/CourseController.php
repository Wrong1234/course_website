<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ViewErrorBag;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('modules')->latest()->paginate(3);
        // dd($courses);
        return view('courses.index', ['courses' => $courses]);

    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
{
    // Validate the request - this will automatically redirect back with errors if validation fails
    $validated = $request->validate([
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

    try {
        DB::beginTransaction();

        // Create course
        $course = Course::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'duration' => $validated['duration'],
            'price' => $validated['price'],
        ]);

        // Create modules and their contents
        foreach ($validated['modules'] as $moduleData) {
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
    // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:programming,design,business,marketing,other',
            'description' => 'required|string',
            'duration' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'modules' => 'nullable|array',
            'modules.*.title' => 'required|string|max:255',
            'modules.*.description' => 'nullable|string',
            'modules.*.order' => 'nullable|integer|min:1',
            'modules.*.contents' => 'nullable|array',
            'modules.*.contents.*.title' => 'required|string|max:255',
            'modules.*.contents.*.type' => 'required|in:text,video,image,link,file',
            'modules.*.contents.*.description' => 'nullable|string',
            'modules.*.contents.*.content' => 'nullable|string',
            'modules.*.contents.*.url' => 'nullable|url',
            'modules.*.contents.*.file_path' => 'nullable|string',
            'modules.*.contents.*.file_size' => 'nullable|numeric|min:0.1',
            'modules.*.contents.*.alt_text' => 'nullable|string|max:255',
            'modules.*.contents.*.external' => 'nullable|boolean',
            'modules.*.contents.*.duration' => 'nullable|integer|min:1',
            'modules.*.contents.*.order' => 'nullable|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Update course basic information
            $course->update([
                'title' => $validated['title'],
                'category' => $validated['category'],
                'description' => $validated['description'],
                'duration' => $validated['duration'] ?? null,
                'price' => $validated['price'] ?? null,
            ]);

            // Handle modules
            if (isset($validated['modules'])) {
                // Delete existing modules and their contents
                $course->modules()->delete();

                // Create new modules
                foreach ($validated['modules'] as $moduleData) {
                    $module = $course->modules()->create([
                        'title' => $moduleData['title'],
                        'description' => $moduleData['description'] ?? null,
                        'order' => $moduleData['order'] ?? 1,
                    ]);

                    // Handle module contents
                    if (isset($moduleData['contents'])) {
                        foreach ($moduleData['contents'] as $contentData) {
                            $contentAttributes = [
                                'title' => $contentData['title'],
                                'type' => $contentData['type'],
                                'description' => $contentData['description'] ?? null,
                                'duration' => $contentData['duration'] ?? null,
                                'order' => $contentData['order'] ?? 1,
                            ];

                            // Add type-specific fields
                            switch ($contentData['type']) {
                                case 'text':
                                    $contentAttributes['content'] = $contentData['content'] ?? null;
                                    break;
                                
                                case 'video':
                                case 'link':
                                    $contentAttributes['url'] = $contentData['url'] ?? null;
                                    if ($contentData['type'] === 'link') {
                                        $contentAttributes['external'] = isset($contentData['external']) ? (bool)$contentData['external'] : false;
                                    }
                                    break;
                                
                                case 'image':
                                    $contentAttributes['url'] = $contentData['url'] ?? null;
                                    $contentAttributes['alt_text'] = $contentData['alt_text'] ?? null;
                                    break;
                                
                                case 'file':
                                    $contentAttributes['file_path'] = $contentData['file_path'] ?? null;
                                    $contentAttributes['file_size'] = $contentData['file_size'] ?? null;
                                    break;
                            }

                            $module->contents()->create($contentAttributes);
                        }
                    }
                }
            } else {
                // If no modules provided, delete existing ones
                $course->modules()->delete();
            }

            DB::commit();

            return redirect()->route('courses.show', $course)
                ->with('success', 'Course updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            
            return back()
                ->withInput()
                ->with('error', 'An error occurred while updating the course. Please try again.');
        }
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
