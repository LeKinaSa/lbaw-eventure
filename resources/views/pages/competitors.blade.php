@extends('layouts.app')
@section('content')
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a class="text-primary" href="{{ route('events.event', ['id' => $event->id]) }}">{{ $event->title }}</a></li>
            <li class="breadcrumb-item"><a class="text-primary" href="{{ route('events.event.matches', ['id' => $event->id]) }}">Results</a></li>
            <li class="breadcrumb-item active" aria-current="page">Competitors</li>
        </ol>
    </nav>

    <h1 class="text-center mb-4">Competitors</h1>

    <ul class="list-unstyled d-flex flex-column gap-1" id="competitors">
        @foreach($competitors as $competitor)
            @include('partials.competitor', ['competitor' => $competitor])
        @endforeach
    </ul>

    @can('update', $event)
    <form method="POST" class="py-3" action="{{ route('api.events.event.competitors.new', ['id' => $event->id]) }}" id="addCompetitorForm">
        @csrf
        <h5 class="mx-1">Add competitor</h5>
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Name" aria-label="Name" name="name" required>
            <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
        </div>
        <p class="mt-2 mx-1 text-danger" id="addCompetitorError"></p>
    </form>
    @endcan
</div>
@endsection
