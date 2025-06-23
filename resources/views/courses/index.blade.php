@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-white"><i class="fas fa-list text-white"></i> All Courses</h1>
                <a href="{{ route('courses.create') }}" class="btn btn-dark">
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
                    <div class="col-md-4 mb-4">
                        <div class="h-100 shadow-sm border-0">
                            <div class="index-card-desgin">
                                <h5 class="card-title mb-2">{{ $course->title }}</h5>
                                <p class="mb-2">{{ Str::limit($course->description, 100) }}</p>
                                <p class="mb-1">
                                    <i class="fas fa-tag text-secondary"></i>
                                    <span class="text-capitalize">{{ $course->category }}</span>
                                </p>
                                @if($course->duration)
                                    <p class="mb-1">
                                        <i class="fas fa-clock text-secondary"></i>
                                        {{ $course->duration }} hours
                                    </p>
                                @endif
                                @if($course->price)
                                    <p class="mb-1">
                                        <i class="fas fa-dollar-sign text-secondary"></i>
                                        ${{ number_format($course->price, 2) }}
                                    </p>
                                @endif
                                {{-- <div> --}}
                                    {{-- <small class="text-muted">
                                        <i class="fas fa-layer-group"></i>
                                        {{ $course->modules_count ?? 0 }} modules
                                    </small> --}}
                                    <div>
                                        <a href="{{ route('courses.show', $course) }}" class="button">
                                            {{-- <i class="fas fa-eye"></i> --}}
                                            View Course
                                        </a>
                                        {{-- <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a> --}}
                                    </div>
                                {{-- </div> --}}
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

                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        {{ $courses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection