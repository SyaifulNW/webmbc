@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #4e73df, #1cc88a);
        min-height: 100vh;
    }
    .card {
        border-radius: 20px;
        box-shadow: 0px 8px 25px rgba(0,0,0,0.15);
    }
    .card-header {
        background: transparent;
        border-bottom: none;
        text-align: center;
        font-size: 1.5rem;
        font-weight: bold;
        color: #4e73df;
    }
    .btn-primary {
        background-color: #4e73df;
        border: none;
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: bold;
    }
    .btn-primary:hover {
        background-color: #2e59d9;
    }
    .form-control {
        border-radius: 50px;
        padding: 12px 20px;
    }
    .form-check-label {
        font-size: 0.9rem;
    }
    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
</style>

<div class="login-wrapper">
    
    <div class="col-md-5">
        <div class="card p-4">
            <div class="card-header">{{ __('Login') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
                        @error('email')
                            <span class="invalid-feedback d-block mt-1">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" placeholder="Password" required>
                        @error('password')
                            <span class="invalid-feedback d-block mt-1">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                    </div>

                    {{-- Button --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="text-decoration-none" href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
