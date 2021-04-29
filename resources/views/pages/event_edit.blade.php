@extends('layouts.app')

@section('content')
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ isset($event) ? "Edit" : "Create" }} Event</li>
        </ol>
    </nav>
    
    <div class="row justify-content-md-center">
        <form method="POST" class="col-md-8" action="{{ isset($event) ? route('events.event.edit', ['id' => $event->id]) : route('events.new') }}">
            {{ csrf_field() }}

            <h1 class="text-center">Create Event</h1>

            <div class="mb-3">
                <label for="title" class="h5 form-label">Name <span class="text-danger">*</span></label>
                <input type="text" id="title" name="title" class="form-control" placeholder="The full name of the event" value="{{ old('title') }}" required>
                @error ('title')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="h5 form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description" placeholder="A thorough description of the event. You should include important information such as timelines, etc." required>{{ old('description') }}</textarea>
                @error ('description')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <h5>Visibility <span class="text-danger">*</span></h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="visibilityPublic" name="visibility" value="Public" aria-describedby="visibilityPublicHelp" checked required>
                    <label for="visibilityPublic" class="form-check-label"><i class="fa fa-globe"></i> Public</label>
                    <div id="visibilityPublicHelp" class="form-text">Public events will show up in search results and users can ask to join them</div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="visibilityPrivate" name="visibility" value="Private" aria-describedby="visibilityPrivateHelp">
                    <label for="visibilityPrivate" class="form-check-label"><i class="fa fa-lock"></i> Private</label>
                    <div id="visibilityPrivateHelp" class="form-text">Private events will not show up in search results and users must be invited in order to participate</div>
                </div>
                @error ('visibility')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <h5>Type <span class="text-danger">*</span></h5>
                    
                    @php use App\Models\Event; @endphp
                    @foreach (Event::FORMATTED_TYPES as $type => $formatted)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="type{{ $type }}" name="type" value="{{ $type }}" checked required>
                            <label for="type{{ $type }}" class="form-check-label">{{ $formatted }}</label>
                        </div>
                    @endforeach

                    @error ('type')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-9">
                    <label for="location" class="h5 form-label">Address</label>
                    <input type="text" id="location" name="location" class="form-control" placeholder="Where the event will take place, if applicable" value="{{ old('location') }}">
                    @error ('location')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="startDate" class="h5 form-label">Start date</label>
                    <input type="date" class="form-control" id="startDate" name="startDate" value="{{ old('startDate') }}">
                </div>
                @error ('startDate')
                <span class="text-danger">{{ $message }}</span>
                @enderror

                <div class="col">
                    <label for="startTime" class="h5 form-label">Start time</label>
                    <input type="time" class="form-control" id="startTime" name="startTime" value="{{ old('startTime') }}">
                </div>
                @error ('startTime')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="finishDate" class="h5 form-label">Finish date</label>
                    <input type="date" class="form-control" id="finishDate" name="finishDate" value="{{ old('finishDate') }}">
                </div>
                @error ('finishDate')
                <span class="text-danger">{{ $message }}</span>
                @enderror

                <div class="col">
                    <label for="finishTime" class="h5 form-label">Finish time</label>
                    <input type="time" class="form-control" id="finishTime" name="finishTime" value="{{ old('finishTime') }}">
                </div>
                @error ('finishTime')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category" class="h5 form-label">Category <span class="text-danger">*</span></label>
                <select class="form-select" id="category" name="category">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error ('category')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- (tags are hidden for now, as they are part of a different user story)
            
            <div class="mb-3">
                <h5>Tags</h5>
                <input type="text" class="form-control mb-2" id="tagsInput">
                <div id="tags">
                    <span class="text-white d-inline-flex bg-primary rounded px-2 py-1 gap-1">
                        magic the gathering
                        <button type="button" class="btn-close btn-close-white"></button>
                    </span>
                    
                    <span class="text-white d-inline-flex bg-primary rounded px-2 py-1 gap-1">
                        trading card game
                        <button type="button" class="btn-close btn-close-white"></button>
                    </span>
                </div>
                @error ('tags')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            --}}

            <div class="mb-3">
                <div class="form-check form-switch">
                    <label for="switchLimitedAttendance" class="h5 form-check-label">Limited attendance</label>
                    <input type="checkbox" class="form-check-input" id="switchLimitedAttendance">
                </div>
                <input type="number" class="form-control" id="maxAttendance" name="maxAttendance" min="0" max="10000" value="0" hidden>
                @error ('maxAttendance')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="h5 form-label">Event image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/x-png,image/jpeg">
            </div>

            <input type="submit" class="btn btn-primary" value="Create">
        </form>
    </div>
</div>
@endsection
