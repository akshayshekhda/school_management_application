<!-- resources/views/auth/admin-login.blade.php -->
@extends('layouts.app')

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-logo">
            <h1>School Management</h1>
        </div>
        @include('auth.partials.login-toggle')
        <div class="auth-card">
            <div class="card-header">
                <h4>Admin Login</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf
                    <div class="auth-form-group">
                        <label for="email" class="auth-label">Email Address</label>
                        <input id="email" type="email" 
                            class="auth-input @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" 
                            required autocomplete="email" autofocus
                            placeholder="Enter your email">

                        @error('email')
                        <span class="auth-error" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <div class="auth-form-group">
                        <label for="password" class="auth-label">Password</label>
                        <input id="password" type="password"
                            class="auth-input @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password"
                            placeholder="Enter your password">

                        @error('password')
                        <span class="auth-error" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <div class="auth-form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>

                    <div class="auth-form-group mb-0">
                        <button type="submit" class="auth-btn">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection