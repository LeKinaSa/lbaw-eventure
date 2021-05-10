@extends('layouts.app')

@section('content')
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="homepage.php">Home</a></li>
            <li class="breadcrumb-item"><a class="text-primary" href="profile.php">Profile</a></li>
            <li class="breadcrumb-item active" aria-current="page">Your Events</li>
        </ol>
    </nav>

    <div class="row g-3 justify-content-center">
        <h1 class="text-center">Your Events</h1>

        <nav>
            <div class="nav nav-tabs">
                <button class="nav-link active" id="organizerEventsTab" data-bs-toggle="tab" data-bs-target="#organizerEvents" type="button" role="tab" aria-controls="organizerEvents" aria-selected="true">
                    Organizing
                </button>
                <button class="nav-link" id="participantEventsTab" data-bs-toggle="tab" data-bs-target="#participantEvents" type="button" role="tab" aria-controls="participantEvents" aria-selected="false">
                    Participating in
                </button>
            </div>
        </nav>

        <div class="tab-content" id="personalEventsContent">
            <div class="tab-pane fade show active" id="organizerEvents" role="tabpanel" aria-labelledby="organizerEventsTab">
                <div class="d-flex justify-content-center justify-content-md-start flex-wrap gap-3">
                    @each('partials.event_small', $eventsOrganizing, 'event')
                </div>
            </div>

            <div class="tab-pane fade" id="participantEvents" role="tabpanel" aria-labelledby="participantEventsTab">
                <div class="d-flex justify-content-center justify-content-md-start flex-wrap gap-3">
                    @each('partials.event_small', $eventsParticipatingIn, 'event')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection