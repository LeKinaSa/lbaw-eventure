@extends('layouts.app')

@section('content')
<div id="homepageCarousel" class="carousel slide carousel-fade mb-2" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="5000">
            <img src="{{ asset('img/chess.jpg') }}" class="img-fluid" alt="Chess pieces">
        </div>
        <div class="carousel-item" data-bs-interval="5000">
            <img src="{{ asset('img/esports.jpg') }}" class="img-fluid" alt="Venue for e-sports tournament">
        </div>
        <div class="carousel-item" data-bs-interval="5000">
            <img src="{{ asset('img/mtg_tournament.jpg') }}" class="img-fluid" alt="Magic: the Gathering tournament">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#homepageCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homepageCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="container pb-3">
    <h1 class="display-4 text-center">EVENTURE</h1>
    <h2 class="display-6 text-center">A dynamic platform for event management and tournament organization</h1>
        
    <section id="features" class="mt-4 bg-light p-3">
        <h2 class="text-center">Features</h2>

        <div class="row text-center">
            <div class="col-md">
                <i class="fa fa-users text-primary fs-3"></i>
                <h4>Community</h4>
                <p>Eventure supports user interaction through comments and polls so you can organize your event according to user feedback and increase engagement</p>
            </div>
            <div class="col-md">
                <i class="fa fa-search text-primary fs-3"></i>
                <h4>Discovery</h4>
                <p>Increase the visibility of your event through tags, which can help you connect with your event's target audience. For attendees, our search system
                can help you find the events you're most interested in.</p>
            </div>
            <div class="col-md">
                <i class="fa fa-trophy text-primary fs-3"></i>
                <h4>Competitions</h4>
                <p>We provide specialized features for tournaments and competitions, such as match results and automatic leaderboards.</p>
            </div>
        </div>
    </section>
</div>
@endsection
