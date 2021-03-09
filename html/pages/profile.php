<? include_once('../templates/header.php'); ?>

<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-3 pt-3">
            <a class="text-primary" href="../assets/profile_picture.jpg">
                <img src="../assets/profile_picture.jpg" class="img-fluid d-block mx-auto rounded-circle mb-3 " alt="Profile picture">
            </a>
            <h1>John Doe</h1>
            <h4 class="text-primary">@johndoe123</h4>
            </p>I'm an avid reader and I am interested in trading card games. 
            I frequently compete in Magic: The Gathering events and my favorite format is Draft. 
            I also like to play some chess from time to time.</p>
            <ul class="list-unstyled">
                <li class="h5" aria-label="Email"><i class="col-1 fa fa-envelope"></i> johndoe@gmail.com</li>
                <li class="h5" aria-label="Location"><i class="col-1 fa fa-map-marker"></i> Liverpool, UK</li>
                <li class="h5" aria-label="Gender"><i class="col-1 fa fa-user"></i> Male</li>
                <li class="h5" aria-label="Age"><i class="col-1 fa fa-calendar"></i> 25 years old</li>
                <li class="h5" aria-label="Website"><i class="col-1 fa fa-link"></i> <a class="text-primary" href="http://www.johndoeblog.com">www.johndoeblog.com</a></li>
            </ul>
            <div class="d-grid">
                <a class="text-primary" href="edit_profile.php" role="button" class="btn btn-light border">Edit profile</a>
            </div>
        </div>

        <div class="col-md-9 pt-3">
            <section id="eventsOrganizer" class="row bg-light m-3 p-3">
                <h4>Events you are organizing</h4>
                <div class="d-flex flex-wrap gap-3">
                    <article class="card" style="max-width: 250px;">
                        <img src="../assets/board_game.jpeg" class="card-img-top">
                        <div class="card-body">
                            <a class="text-primary" href="#"><h5 class="card-title text-center">Board Games at John's House</h5></a>
                            <ul class="list-unstyled">
                                <li class="card-text"><i class="col-2 fa fa-calendar" aria-label="Date"></i>7 March, 2021</li>
                                <li class="card-text"><i class="col-2 fa fa-map-marker" aria-label="Location"></i>Doctor Street, 172</li>
                                <li class="card-text"><i class="col-2 fa fa-user" aria-label="Number of participants"></i>6 participants</li>
                            </ul>
                        </div>
                    </article>

                    <article class="card" style="max-width: 250px;">
                        <img src="../assets/chess_event.jpg" class="card-img-top">
                        <div class="card-body">
                            <a class="text-primary" href="#"><h5 class="card-title text-center">Casual Chess Meetup - Bullet, Blitz and Rapid</h5></a>
                            <ul class="list-unstyled">
                                <li class="card-text"><i class="col-2 fa fa-calendar" aria-label="Date"></i>16 March, 2021</li>
                                <li class="card-text"><i class="col-2 fa fa-map-marker" aria-label="Location"></i>Friendly Local Game Store</li>
                                <li class="card-text"><i class="col-2 fa fa-user" aria-label="Number of participants"></i>15 participants</li>
                            </ul>
                        </div>
                    </article>
                </div>
            </section>

            <section id="eventsParticipant" class="row bg-light m-3 p-3">
                <h4>Events you are participating in</h4>
                <div class="d-flex flex-wrap gap-3">
                    <article class="card" style="max-width: 250px;">
                        <img src="../assets/tibalt.jpg" class="card-img-top">
                        <div class="card-body">
                            <a class="text-primary" href="#"><h5 class="card-title text-center">Magic: The Gathering - Kaldheim Draft</h5></a>
                            <ul class="list-unstyled">
                                <li class="card-text"><i class="col-2 fa fa-calendar" aria-label="Date"></i>25 March, 2021</li>
                                <li class="card-text"><i class="col-2 fa fa-map-marker" aria-label="Location"></i>Friendly Local Game Store</li>
                                <li class="card-text"><i class="col-2 fa fa-user" aria-label="Number of participants"></i>15 participants</li>
                            </ul>
                        </div>
                    </article>

                    <article class="card" style="max-width: 250px;">
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

                    <article class="card" style="max-width: 250px;">
                        <img src="../assets/dnd.jpg" class="card-img-top">
                        <div class="card-body">
                            <a class="text-primary" href="#"><h5 class="card-title text-center">Dungeons and Dragons Meetup #3</h5></a>
                            <ul class="list-unstyled">
                                <li class="card-text"><i class="col-2 fa fa-calendar" aria-label="Date"></i>4 April, 2021</li>
                                <li class="card-text"><i class="col-2 fa fa-map-marker" aria-label="Location"></i>Friendly Local Game Store</li>
                                <li class="card-text"><i class="col-2 fa fa-user" aria-label="Number of participants"></i>8 participants</li>
                            </ul>
                        </div>
                    </article>
                </div>
            </section>
        </div>
    </div>
</div>

<? include_once('../templates/footer.php'); ?>