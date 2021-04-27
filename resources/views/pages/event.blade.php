@extends('layouts.app')

@section('content')
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $event->title }}</li>
        </ol>
    </nav>

    <h1 class="text-center mb-3">{{ $event->title }}</h1>

    <div class="row mb-3">
        <div class="col-md-5">
            <img src="{{ is_null($event->picture) ? asset('img/event_default.png') : 'data:image/jpeg;base64, ' . $event->picture }}" class="img-fluid rounded" alt="Event image">
        </div>
        <div class="col-md-7 p-3">
            <div class="d-flex justify-content-between mb-2">
                <div class="d-flex gap-2">
                    <a href="#" role="button" class="btn btn-primary">Results</a>
                    <a href="#" role="button" class="btn btn-primary">Invitations</a>
                </div>
                <a class="btn btn-secondary" href="{{ route('events.event.edit', ['id' => $event->id]) }}"><i class="fa fa-pencil"></i></a>
            </div>
            <hr>
            
            <p>
                {{ $event->description }}
            </p>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-2">
                        <h5>Start date</h5>
                        <div class="border border-2 rounded px-3 py-2">
                            <i class="fa fa-calendar"></i> {{ is_null($event->start_date) ? "Not defined" : $event->start_date }} 
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
                            <i class="fa fa-calendar"></i> {{ is_null($event->end_date) ? "Not defined" : $event->end_date }}
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
                            37 <!-- TODO: check current participants -->
                            {{ is_null($event->max_attendance) ? "" : "/ " . $event.max_attendance }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <h5>Tags</h5>
                <!-- TODO: get tags -->
                <div class="d-flex flex-wrap gap-2">
                    <span class="text-white d-inline-flex bg-primary rounded px-2 py-1 gap-1">chess</span>
                    <span class="text-white d-inline-flex bg-primary rounded px-2 py-1 gap-1">friendly</span>
                    <span class="text-white d-inline-flex bg-primary rounded px-2 py-1 gap-1">for beginners</span>
                    <span class="text-white d-inline-flex bg-primary rounded px-2 py-1 gap-1">blitz chess</span>
                    <span class="text-white d-inline-flex bg-primary rounded px-2 py-1 gap-1">learning</span>
                </div>
            </div>
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
        </ul>
    </nav>

    <!-- TODO: comments and polls -->
    <div class="tab-content" id="tabContent">
        <div class="tab-pane fade show active p-3" id="commentsTab" role="tabpanel" aria-labelledby="commentsLabel">
            <form class="mb-3">
                <div class="mb-3">
                    <label for="comment" class="h5 form-label">Write a comment</label>
                    <textarea class="form-control" id="comment" name="comment" placeholder="You can use comments to ask questions or make suggestions..." required></textarea>
                </div>
                <input type="submit" class="btn btn-primary" value="Post">
            </form>

            <section id="comments">
                <h4>5 comments</h4>
                <div>
                    <div class="row pt-3">
                        <div>
                            <div class="d-flex align-items-start justify-content-between">
                                <h5>Mary Langdon (<span class="text-primary">@marylangdon105</span>)</h5>
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-primary" aria-label="Reply"><i class="fa fa-reply"></i></button>
                                </div>
                            </div>
                            What is your favorite opening?
                        </div>

                        <div class="ps-5">
                            <div class="row pt-3">
                                <div>
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h5>Dmitri Dolyakov (<span class="text-primary">@dmitridlkv</span>)</h5>
                                        <div class="d-flex gap-1">
                                            <button type="button" class="btn btn-primary" aria-label="Reply"><i class="fa fa-reply"></i></button>
                                        </div>
                                    </div>
                                    Italian Game with Evans Gambit :)
                                </div>
                            </div>

                            <div class="row pt-3">
                                <div>
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h5>John Doe (<span class="text-primary">@johndoe123</span>)</h5>
                                        <div class="d-flex gap-1">
                                            <button type="button" class="btn btn-primary" aria-label="Reply"><i class="fa fa-reply"></i></button>
                                            <button type="button" class="btn btn-secondary" aria-label="Edit"><i class="fa fa-pencil"></i></button>
                                            <button type="button" class="btn btn-danger" aria-label="Remove"><i class="fa fa-remove"></i></button>
                                        </div>
                                    </div>
                                    I love the King's Gambit :D
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row py-3">
                        <div>
                            <div class="d-flex align-items-start justify-content-between">
                                <h5>Martin Fowler (<span class="text-primary">@fowlersrook</span>)</h5>
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-primary" aria-label="Reply"><i class="fa fa-reply"></i></button>
                                </div>
                            </div>
                            Great event, the players were very friendly! Hope I can participate in more events like this soon.
                        </div>

                        <div class="ps-5">
                            <div class="row pt-3">
                                <div>
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h5>John Doe (<span class="text-primary">@johndoe123</span>)</h5>
                                        <div class="d-flex gap-1">
                                            <button type="button" class="btn btn-primary" aria-label="Reply"><i class="fa fa-reply"></i></button>
                                            <button type="button" class="btn btn-secondary" aria-label="Edit"><i class="fa fa-pencil"></i></button>
                                            <button type="button" class="btn btn-danger" aria-label="Remove"><i class="fa fa-remove"></i></button>
                                        </div>
                                    </div>
                                    Thank you! Hope to see you too!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="tab-pane fade p-3" id="pollsTab" role="tabpanel" aria-labelledby="pollsLabel">
            <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#createPollModal">Create poll</button>
    
            <div class="row mt-3">
                <section class="col-md-6 mb-3">
                    <h5>What should the time control be?</h5>
                    
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>5 + 3</span>
                            <span class="text-primary">10 votes (55.6%)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>5 + 0</span>
                            <span class="text-primary">6 votes (33.3%)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>3 + 2</span>
                            <span class="text-primary">2 votes (11.1%)</span>
                        </li>
                    </ul>
                </section>
            </div>

            <div class="modal fade" id="createPollModal" tabindex="-1" aria-labelledby="createPollLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="createPollLabel">Create poll</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="pollTitle" class="h5 form-label">Poll Title *</label>
                                    <input type="text" class="form-control" id="pollTitle" name="pollTitle" required>
                                </div>

                                <h5>Options *</h5>
                                <ul class="list-unstyled d-flex flex-column gap-1">
                                    <li class="input-group">
                                        <input type="text" class="form-control" required>
                                        <button type="button" class="btn btn-danger" aria-label="Remove option"><i class="fa fa-remove"></i></button>
                                    </li>
                                    <li class="input-group">
                                        <input type="text" class="form-control" required>
                                        <button type="button" class="btn btn-danger" aria-label="Remove option"><i class="fa fa-remove"></i></button>
                                    </li>
                                    <li class="input-group">
                                        <input type="text" class="form-control" required>
                                        <button type="button" class="btn btn-danger" aria-label="Remove option"><i class="fa fa-remove"></i></button>
                                    </li>
                                </ul>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="New option" aria-label="Name">
                                    <button type="button" class="btn btn-success" aria-label="Add option"><i class="fa fa-plus"></i></button>
                                </div>

                                <div class="modal-footer px-0">
                                    <input type="submit" class="btn btn-primary" value="Create">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
