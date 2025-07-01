<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Course Management') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/design_website.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form_desgin.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary kg-header">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center text-dark" href="#">
                <i class="fas fa-graduation-cap me-2"></i>
                KnowledgeHub
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon color-dark"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                @auth
                  <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-link text-dark"> {{ auth()->user()->name }}</li>
                    <li class="nav-item">
                     <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="nav-link text-dark">Logout</button>
                      </form>
                    </li>
                  </ul>  
               @else
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{route('login')}}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark ms-2 px-3" href="{{route('signup')}}">Signup</a>
                    </li>
                </ul>
                 @endauth
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>