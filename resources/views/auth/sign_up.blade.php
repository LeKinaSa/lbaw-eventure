@extends('layouts.app')

@section('content')
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sign up</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4 bg-light p-3">
            <h1 class="text-center">Sign up</h1>

            <form method="POST" class="d-flex flex-column justify-content-center mb-3" action="{{ route('sign-up') }}">
                {{ csrf_field() }}

                <div class="mb-2">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-2">
                    <label for="username" class="form-label">Username *</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-2">
                    <label for="email" class="form-label">Email address *</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label">Password *</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="passwordConfirmation" class="form-label">Confirm your Password *</label>
                    <input type="password" class="form-control" id="passwordConfirmation" name="password_confirmation" required>
                </div>

                <input type="submit" class="btn btn-primary" value="Create accout">
            </form>

            <div class="d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-primary mb-3">
                    Sign up with <img src="../assets/google.png" class="google" alt="Google logo">
                </button>

                <span class="text-center">Already have an account? <a class="text-primary" href="{{ route('sign-in') }}"> Sign in</a> now!</span>
            </div>
        </div>
    </div>
</div>
{{--
<form method="POST" action="{{ route('sign-up') }}">
    {{ csrf_field() }}

    <label for="name">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    @if ($errors->has('name'))
      <span class="error">
          {{ $errors->first('name') }}
      </span>
    @endif

    <label for="email">E-Mail Address</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
    @if ($errors->has('email'))
      <span class="error">
          {{ $errors->first('email') }}
      </span>
    @endif

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
      <span class="error">
          {{ $errors->first('password') }}
      </span>
    @endif

    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" required>

    <button type="submit">
      Register
    </button>
    <a class="button button-outline" href="{{ route('sign-in') }}">Login</a>
</form>
--}}
@endsection
