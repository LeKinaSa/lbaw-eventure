<?php
    include_once('../templates/header.php');
?>
<div class="container-fluid p-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
            <li class="breadcrumb-item"><a href="search_results.php">Events</a></li>
            <li class="breadcrumb-item active" aria-current="page">Magic Encounter</li>
        </ol>
    </nav>
    <div class="align-self-center text-center">
        <h1 class="display-4">Magic Encounter</h1>
        <div class="d-grid p-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <img src="../assets/dnd.jpg" class="img-fluid" alt="Magic Encounter Image">
                    </div>
                    <div class="row text-start p-3">
                        <p>
                        Magic encounter, where all the magic comes together.
                        The time for magic to appear has come and we can feel it floating in the air.
                        Will you answer this call and dive deeper into the exotic airs of magic encounter?
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="d-grid">
                            <div class="row p-2">
                                <div class="col-md-6 text-start">
                                    <div>
                                        Start
                                    </div>
                                    <div class="border border-dark p-2">
                                        <i class="fa fa-calendar"></i> 1/3/2021
                                    </div>
                                </div>
                                <div class="col-md-6 text-start">
                                    <div>
                                        Finish
                                    </div>
                                    <div class="border border-dark p-2">
                                        <i class="fa fa-calendar"></i> 5/3/2021
                                    </div>
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col-md-6 text-start">
                                    <div>
                                        Type
                                    </div>
                                    <div class="border border-dark p-2">
                                        Mixed
                                    </div>
                                </div>
                                <div class="col-md-6 text-start">
                                    <div>
                                        Location
                                    </div>
                                    <div class="border border-dark p-2">
                                        <i class="fa fa-map-marker"></i> Castelo de Bragança
                                    </div>
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col-md-6 text-start">
                                    <div>
                                        Attendance
                                    </div>
                                    <div class="border border-dark p-2">
                                        50
                                    </div>
                                </div>
                                <div class="col-md-6 text-start">
                                    <div>
                                        Max Attendance
                                    </div>
                                    <div class="border border-dark p-2">
                                        150
                                    </div>
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="row justify-content-center">
                                    <div class="col-md-5">
                                        <div id="matches" class="carousel slide" data-bs-ride="carousel">
                                            <ol class="carousel-indicators">
                                                <li data-bs-target="#matches" data-bs-slide-to="0" class="active"></li>
                                                <li data-bs-target="#matches" data-bs-slide-to="1"></li>
                                                <li data-bs-target="#matches" data-bs-slide-to="2"></li>
                                            </ol>
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <div class="border border-dark border-2 p-2">
                                                        <strong>
                                                            Luís vs Mário
                                                        </strong>
                                                        <br>
                                                        1/3/2021 13h00
                                                    </div>
                                                </div>
                                                <div class="carousel-item">
                                                    <div class="border border-dark border-2 p-2">
                                                        <strong>
                                                            João vs Paulo
                                                        </strong>
                                                        <br>
                                                        2/3/2021 9h00
                                                    </div>
                                                </div>
                                                <div class="carousel-item">
                                                    <div class="border border-dark border-2 p-2">
                                                        <strong>
                                                            Paulo vs Kiko
                                                        </strong>
                                                        <br>
                                                       4/3/2021 18h30
                                                    </div>
                                                </div>
                                            </div>
                                            <a class="carousel-control-prev" href="#matches" role="button" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#matches" role="button" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="d-grid gap-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-grid">
                                                <button class="btn btn-outline-primary btn-block mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#comments" aria-expanded="false" aria-controls="comments">
                                                    Comments
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-grid">
                                                <button class="btn btn-outline-primary btn-block mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#polls" aria-expanded="false" aria-controls="polls">
                                                    Polls
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="collapse" id="comments">
                                        <div class="card card-body">
                                            <h5 class="card-title">Comments</h5>
                                            <div class="card-text">
                                                <p class="text-start">
                                                    <strong>
                                                        RiverPirate
                                                    </strong>
                                                    <br>
                                                    Will the finals be presential instead of online?
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="collapse" id="polls">
                                        <div class="card card-body">
                                            <h5 class="card-title">Polls</h5>
                                            <p class="card-text">Will something unexpected happen in the next game?</p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-grid">
                                                        <button class="btn btn-outline-success btn-sm">
                                                            Yes
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-grid">
                                                        <button class="btn btn-outline-danger btn-sm">
                                                            No
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col">
                                    <a href="results.php" role="button" class="btn btn-primary">Results</a>
                                </div>
                                <div class="col">
                                    <a href="invitations.php" role="button" class="btn btn-primary">Invitations</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include_once('../templates/footer.php');
?>
