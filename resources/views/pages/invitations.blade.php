@extends('layouts.app')
@section('content')
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a class="text-primary" href="{{ route('events.event', ['id' => $event->id]) }}">{{ $event->title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Invitations</li>
        </ol>
    </nav>

    <h1 class="text-center">Invitations</h1>
    
    <form method="POST" class="py-3" action="{{ route('events.event.invitations.invite', ['id' => $event->id]) }}">
        {{ csrf_field() }}
        
        <div class="input-group">
            <input type="text" class="form-control" id="invite" name="invite" placeholder="Enter a username / email..." required>
            <button type="submit" class="btn btn-primary">Send invitation</button>
            @error ('invite')
            <span class="p-2 text-danger">{{ $message }}</span>
            @enderror
        </div>
    </form>

    <div class="row">
        <section id="sent" class="col-md mb-4 mb-md-0">
            <h4>Sent</h4>
            
            <button class="btn btn-outline-danger">Cancel all</button>

            <div class="d-flex flex-wrap mt-2 gap-3">
                @each('partials.invitation', $event->invitations()->get(), 'user')
            </div>
        </section>

        <section id="requests" class="col-md">
            <h4>Requests to participate</h4>
            
            <div class="d-flex gap-2">
                <button class="btn btn-outline-success">Accept all</button>
                <button class="btn btn-outline-danger">Reject all</button>
            </div>

            <div class="d-flex flex-wrap mt-2 gap-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Afonso Caiado</h5>
                        <h6 class="text-primary">@afonsocaiado</h6>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-evenly">
                            <button class="btn btn-success" aria-label="Accept"><i class="fa fa-check"></i></button>
                            <button class="btn btn-danger" aria-label="Reject"><i class="fa fa-remove"></i></button>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daniel Monteiro</h5>
                        <h6 class="text-primary">@danielmonteiro</h6>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-evenly">
                            <button class="btn btn-success" aria-label="Accept"><i class="fa fa-check"></i></button>
                            <button class="btn btn-danger" aria-label="Deny"><i class="fa fa-remove"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
