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
                The email was sent.
            </p>
            
            <p class="text-center">
                <a href="{{ url('/') }}" role="button" class="btn btn-primary text-center">Back to Homepage</a>
            </p>
        </div>
    </div>
</div>
@endsection
