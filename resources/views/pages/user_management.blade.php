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
            @each('partials.banned_user', $bannedUsers, 'bannedUser')
        </ul>
    </section>
</div>
@endsection
