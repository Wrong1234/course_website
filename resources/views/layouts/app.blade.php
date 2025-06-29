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
                Learning Management System
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
                     <form action="{{ route('logout') }}"     method="POST" style="display:inline;">
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

{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .btn-floating {
            border-radius: 50% !important;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
            background-color: #25D366;
            border: none;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
            transition: all 0.3s ease;
        }
        
        .btn-floating:hover {
            background-color: #20BA5A;
            transform: scale(1.1);
            color: white;
            text-decoration: none;
        }
        
        .whatsapp-error {
            opacity: 0.6;
        }
        
        .whatsapp-unavailable {
            opacity: 0.7;
        }
        
        /* Animation for floating button */
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(37, 211, 102, 0); }
            100% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
        }
        
        .btn-floating.pulse {
            animation: pulse 2s infinite;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            
            <div class="navbar-nav ms-auto">
                {{-- Global WhatsApp button in navigation
                @if(isWhatsAppAvailable())
                    <a href="{{ getWhatsAppUrl('Hello! I visited your website and would like to know more.') }}" 
                       target="_blank" 
                       class="nav-link">
                        <i class="fab fa-whatsapp text-success"></i>
                        <span class="d-none d-md-inline ms-1">Chat</span>
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <footer class="bg-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
                <div class="col-md-4 text-end">
                    {{-- Footer WhatsApp contact
                    <x-whatsapp-button 
                        message="Hello! I'd like to contact you from your website footer."
                        button-text="Contact Us"
                        button-class="btn btn-success btn-sm" />
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add pulse animation to floating WhatsApp buttons
        document.addEventListener('DOMContentLoaded', function() {
            const floatingButtons = document.querySelectorAll('.btn-floating');
            floatingButtons.forEach(button => {
                button.classList.add('pulse');
                
                // Remove pulse on hover
                button.addEventListener('mouseenter', function() {
                    this.classList.remove('pulse');
                });
                
                button.addEventListener('mouseleave', function() {
                    this.classList.add('pulse');
                });
            });
        });
    </script>
</body>
</html> --}}
