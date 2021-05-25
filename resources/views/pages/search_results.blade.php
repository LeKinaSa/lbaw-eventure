@extends('layouts.app')

@php
use App\Models\Event;
@endphp
@section('content')
<div class="container p-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Search results</li>
        </ol>
    </nav>

    <div class="row g-md-5">
        <section class="col-md-3 p-3 bg-light" id="searchFilters">
            <h4 class="text-center">Filters</h4>

            <div class="mb-3">
                <label for="startDate" class="h5 form-label">From</label>
                <input class="form-control" id="startDate" name="startDate" type="date">
            </div>

            <div class="mb-3">
                <label for="endDate" class="h5 form-label">To</label>
                <input class="form-control" id="endDate" name="endDate" type="date">
            </div>

            <div class="mb-3" id="typeCheckboxes">
                <h5>Type</h5>
                @foreach(Event::FORMATTED_TYPES as $type => $formatted)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $type }}" id="type{{ $type }}" name="type{{ $type }}">
                    <label class="form-check-label" for="type{{ $type }}">{{ $formatted }}</label>
                </div>
                @endforeach
            </div>

            <!-- TODO: searching with tags
            <div class="mb-3">
                <label for="tags" class="h5 form-label">Tags</label>
                <input type="text" class="form-control">
            </div>
            
            <div id="tags" class="d-flex flex-wrap gap-2 mb-3">
                <span class="text-white d-inline-flex bg-primary rounded px-2 py-1 gap-1">
                    chess
                    <button type="button" class="btn-close btn-close-white"></button>
                </span>
                <span class="text-white d-inline-flex bg-primary rounded px-2 py-1 gap-1">
                    friendly
                    <button type="button" class="btn-close btn-close-white"></button>
                </span>
                <span class="text-white d-inline-flex bg-primary rounded px-2 py-1 gap-1">
                    for beginners
                    <button type="button" class="btn-close btn-close-white"></button>
                </span>
            </div>
            -->

            <div class="mb-3">
                <label for="category" class="h5 form-label">Category</label>
                <select class="form-select" id="category" name="category">
                    <option value="" selected>Any</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </section>

        <section class="col-md-9 pt-3">
            <h3 class="text-center">
                Search results
                <div class="spinner-border text-primary" id="searchResultsSpinner" role="status" aria-label="Loading..." aria-hidden="true" hidden></div>
            </h3>
            <div id="searchResults" class="d-flex flex-column gap-2">
                @include('partials.search_results')
            </div>
        </section>
    </div>
</div>
@endsection