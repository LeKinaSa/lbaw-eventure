<? include_once('../templates/header.php'); ?>

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
                    <article class="card card-profile">
                        <img src="../assets/board_game.jpeg" class="card-img-top">
                        <div class="card-body">
                            <a class="text-primary" href="event.php"><h5 class="card-title text-center">Board Games at John's House</h5></a>
                            <ul class="list-unstyled">
                                <li class="card-text"><i class="col-2 fa fa-calendar" aria-label="Date"></i>7 March, 2021</li>
                                <li class="card-text"><i class="col-2 fa fa-map-marker" aria-label="Location"></i>Doctor Street, 172</li>
                                <li class="card-text"><i class="col-2 fa fa-user" aria-label="Number of participants"></i>6 participants</li>
                            </ul>
                        </div>
                    </article>

                    <article class="card card-profile">
                        <img src="../assets/chess_event.jpg" class="card-img-top">
                        <div class="card-body">
                            <a class="text-primary" href="event.php"><h5 class="card-title text-center">Casual Chess Meetup - Bullet, Blitz and Rapid</h5></a>
                            <ul class="list-unstyled">
                                <li class="card-text"><i class="col-2 fa fa-calendar" aria-label="Date"></i>16 March, 2021</li>
                                <li class="card-text"><i class="col-2 fa fa-map-marker" aria-label="Location"></i>Friendly Local Game Store</li>
                                <li class="card-text"><i class="col-2 fa fa-user" aria-label="Number of participants"></i>15 participants</li>
                            </ul>
                        </div>
                    </article>
                </div>
            </div>

            <div class="tab-pane fade" id="participantEvents" role="tabpanel" aria-labelledby="participantEventsTab">
                <div class="d-flex justify-content-center justify-content-md-start flex-wrap gap-3">
                    <article class="card card-profile">
                        <img src="../assets/tibalt.jpg" class="card-img-top">
                        <div class="card-body">
                            <a class="text-primary" href="event.php"><h5 class="card-title text-center">Magic: The Gathering - Kaldheim Draft</h5></a>
                            <ul class="list-unstyled">
                                <li class="card-text"><i class="col-2 fa fa-calendar" aria-label="Date"></i>25 March, 2021</li>
                                <li class="card-text"><i class="col-2 fa fa-map-marker" aria-label="Location"></i>Friendly Local Game Store</li>
                                <li class="card-text"><i class="col-2 fa fa-user" aria-label="Number of participants"></i>15 participants</li>
                            </ul>
                        </div>
                    </article>

                    <article class="card card-profile">
                        <img src="../assets/chess_event.jpg" class="card-img-top">
                        <div class="card-body">
                            <a class="text-primary" href="event.php"><h5 class="card-title text-center">Amateur Blitz Chess Tournament</h5></a>
                            <ul class="list-unstyled">
                                <li class="card-text"><i class="col-2 fa fa-calendar" aria-label="Date"></i>28 March, 2021</li>
                                <li class="card-text"><i class="col-2 fa fa-map-marker" aria-label="Location"></i>Marshall Street, 283</li>
                                <li class="card-text"><i class="col-2 fa fa-user" aria-label="Number of participants"></i>37 participants</li>
                            </ul>
                        </div>
                    </article>

                    <article class="card card-profile">
                        <img src="../assets/dnd.jpg" class="card-img-top">
                        <div class="card-body">
                            <a class="text-primary" href="event.php"><h5 class="card-title text-center">Dungeons and Dragons Meetup #3</h5></a>
                            <ul class="list-unstyled">
                                <li class="card-text"><i class="col-2 fa fa-calendar" aria-label="Date"></i>4 April, 2021</li>
                                <li class="card-text"><i class="col-2 fa fa-map-marker" aria-label="Location"></i>Friendly Local Game Store</li>
                                <li class="card-text"><i class="col-2 fa fa-user" aria-label="Number of participants"></i>8 participants</li>
                            </ul>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</div>


<? include_once('../templates/footer.php'); ?>