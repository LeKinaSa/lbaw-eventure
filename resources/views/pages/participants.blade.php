@extends('layouts.app')
@section('content')
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a class="text-primary" href="{{ route('events.event', ['id' => $event->id]) }}">{{ $event->title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Participations</li>
        </ol>
    </nav>

    <h1 class="text-center">Participants</h1>
    
    <section id="participants" class="p-3">
        <h4>Accepted</h4>
        <div class="d-flex flex-wrap mt-2 gap-3" id="join-requests">
            @foreach ($event->participants()->get() as $user)
                @include('partials.participant', ['user' => $user])
            @endforeach
        </div>
    </section>

    <section id="participants" class="p-3">
        <h4>Rejected</h4>
        <div class="d-flex flex-wrap mt-2 gap-3" id="join-requests">
            @foreach ($event->rejectedParticipants()->get() as $user)
                @include('partials.participant', ['user' => $user])
            @endforeach
        </div>
    </section>
</div>
@endsection
