@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if(auth()->check())
                        <h4>Welcome, {{ auth()->user()->name }}!</h4>
                        <p>Your email <strong>{{ auth()->user()->email }}</strong> has been verified.</p>
                        
                        @if(auth()->user()->email_verified_at)
                            <p>Email verified at: {{ auth()->user()->email_verified_at->format('F j, Y g:i A') }}</p>
                        @else
                            <p>Email not yet verified.</p>
                        @endif
                        
                        <div class="mt-3">
                            <a href="{{ route('logout') }}" class="btn btn-danger"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </div>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        <p>You are not logged in.</p>
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection