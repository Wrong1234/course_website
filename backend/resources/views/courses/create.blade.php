
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

            {{-- Robust error handling --}}
            @php
                $hasErrors = false;
                $errorMessages = [];
                
                // Check if $errors is a ViewErrorBag object
                if (isset($errors) && is_object($errors) && method_exists($errors, 'any') && $errors->any()) {
                    $hasErrors = true;
                    $errorMessages = $errors->all();
                }
                // Check if $errors is an array with content
                elseif (isset($errors) && is_array($errors) && count($errors) > 0) {
                    $hasErrors = true;
                    // Flatten array errors
                    foreach ($errors as $key => $value) {
                        if (is_array($value)) {
                            $errorMessages = array_merge($errorMessages, $value);
                        } else {
                            $errorMessages[] = $value;
                        }
                    }
                }
                // Check session for errors
                elseif (session()->has('errors')) {
                    $sessionErrors = session('errors');
                    if (is_object($sessionErrors) && method_exists($sessionErrors, 'any') && $sessionErrors->any()) {
                        $hasErrors = true;
                        $errorMessages = $sessionErrors->all();
                    } elseif (is_array($sessionErrors)) {
                        $hasErrors = true;
                        $errorMessages = $sessionErrors;
                    }
                }
            @endphp

            @if($hasErrors && count($errorMessages) > 0)
                <div class="alert alert-danger">
                    <h5><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h5>
                    <ul class="mb-0">
                        @foreach($errorMessages as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
             {{-- <pre>
                 {{ dd($errors) }}
            </pre> --}}
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
    <script src="{{ asset('js/create.js') }}"></script>
@endpush