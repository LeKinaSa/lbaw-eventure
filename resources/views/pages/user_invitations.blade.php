
@extends('layouts.app')

@section('content')
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a class="text-primary" href="{{ route('users.profile', ['username' => $user->username]) }}">Profile</a></li>
            <li class="breadcrumb-item active" aria-current="page">Your invitations</li>
        </ol>
    </nav>

    <section id="invitations" class="mt-2">
        <h1 class="text-center">Your invitations</h1>

        <div class="d-flex flex-wrap gap-3">
            @foreach (Auth::user()->invitations()->get() as $event)
                @include ('partials.user_invitation', ['event' => $event])
            @endforeach
        </div>
    </div>
</div>
@endsection
