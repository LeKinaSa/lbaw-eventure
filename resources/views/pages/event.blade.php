@extends('layouts.app')

@php
$startDate = is_null($event->start_date) ? NULL : (new DateTime($event->start_date))->format('j M, Y H:i');
$endDate = is_null($event->end_date) ? NULL : (new DateTime($event->end_date))->format('j M, Y H:i');
@endphp

@section('content')
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $event->title }}</li>
        </ol>
    </nav>

    <h1 class="text-center mb-3">
        <i class="text-danger {{ $event->cancelled ? "fa fa-ban" : "" }}" title="Event Cancelled" aria-label="Event Cancelled"></i>
        {{ $event->title }}
        <i class="fa {{ $event->visibility === 'Public' ? "fa-globe" : "fa-lock" }}" title="{{ $event->visibility }} Event" aria-label="{{ $event->visibility }}"></i>
    </h1>

    <div class="row mb-3">
        <div class="col-md-5 d-flex align-items-center justify-content-center">
            <img src="{{ is_null($event->picture) ? asset('img/event_default.png') : 'data:image/jpeg;base64, ' . $event->picture }}" class="img-fluid rounded" alt="Event image">
        </div>
        <div class="col-md-7 p-3">
            <div class="d-flex justify-content-between">
                <div class="d-flex gap-2 align-items-center">
                    <a href="#" role="button" class="btn btn-primary">Results <i class="fa fa-trophy"></i></a>
                    @if (Auth::id() === $event->id_organizer)
                    <a href="{{ route('events.event.invitations', ['id' => $event->id]) }}" role="button" class="btn btn-primary">Invitations <i class="fa fa-envelope"></i></a>
                    <a href="{{ route('events.event.participants', ['id' => $event->id]) }}" role="button" class="btn btn-primary">Participants <i class="fa fa-users"></i></a>
                    @endif
                </div>
                <div class="d-flex align-items-center p-2">
                    @if (Auth::id() === $event->id_organizer)
                    <a class="btn btn-secondary" href="{{ route('events.event.edit', ['id' => $event->id]) }}"><i class="fa fa-pencil"></i></a>
                    @endif
                    <div id="requestToJoin" class="d-flex gap-2 align-items-center">
                        @include('partials.event_request_to_join')
                    </div>
                </div>
            </div>

            <hr>
            
            @if ($event->cancelled)
            <p class="text-danger">
                Event Cancelled
            </p>
            @endif
            <p>
                {{ $event->description }}
            </p>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-2">
                        <h5>Start date</h5>
                        <div class="border border-2 rounded px-3 py-2">
                            <i class="fa fa-calendar"></i> {{ is_null($startDate) ? "Not defined" : $startDate }} 
                        </div>
                    </div>
                    <div class="mb-2">
                        <h5>Type</h5>
                        <div class="border border-2 rounded px-3 py-2">
                            @php use App\Models\Event; @endphp
                            {{ Event::FORMATTED_TYPES[$event->type] }}
                        </div>
                    </div>
                    <div class="mb-2">
                        <h5>Category</h5>
                        <div class="border border-2 rounded px-3 py-2">
                            {{ $event->category->name }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-2">
                        <h5>End date</h5>
                        <div class="border border-2 rounded px-3 py-2">
                            <i class="fa fa-calendar"></i> {{ is_null($endDate) ? "Not defined" : $endDate }}
                        </div>
                    </div>
                    <div class="mb-2">
                        <h5>Location</h5>
                        <div class="border border-2 rounded px-3 py-2">
                            <i class="fa fa-map-marker"></i> {{ is_null($event->location) ? "Not defined" : $event->location }}
                        </div>
                    </div>
                    <div class="mb-2">
                        <h5>Participants</h5>
                        <div class="border border-2 rounded px-3 py-2">
                            {{ $event->participants()->count() . (is_null($event->max_attendance) ? "" : " / " . $event->max_attendance) }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tags are disabled for now
            <div class="row">
                <h5>Tags</h5>
                <div class="d-flex flex-wrap gap-2">
                    <span class="text-white d-inline-flex bg-primary rounded px-2 py-1 gap-1">chess</span>
                    <span class="text-white d-inline-flex bg-primary rounded px-2 py-1 gap-1">friendly</span>
                    <span class="text-white d-inline-flex bg-primary rounded px-2 py-1 gap-1">for beginners</span>
                    <span class="text-white d-inline-flex bg-primary rounded px-2 py-1 gap-1">blitz chess</span>
                    <span class="text-white d-inline-flex bg-primary rounded px-2 py-1 gap-1">learning</span>
                </div>
            </div>
            --}}
        </div>
    </div>

    <nav>
        <ul class="nav nav-tabs">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="commentsLabel" data-bs-toggle="tab" data-bs-target="#commentsTab" type="button" role="tab" aria-controls="commentsTab" aria-selected="true">
                    Comments
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pollsLabel" data-bs-toggle="tab" data-bs-target="#pollsTab" type="button" role="tab" aria-controls="pollsTab" aria-selected="false">
                    Polls
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="filesLabel" data-bs-toggle="tab" data-bs-target="#filesTab" type="button" role="tab" aria-controls="filesTab" aria-selected="false">
                    Files
                </button>
            </li>
        </ul>
    </nav>

    <div class="tab-content" id="tabContent">
        <div class="tab-pane fade show active p-3" id="commentsTab" role="tabpanel" aria-labelledby="commentsLabel">
            @if (App\Policies\CommentPolicy::create(Auth::user(), $event))
            <div class="mb-3">
                <p class="mb-2 text-danger" id="commentsError"></p>
                <h5>Write a comment</h5>
                <form method="POST" action="{{ route('api.events.event.comments.new', ['id' => $event->id]) }}" class="form-comment-post">
                    @csrf
                    <textarea class="form-control mb-2" name="text" placeholder="You can use comments to ask questions or make suggestions..." maxlength="{{ App\Models\Comment::MAX_LENGTH }}" required></textarea>
                    <input type="submit" class="btn btn-primary" value="Post">
                </form>
            </div>
            @endif

            <section id="comments">
                <h4><span id="commentCount">{{ $event->comments()->count() }}</span> comments</h4>
                <div class="mt-3">
                    @if (array_key_exists(0, $commentsByParent))
                        @foreach ($commentsByParent[0] as $comment)
                            @include('partials.comment_thread', ['comment' => $comment, 'commentsByParent' => $commentsByParent])
                        @endforeach
                    @endif
                </div>
            </section>
        </div>
        <div class="tab-pane fade p-3" id="pollsTab" role="tabpanel" aria-labelledby="pollsLabel">
            @if (App\Policies\PollPolicy::create(Auth::user(), $event))
            <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#createPollModal" id="createPollModalClose">Create poll</button>

            <div class="modal fade" id="createPollModal" tabindex="-1" aria-labelledby="createPollLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="createPollLabel">Create poll</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="createPollForm" method="POST" action="{{ route('api.events.event.polls.new', ['id' => $event->id]) }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="pollTitle" class="h5 form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="createPollQuestion" name="question" required>
                                </div>

                                <h5>Options <span class="text-danger">*</span></h5>
                                <ul id="createPollOptions" class="list-unstyled d-flex flex-column gap-1">
                                    <li class="input-group">
                                        <input type="text" class="form-control" required>
                                    </li>
                                    <li class="input-group">
                                        <input type="text" class="form-control" required>
                                    </li>
                                </ul>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="newPollOption" placeholder="New option" aria-label="Name">
                                    <button type="button" class="btn btn-success" id="addPollOption" aria-label="Add option"><i class="fa fa-plus"></i></button>
                                </div>

                                <p class="text-danger" id="createPollError"></p>

                                <div class="modal-footer px-0">
                                    <input type="submit" class="btn btn-primary" value="Create">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <section id="polls" class="row mt-3">
                <p class="text-danger" id="pollError"></p>
                <p class="text-danger" id="deletePollError"></p>
                @foreach($event->polls()->get() as $poll)
                    @include('partials.poll', ['poll' => $poll])
                @endforeach
            </section>
        </div>
        <div class="tab-pane fade p-3" id="filesTab" role="tabpanel" aria-labelledby="filesLabel">
            @if (App\Policies\FilePolicy::create(Auth::user(), $event))
            <form enctype="multipart/form-data" method="POST" action="{{ route('events.event.files.new', ['id' => $event->id]) }}" class="mb-3" id="uploadFileForm">
                @csrf
                <div class="input-group">
                    <input type="file" class="form-control" name="file" required>
                    <input type="submit" class="btn btn-primary" value="Upload file">
                </div>
            </form>
            @error ('file')
            <p class="text-danger mx-1">{{ $message }}</p>
            @enderror
            @endif
            
            <section id="files" class="d-flex flex-wrap gap-2">
                @foreach($event->files()->get() as $file)
                    @include('partials.file', ['file' => $file])
                @endforeach
            </section>
        </div>
    </div>
</div>
@endsection
