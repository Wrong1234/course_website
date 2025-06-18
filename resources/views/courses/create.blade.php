@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="fas fa-plus-circle"></i> Create New Course</h1>
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

            <form id="courseForm" action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
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
                                       value="{{ old('title') }}" 
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
                                        placeholder="old('category') ?: 'Select Category'"
                                        required>
                                    <option value="">Select Category</option>
                                    <option value="programming" {{ old('category') == 'programming' ? 'selected' : '' }}>Programming</option>
                                    <option value="design" {{ old('category') == 'design' ? 'selected' : '' }}>Design</option>
                                    <option value="business" {{ old('category') == 'business' ? 'selected' : '' }}>Business</option>
                                    <option value="marketing" {{ old('category') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
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
                                  required>{{ old('description') }}</textarea>
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
                                       value="{{ old('duration') }}" 
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
                                       value="{{ old('price') }}" 
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
                        <!-- Modules will be dynamically added here -->
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Create Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let moduleCount = 0;
    let contentCounts = {};

    // Add Module
    $('#addModuleBtn').click(function() {
        addModule();
    });

    function addModule() {
        moduleCount++;
        contentCounts[moduleCount] = 0;
        
        const moduleHtml = `
            <div class="module-card" data-module-id="${moduleCount}">
                <div class="module-header">
                    <h5 class="mb-0">
                        <i class="fas fa-folder"></i> Module ${moduleCount}
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
                                   name="modules[${moduleCount}][title]" 
                                   required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Order</label>
                            <input type="number" 
                                   class="form-control" 
                                   name="modules[${moduleCount}][order]" 
                                   value="${moduleCount}" 
                                   min="1">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Module Description</label>
                        <textarea class="form-control" 
                                  name="modules[${moduleCount}][description]" 
                                  rows="2"></textarea>
                    </div>
                    
                    <!-- Content Section -->
                    <div class="nested-structure">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6><i class="fas fa-file-alt"></i> Module Content</h6>
                            <button type="button" class="btn btn-sm btn-info add-content" data-module-id="${moduleCount}">
                                <i class="fas fa-plus"></i> Add Content
                            </button>
                        </div>
                        
                        <div class="content-container" data-module-id="${moduleCount}">
                            <!-- Content items will be added here -->
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('#modulesContainer').append(moduleHtml);
        updateModuleNumbers();
    }

    // Remove Module
    $(document).on('click', '.remove-module', function() {
        if (confirm('Are you sure you want to remove this module and all its content?')) {
            $(this).closest('.module-card').remove();
            updateModuleNumbers();
        }
    });

    // Add Content
    $(document).on('click', '.add-content', function() {
        const moduleId = $(this).data('module-id');
        addContent(moduleId);
    });

    function addContent(moduleId) {
        contentCounts[moduleId]++;
        const contentId = contentCounts[moduleId];
        
        const contentHtml = `
            <div class="content-item" data-content-id="${contentId}">
                <div class="content-header">
                    <span><i class="fas fa-file"></i> Content ${contentId}</span>
                    <button type="button" class="btn-remove remove-content" title="Remove Content">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Content Title <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control content-title" 
                               name="modules[${moduleId}][contents][${contentId}][title]" 
                               required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Content Type <span class="text-danger">*</span></label>
                        <select class="form-select content-type" 
                                name="modules[${moduleId}][contents][${contentId}][type]" 
                                required>
                            <option value="">Select Type</option>
                            <option value="text">Text</option>
                            <option value="video">Video</option>
                            <option value="image">Image</option>
                            <option value="link">Link</option>
                            <option value="file">File</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Content Description</label>
                    <textarea class="form-control" 
                              name="modules[${moduleId}][contents][${contentId}][description]" 
                              rows="3"></textarea>
                </div>
                
                <div class="content-specific-fields">
                    <!-- Dynamic fields based on content type will appear here -->
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Duration (minutes)</label>
                        <input type="number" 
                               class="form-control" 
                               name="modules[${moduleId}][contents][${contentId}][duration]" 
                               min="1">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Order</label>
                        <input type="number" 
                               class="form-control" 
                               name="modules[${moduleId}][contents][${contentId}][order]" 
                               value="${contentId}" 
                               min="1">
                    </div>
                </div>
            </div>
        `;
        
        $(`.content-container[data-module-id="${moduleId}"]`).append(contentHtml);
    }

    // Remove Content
    $(document).on('click', '.remove-content', function() {
        if (confirm('Are you sure you want to remove this content?')) {
            $(this).closest('.content-item').remove();
        }
    });

    // Content Type Change Handler
    $(document).on('change', '.content-type', function() {
        const contentType = $(this).val();
        const contentItem = $(this).closest('.content-item');
        const specificFields = contentItem.find('.content-specific-fields');
        const moduleId = $(this).closest('.module-card').data('module-id');
        const contentId = contentItem.data('content-id');
        
        let fieldsHtml = '';
        
        switch(contentType) {
            case 'text':
                fieldsHtml = `
                    <div class="mb-3">
                        <label class="form-label">Text Content</label>
                        <textarea class="form-control" 
                                  name="modules[${moduleId}][contents][${contentId}][content]" 
                                  rows="5" 
                                  placeholder="Enter your text content here..."></textarea>
                    </div>
                `;
                break;
                
            case 'video':
                fieldsHtml = `
                    <div class="mb-3">
                        <label class="form-label">Video URL</label>
                        <input type="url" 
                               class="form-control" 
                               name="modules[${moduleId}][contents][${contentId}][url]" 
                               placeholder="https://youtube.com/watch?v=...">
                    </div>
                `;
                break;
                
            case 'image':
                fieldsHtml = `
                    <div class="mb-3">
                        <label class="form-label">Image URL</label>
                        <input type="url" 
                               class="form-control" 
                               name="modules[${moduleId}][contents][${contentId}][url]" 
                               placeholder="https://example.com/image.jpg">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alt Text</label>
                        <input type="text" 
                               class="form-control" 
                               name="modules[${moduleId}][contents][${contentId}][alt_text]" 
                               placeholder="Description of the image">
                    </div>
                `;
                break;
                
            case 'link':
                fieldsHtml = `
                    <div class="mb-3">
                        <label class="form-label">Link URL</label>
                        <input type="url" 
                               class="form-control" 
                               name="modules[${moduleId}][contents][${contentId}][url]" 
                               placeholder="https://example.com">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="modules[${moduleId}][contents][${contentId}][external]" 
                               value="1">
                        <label class="form-check-label">Open in new tab</label>
                    </div>
                `;
                break;
                
            case 'file':
                fieldsHtml = `
                    <div class="mb-3">
                        <label class="form-label">File URL or Path</label>
                        <input type="text" 
                               class="form-control" 
                               name="modules[${moduleId}][contents][${contentId}][file_path]" 
                               placeholder="path/to/file.pdf">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File Size (MB)</label>
                        <input type="number" 
                               class="form-control" 
                               name="modules[${moduleId}][contents][${contentId}][file_size]" 
                               step="0.1" 
                               min="0.1">
                    </div>
                `;
                break;
        }
        
        specificFields.html(fieldsHtml);
    });

    function updateModuleNumbers() {
        $('#modulesContainer .module-card').each(function(index) {
            const newNumber = index + 1;
            $(this).find('.module-header h5').html(`<i class="fas fa-folder"></i> Module ${newNumber}`);
        });
    }

    // Form Validation
    $('#courseForm').submit(function(e) {
        let isValid = true;
        let errorMessage = '';

        // Check if at least one module exists
        if ($('.module-card').length === 0) {
            isValid = false;
            errorMessage += 'Please add at least one module to the course.\n';
        }

        // Check each module has a title
        $('.module-title').each(function() {
            if ($(this).val().trim() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Check each content has required fields
        $('.content-title').each(function() {
            if ($(this).val().trim() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        $('.content-type').each(function() {
            if ($(this).val() === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            if (errorMessage) {
                alert(errorMessage);
            }
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 100
            }, 500);
        }
    });

    // Add first module by default
    addModule();
});
</script>
@endpush