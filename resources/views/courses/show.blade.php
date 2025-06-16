@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>{{ $course->title }}</h1>
                <div>
                    {{-- <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Course
                    </a> --}}
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Courses
                    </a>
                </div>
            </div>

            <!-- Course Information -->
            <div class="course-section mb-4">
                <div class="row">
                    <div class="col-md-8">
                        <h3>Course Description</h3>
                        <p>{{ $course->description }}</p>
                    </div>
                    <div class="col-md-4">
                        <h5>Course Details</h5>
                        <ul class="list-unstyled">
                            <li><strong>Category:</strong> {{ ucfirst($course->category) }}</li>
                            @if($course->duration)
                                <li><strong>Duration:</strong> {{ $course->duration }} hours</li>
                            @endif
                            @if($course->price)
                                <li><strong>Price:</strong> ${{ number_format($course->price, 2) }}</li>
                            @endif
                            <li><strong>Modules:</strong> {{ $course->modules->count() }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Modules -->
            <div class="modules-section">
                <h3><i class="fas fa-layer-group"></i> Course Modules</h3>
                
                @forelse($course->modules->sortBy('order') as $module)
                    <div class="module-card">
                        <div class="module-header">
                            <h5 class="mb-0">
                                <i class="fas fa-folder"></i> {{ $module->title }}
                            </h5>
                        </div>
                        
                        <div class="p-3">
                            @if($module->description)
                                <p class="text-muted">{{ $module->description }}</p>
                            @endif
                            
                            <!-- Content Items -->
                            @if($module->contents->count() > 0)
                                <div class="nested-structure">
                                    <h6><i class="fas fa-file-alt"></i> Module Content</h6>
                                    
                                    @foreach($module->contents->sortBy('order') as $content)
                                        <div class="content-item">
                                            <div class="content-header">
                                                <span>
                                                    <i class="fas fa-file"></i> {{ $content->title }}
                                                    <span class="badge bg-secondary ms-2">{{ ucfirst($content->type) }}</span>
                                                </span>
                                            </div>
                                            
                                            @if($content->description)
                                                <p>{{ $content->description }}</p>
                                            @endif
                                            
                                            @if($content->duration)
                                                <small class="text-muted">
                                                    <i class="fas fa-clock"></i> {{ $content->duration }} minutes
                                                </small>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No content added to this module yet.</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="text-muted">No modules added to this course yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection