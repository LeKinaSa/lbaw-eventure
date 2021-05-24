@extends('layouts.app')

@section('content')
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Password Recovery</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4 bg-light p-3">
            <h1 class="text-center">Password Recovery</h1>

            <p class="pt-2 pb-2 text-center">
                Enter a new password for your account.
            </p>

            <form method="POST" class="d-flex flex-column justify-content-center mb-3" action="{{ route('password.update') }}">
                @csrf

                <div class="mb-2">
                    <label for="email" class="form-label">Email address *</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    @error ('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label">Password *</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error ('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="passwordConfirmation" class="form-label">Confirm your Password *</label>
                    <input type="password" class="form-control" id="passwordConfirmation" name="password_confirmation" required>
                    @error ('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <input type="hidden" id="token" value="{{ $token }}">

                <input type="submit" class="btn btn-primary" value="Recover Password">
            </form>
        </div>
    </div>
</div>
@endsection
