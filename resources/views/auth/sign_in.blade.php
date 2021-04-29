@extends('layouts.app')

@section('content')
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sign in</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4 bg-light p-3">
            <h1 class="text-center">Sign in</h1>

            <form method="POST" class="d-flex flex-column justify-content-center mb-3" action="{{ route('sign-in') }}">
                {{ csrf_field() }}

                <div class="mb-2">
                    <label for="username" class="form-label">Username *</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                    @error ('username')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label for="password" class="form-label">Password *</label>
                        <a class="text-primary" href="recover_password.php">Forgot your password?</a>
                    </div>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error ('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <input type="submit" class="btn btn-primary" value="Sign in">
            </form>

            <div class="d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-primary mb-3">
                    Sign in with <img src="../assets/google.png" class="google" alt="Google">
                </button>
                
                <span class="text-center">New to Eventure? <a class="text-primary" href={{ route('sign-up') }}> Sign up</a> now!</span>
            </div>
        </div>
    </div>
</div>
{{-- <form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <label for="email">E-mail</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <label for="password" >Password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif

    <label>
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
    </label>

    <button type="submit">
        Login
    </button>
    <a class="button button-outline" href="{{ route('register') }}">Register</a>
</form> --}}
@endsection
