@extends('layouts.app')

@section('content')

<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contacts</li>
        </ol>
    </nav>

    <h1 class="text-center mb-3">Contacts</h1>

    <div class="row">
        <div class="col-md-8 mb-2 mb-md-0">
            <img src="{{ asset('img/mac_desk.jpg') }}" class="img-fluid rounded" alt="Macbook laptop on a desk">
        </div>
        
        <div class="col-md-4 py-2">
            <ul class="list-unstyled">
                <li>
                    <h5><i class="fa fa-map-marker"></i> Address</h5>
                    <p>Faculdade de Engenharia da Universidade do Porto (FEUP)<br>
                    Rua Dr. Roberto Frias<br>
                    4200-465 PORTO
                    </p>
                </li>
                <li>
                    <h5><i class="fa fa-envelope"></i> Email</h5>
                    <p>eventure@email.com</p>
                </li>
                <li>
                    <h5><i class="fa fa-phone"></i> Phone number</h5>
                    <p>+351 999 999 999</p>
                </li>
            </ul>

            <ul class="list-inline">
                <li class="list-inline-item"><a href="#" class="fs-2"><i class="fa fa-facebook-square"></i></a></li>
                <li class="list-inline-item"><a href="#" class="fs-2"><i class="fa fa-twitter"></i></a></li>
                <li class="list-inline-item"><a href="#" class="fs-2"><i class="fa fa-linkedin-square"></i></a></li>
                <li class="list-inline-item"><a href="#" class="fs-2"><i class="fa fa-instagram"></i></a></li>
                <li class="list-inline-item"><a href="#" class="fs-2"><i class="fa fa-youtube-play"></i></a></li>
                <li class="list-inline-item"><a href="#" class="fs-2"><i class="fa fa-twitch"></i></a></li>
            </ul>
        </div>
    </div>
</div>

@endsection
