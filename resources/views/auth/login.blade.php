@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="kg-style">
                <div>
                    <h4 class="mt-3 text-white">Login</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-feild mt-5">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="off" class="input">
                             <label for="email" class="user-label">Email</label>
                        </div>
                        
                        <div class="form-feild mt-3">
                            <input type="password" id="password" name="password" required autocomplete="off" class="input">
                             <label for="password" class="user-label">Password</label>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-3">
                        <p class="text-white">Don't have an account? <a href="{{ route('signup') }}">Sign up here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
