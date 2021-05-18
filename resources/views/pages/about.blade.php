@extends('layouts.app')

@section('content')


<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">About</li>
        </ol>
    </nav>

    <div class="d-grid gap-4 text-center">
        <img src="../assets/computers.jpg" class="img-fluid" alt="Several computer setups for gaming">
        <div class="text-center">
            <h1 class="display-4">A dedicated platform for tournaments and competitions</h1>
            <p class="fs-4">Eventure provides tournament organizers tools to schedule matches, post results and automatically generate leaderboards. 
            These tools are customisable and can be adapted to several kinds of tournaments and games</p>
        </div>

        <img src="../assets/evo.jpg" class="img-fluid" alt="EVO fighting game tournament">
        <div class="text-center">
            <h1 class="display-4">A way to interact with the community</h1>
            <p class="fs-4">We know the importance of the feeling of community and social interaction in these events, 
            so Eventure grants you several ways to interact with the community and get feedback so you can 
            craft the best experience possible.</p>
        </div>
        
        <hr>

        <div class="row gap-4 mb-3">
            <h1 class="mb-3">Team</h1>

            <div class="col-md">
                <h4 class="mb-2">Afonso Caiado</h4>
                <img src="{{ asset('img/profile_default.png') }}" class="img-fluid rounded-circle w-75">
            </div>

            <div class="col-md">
                <h4 class="mb-2">Clara Martins</h4>
                <img src="{{ asset('img/profile_default.png') }}" class="img-fluid rounded-circle w-75">
            </div>

            <div class="col-md">
                <h4 class="mb-2">Daniel Monteiro</h4>
                <img src="{{ asset('img/profile_default.png') }}" class="img-fluid rounded-circle w-75">
            </div>

            <div class="col-md">
                <h4 class="mb-2">Gonçalo Pascoal</h4>
                <img src="{{ asset('img/profile_default.png') }}" class="img-fluid rounded-circle w-75">
            </div>
        </div>
    </div>

    </div>
</div>

@endsection
