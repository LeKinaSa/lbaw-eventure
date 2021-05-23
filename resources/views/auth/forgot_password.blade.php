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
                Enter your account's email and we will send you a link to reset your password.
            </p>

            <form method="POST" class="d-flex flex-column justify-content-center mb-3" action="{{ route('sign-in') }}">
                @csrf

                <div class="mb-2">
                    <label for="email" class="form-label">Email address *</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <input type="submit" class="btn btn-primary" value="Send Email">
            </form>
        </div>
    </div>
</div>
@endsection
