@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="fas fa-list"></i> All Courses</h1>
                <a href="{{ route('courses.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Course
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                @forelse($courses as $course)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">{{ $course->title }}</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                                <p class="text-muted">
                                    <i class="fas fa-tag"></i> {{ ucfirst($course->category) }}
                                </p>
                                @if($course->duration)
                                    <p class="text-muted">
                                        <i class="fas fa-clock"></i> {{ $course->duration }} hours
                                    </p>
                                @endif
                                @if($course->price)
                                    <p class="text-success">
                                        <i class="fas fa-dollar-sign"></i> ${{ number_format($course->price, 2) }}
                                    </p>
                                @endif
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">
                                    <i class="fas fa-layer-group"></i> {{ $course->modules_count ?? 0 }} modules
                                </small>
                                <div class="btn-group float-end">
                                    <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <h3 class="text-muted">No courses found</h3>
                            <p class="text-muted">Start by creating your first course!</p>
                            <a href="{{ route('courses.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Course
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection