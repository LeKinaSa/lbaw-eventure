@extends('layouts.app')

@section('content')
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a class="text-primary" href="{{ route('events.event', ['id' => $event->id]) }}">{{ $event->title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Results</li>
        </ol>
    </nav>

    <h1 class="text-center mb-4">Results</h1>

    <section id="matches" class="mb-3">
        <header class="d-flex gap-2 justify-content-between align-items-center mb-2">
            <h4>Matches</h4>

            <div class="d-flex gap-2">
                <a role="button" class="btn btn-primary" href="{{ route('events.event.competitors', ['id' => $event->id]) }}">Competitors <i class='fa fa-list-ul'></i></a>
                @can('update', $event)
                @if (count($competitors) < 2)
                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="To create a match, your event needs to have at least 2 competitors">
                    <button class="btn btn-success" type="button" disabled>
                        <i class="fa fa-plus"></i>
                    </button>
                </span>
                @else
                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#matchModal" aria-label="Add match">
                    <i class="fa fa-plus"></i>
                </button>
                @endif
                <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings" aria-label="Settings">
                    <i class="fa fa-wrench"></i>
                </button>
                @endcan
            </div>

            @can('update', $event)
            @if (count($competitors) >= 2)
            <div class="modal fade" id="matchModal" tabindex="-1" aria-labelledby="matchModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="matchModalLabel">Create match</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('api.events.event.matches.new', ['id' => $event->id]) }}" id="createMatchForm">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="first" class="h5 form-label">First Competitor <span class="text-danger">*</span></label>
                                        <select class="form-select" name="first" required>
                                            @foreach ($competitors as $competitor)
                                            <option value="{{ $competitor->id }}">{{ $competitor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="second" class="h5 form-label">Second <span class="text-danger">*</span></label>
                                        <select class="form-select" name="second" required>
                                            @foreach ($competitors as $competitor)
                                            <option value="{{ $competitor->id }}">{{ $competitor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h5>Result <span class="text-danger">*</span></h5>
                                    <div class="d-flex justify-content-evenly">
                                        <div class="form-check">
                                            <label class="form-check-label" for="resultTBD">To Be Determined</label>
                                            <input class="form-check-input" type="radio" name="result" value="TBD" id="resultTBD" checked required>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="resultWinner1">1st Win</label>
                                            <input class="form-check-input" type="radio" name="result" value="Winner1" id="resultWinner1">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="resultTie">Draw</label>
                                            <input class="form-check-input" type="radio" name="result" value="Tie" id="resultTie">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="resultWinner2">2nd Win</label>
                                            <input class="form-check-input" type="radio" name="result" value="Winner2" id="resultWinner2">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="matchDate" class="h5 form-label">Date</label>
                                    <input type="date" class="form-control" id="matchDate" name="date">
                                </div>

                                <div class="mb-3">
                                    <label for="matchTime" class="h5 form-label">Time</label>
                                    <input type="time" class="form-control" id="matchTime" name="time">
                                </div>

                                <div class="mb-3">
                                    <label for="matchDescription" class="h5 form-label">Additional information</label>
                                    <textarea class="form-control" id="matchDescription" name="description" maxlength="500"></textarea>
                                </div>

                                <div class="modal-footer px-1 d-block">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p class="text-danger mb-0" id="createMatchError"></p>
                                        <input type="submit" class="btn btn-primary" value="Create">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endcan
        </header>

        @can('update', $event)
        <div class="collapse mb-2 bg-light" id="collapseSettings">
            <form class="p-3" method="POST" action="{{ route('api.events.event.leaderboard-settings.update', ['id' => $event->id]) }}" id="leaderboardSettingsForm">
                @method ('PATCH')
                <h5>Points</h5>
                <div class="d-inline-flex flex-column flex-md-row mb-3 gap-2">
                    <div class="input-group">
                        <span class="input-group-text" id="winPointsLabel">Win</span>
                        <input type="number" class="form-control" aria-label="Win" aria-describedby="winPointsLabel" name="winPoints" min="0" max="100" step="0.1" value="{{ $event->win_points }}">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text" id="drawPointsLabel">Draw</span>
                        <input type="number" class="form-control" aria-label="Draw" aria-describedby="drawPointsLabel" name="drawPoints" min="0" max="100" step="0.1" value="{{ $event->draw_points }}">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text" id="lossPointsLabel">Loss</span>
                        <input type="number" class="form-control" aria-label="Loss" aria-describedby="lossPointsLabel" name="lossPoints" min="0" max="100" step="0.1" value="{{ $event->loss_points }}">
                    </div>
                </div>

                <div class="form-check mb-3">
                    <label for="generateLeaderboard" class="form-check-label">Generate leaderboard</label>
                    <input type="checkbox" class="form-check-input" id="generateLeaderboard" name="generateLeaderboard" {{ $event->leaderboard ? 'checked' : '' }}>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <input type="submit" class="btn btn-primary" value="Apply">
                    <p class="mb-0 text-danger" id="leaderboardSettingsError"></p>
                </div>
            </form>
        </div>
        @endcan

        <div class="d-inline-flex flex-column flex-md-row flex-md-wrap gap-2" id="matchList">
            @each('partials.match', $matches, 'match')
        </div>
    </section>

    <section id="leaderboard">
        @include('partials.leaderboard', ['leaderboard' => $leaderboard])
    </section>
</div>
@endsection