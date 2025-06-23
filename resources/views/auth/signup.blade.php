@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="kg-style">
                <div>
                    <h4 class="mt-3 text-white">Sign Up</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('signup') }}">
                        @csrf
                        <div class="form-feild mt-5">
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="off" class="input">
                             <label for="name" class="user-label">Name</label>
                        </div>
                        <div class="form-feild">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="off" class="input">
                            <label for="email" class="user-label">Email address</label>
                        </div>
                        <div class="form-feild">
                            <input type="password" id="password" name="password" required autocomplete="off" class="input">
                            <label for="password" class="user-label">Password</label>
                        </div>
                        <div class="form-feild">
                           <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="off" class="input">
                             <label for="password_confirmation" class="user-label">Confirm Password</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Sign Up</button>
                        </div>
                    </form>

                    <div class="text-center mt-3 text-white">
                        <small>
                            Already have an account?
                            <a href="{{ route('login') }}">Login here</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
