@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="fas fa-edit"></i> Edit Course</h1>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Courses
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <h5><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="courseForm" action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Course Information Section -->
                <div class="course-section">
                    <h3 class="mb-4"><i class="fas fa-book"></i> Course Information</h3>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Course Title <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title', $course->title) }}" 
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" 
                                        id="category" 
                                        name="category" 
                                        required>
                                    <option value="">Select Category</option>
                                    <option value="programming" {{ old('category', $course->category) == 'programming' ? 'selected' : '' }}>Programming</option>
                                    <option value="design" {{ old('category', $course->category) == 'design' ? 'selected' : '' }}>Design</option>
                                    <option value="business" {{ old('category', $course->category) == 'business' ? 'selected' : '' }}>Business</option>
                                    <option value="marketing" {{ old('category', $course->category) == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                    <option value="other" {{ old('category', $course->category) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Course Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  required>{{ old('description', $course->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration" class="form-label">Duration (hours)</label>
                                <input type="number" 
                                       class="form-control @error('duration') is-invalid @enderror" 
                                       id="duration" 
                                       name="duration" 
                                       value="{{ old('duration', $course->duration) }}" 
                                       min="1">
                                @error('duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Price ($)</label>
                                <input type="number" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       id="price" 
                                       name="price" 
                                       value="{{ old('price', $course->price) }}" 
                                       step="0.01" 
                                       min="0">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modules Section -->
                <div class="modules-section">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3><i class="fas fa-layer-group"></i> Course Modules</h3>
                        <button type="button" class="btn btn-success" id="addModuleBtn">
                            <i class="fas fa-plus"></i> Add Module
                        </button>
                    </div>
                    
                    <div id="modulesContainer">
                        @foreach($course->modules ?? [] as $moduleIndex => $module)
                            <div class="module-card" data-module-id="{{ $moduleIndex + 1 }}">
                                <div class="module-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-folder"></i> Module {{ $moduleIndex + 1 }}
                                    </h5>
                                    <button type="button" class="btn-remove remove-module" title="Remove Module">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <div class="p-3">
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <label class="form-label">Module Title <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control module-title" 
                                                   name="modules[{{ $moduleIndex + 1 }}][title]" 
                                                   value="{{ old('modules.' . ($moduleIndex + 1) . '.title', $module->title ?? '') }}"
                                                   required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Order</label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   name="modules[{{ $moduleIndex + 1 }}][order]" 
                                                   value="{{ old('modules.' . ($moduleIndex + 1) . '.order', $module->order ?? ($moduleIndex + 1)) }}" 
                                                   min="1">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Module Description</label>
                                        <textarea class="form-control" 
                                                  name="modules[{{ $moduleIndex + 1 }}][description]" 
                                                  rows="2">{{ old('modules.' . ($moduleIndex + 1) . '.description', $module->description ?? '') }}</textarea>
                                    </div>
                                    
                                    <!-- Content Section -->
                                    <div class="nested-structure">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6><i class="fas fa-file-alt"></i> Module Content</h6>
                                            <button type="button" class="btn btn-sm btn-info add-content" data-module-id="{{ $moduleIndex + 1 }}">
                                                <i class="fas fa-plus"></i> Add Content
                                            </button>
                                        </div>
                                        
                                        <div class="content-container" data-module-id="{{ $moduleIndex + 1 }}">
                                            @foreach($module->contents ?? [] as $contentIndex => $content)
                                                <div class="content-item" data-content-id="{{ $contentIndex + 1 }}">
                                                    <div class="content-header">
                                                        <span><i class="fas fa-file"></i> Content {{ $contentIndex + 1 }}</span>
                                                        <button type="button" class="btn-remove remove-content" title="Remove Content">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Content Title <span class="text-danger">*</span></label>
                                                            <input type="text" 
                                                                   class="form-control content-title" 
                                                                   name="modules[{{ $moduleIndex + 1 }}][contents][{{ $contentIndex + 1 }}][title]" 
                                                                   value="{{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.title', $content->title ?? '') }}"
                                                                   required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Content Type <span class="text-danger">*</span></label>
                                                            <select class="form-select content-type" 
                                                                    name="modules[{{ $moduleIndex + 1 }}][contents][{{ $contentIndex + 1 }}][type]" 
                                                                    required>
                                                                <option value="">Select Type</option>
                                                                <option value="text" {{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.type', $content->type ?? '') == 'text' ? 'selected' : '' }}>Text</option>
                                                                <option value="video" {{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.type', $content->type ?? '') == 'video' ? 'selected' : '' }}>Video</option>
                                                                <option value="image" {{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.type', $content->type ?? '') == 'image' ? 'selected' : '' }}>Image</option>
                                                                <option value="link" {{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.type', $content->type ?? '') == 'link' ? 'selected' : '' }}>Link</option>
                                                                <option value="file" {{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.type', $content->type ?? '') == 'file' ? 'selected' : '' }}>File</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Content Description</label>
                                                        <textarea class="form-control" 
                                                                  name="modules[{{ $moduleIndex + 1 }}][contents][{{ $contentIndex + 1 }}][description]" 
                                                                  rows="3">{{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.description', $content->description ?? '') }}</textarea>
                                                    </div>
                                                    
                                                    <div class="content-specific-fields">
                                                        @if(isset($content->type))
                                                            @if($content->type == 'text')
                                                                <div class="mb-3">
                                                                    <label class="form-label">Text Content</label>
                                                                    <textarea class="form-control" 
                                                                              name="modules[{{ $moduleIndex + 1 }}][contents][{{ $contentIndex + 1 }}][content]" 
                                                                              rows="5" 
                                                                              placeholder="Enter your text content here...">{{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.content', $content->content ?? '') }}</textarea>
                                                                </div>
                                                            @elseif($content->type == 'video')
                                                                <div class="mb-3">
                                                                    <label class="form-label">Video URL</label>
                                                                    <input type="url" 
                                                                           class="form-control" 
                                                                           name="modules[{{ $moduleIndex + 1 }}][contents][{{ $contentIndex + 1 }}][url]" 
                                                                           value="{{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.url', $content->url ?? '') }}"
                                                                           placeholder="https://youtube.com/watch?v=...">
                                                                </div>
                                                            @elseif($content->type == 'image')
                                                                <div class="mb-3">
                                                                    <label class="form-label">Image URL</label>
                                                                    <input type="url" 
                                                                           class="form-control" 
                                                                           name="modules[{{ $moduleIndex + 1 }}][contents][{{ $contentIndex + 1 }}][url]" 
                                                                           value="{{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.url', $content->url ?? '') }}"
                                                                           placeholder="https://example.com/image.jpg">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Alt Text</label>
                                                                    <input type="text" 
                                                                           class="form-control" 
                                                                           name="modules[{{ $moduleIndex + 1 }}][contents][{{ $contentIndex + 1 }}][alt_text]" 
                                                                           value="{{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.alt_text', $content->alt_text ?? '') }}"
                                                                           placeholder="Description of the image">
                                                                </div>
                                                            @elseif($content->type == 'link')
                                                                <div class="mb-3">
                                                                    <label class="form-label">Link URL</label>
                                                                    <input type="url" 
                                                                           class="form-control" 
                                                                           name="modules[{{ $moduleIndex + 1 }}][contents][{{ $contentIndex + 1 }}][url]" 
                                                                           value="{{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.url', $content->url ?? '') }}"
                                                                           placeholder="https://example.com">
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" 
                                                                           type="checkbox" 
                                                                           name="modules[{{ $moduleIndex + 1 }}][contents][{{ $contentIndex + 1 }}][external]" 
                                                                           value="1"
                                                                           {{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.external', $content->external ?? false) ? 'checked' : '' }}>
                                                                    <label class="form-check-label">Open in new tab</label>
                                                                </div>
                                                            @elseif($content->type == 'file')
                                                                <div class="mb-3">
                                                                    <label class="form-label">File URL or Path</label>
                                                                    <input type="text" 
                                                                           class="form-control" 
                                                                           name="modules[{{ $moduleIndex + 1 }}][contents][{{ $contentIndex + 1 }}][file_path]" 
                                                                           value="{{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.file_path', $content->file_path ?? '') }}"
                                                                           placeholder="path/to/file.pdf">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">File Size (MB)</label>
                                                                    <input type="number" 
                                                                           class="form-control" 
                                                                           name="modules[{{ $moduleIndex + 1 }}][contents][{{ $contentIndex + 1 }}][file_size]" 
                                                                           value="{{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.file_size', $content->file_size ?? '') }}"
                                                                           step="0.1" 
                                                                           min="0.1">
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Duration (minutes)</label>
                                                            <input type="number" 
                                                                   class="form-control" 
                                                                   name="modules[{{ $moduleIndex + 1 }}][contents][{{ $contentIndex + 1 }}][duration]" 
                                                                   value="{{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.duration', $content->duration ?? '') }}"
                                                                   min="1">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Order</label>
                                                            <input type="number" 
                                                                   class="form-control" 
                                                                   name="modules[{{ $moduleIndex + 1 }}][contents][{{ $contentIndex + 1 }}][order]" 
                                                                   value="{{ old('modules.' . ($moduleIndex + 1) . '.contents.' . ($contentIndex + 1) . '.order', $content->order ?? ($contentIndex + 1)) }}" 
                                                                   min="1">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Update Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
  <script>
      window.courseModuleData = {
          moduleCount: {{ count($course->modules ?? []) }},
          contentCounts: @json($course->modules->mapWithKeys(function($m, $index) {
              return [$index + 1 => $m->contents->count()];
          }))
      };
  </script>

  {{-- Load external JS --}}
  <script src="{{ asset('js/edit.js') }}"></script>

@endpush