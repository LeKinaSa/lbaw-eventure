@extends('layouts.app')

@section('content')
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">User management</li>
        </ol>
    </nav>

    <section id="suspensions" class="mb-4">
        <h3>Suspensions</h3>

        <ul class="list-group">
            @each('partials.suspension', $suspensions, 'suspension')
        </ul>
    </section>

    <section id="bannedUsers">
        <h3>Banned users</h3>

        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-md-flex gap-3 align-items-center">
                    <div class="mb-1">
                        <h5 class="card-title mb-0">David Horton</h5>
                        <h6 class="text-primary mb-0">@davidthehorton</h6>
                    </div>

                    <ul class="list-unstyled mb-0">
                        <li class="card-text"><b>Ban date:</b> 5 January 2021</li>
                        <li class="card-text"><b>Motive:</b> repeated offensive behaviour</li>
                    </ul>
                </div>

                <div class="d-flex gap-1 flex-column">
                    <button class="btn btn-danger" aria-label="Remove"><i class="fa fa-remove"></i></button>
                </div>
            </li>
        </ul>
    </section>
</div>
@endsection
