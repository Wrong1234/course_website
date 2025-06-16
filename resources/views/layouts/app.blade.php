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
    
    <style>
        .module-card {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 20px;
            background-color: #f8f9fa;
        }
        
        .content-item {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 15px;
            background-color: white;
            padding: 15px;
        }
        
        .module-header {
            background-color: #6c757d;
            color: white;
            padding: 10px 15px;
            border-radius: 6px 6px 0 0;
            display: flex;
            justify-content: between;
            align-items: center;
        }
        
        .content-header {
            background-color: #17a2b8;
            color: white;
            padding: 8px 12px;
            border-radius: 4px 4px 0 0;
            margin: -15px -15px 15px -15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .btn-remove {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        
        .btn-add {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .nested-structure {
            margin-left: 20px;
        }
        
        .course-section {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        
        .alert-error {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap"></i> Course Management
            </a>
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