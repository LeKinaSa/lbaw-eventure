<?php
    include_once('../templates/header.php');
?>

<div class="container pb-3">
    <img src="../assets/chess.jpg" class="img-fluid mb-3 rounded-bottom" alt="An image">
    <h1 class="display-4 text-center">EVENTURE</h1>
    <h2 class="display-6 text-center">A dynamic platform for event management and tournament organization</h1>

    <section id="features" class="mt-4 bg-light p-3">
        <h2 class="text-center">Features</h2>

        <div class="row text-center">
            <div class="col-md">
                <h4><i class="fa fa-users text-primary"></i></h4>
                <h4>Community</h4>
                <p>Eventure supports user interaction through comments and polls so you can organize your event according to user feedback and increase engagement</p>
            </div>
            <div class="col-md">
                <h4><i class="fa fa-search text-primary"></i></h4>
                <h4>Discovery</h4>
                <p>Increase the visibility of your event through tags, which can help you connect with your event's target audience. For attendees, our search system
                can help you find the events you're most interested in.</p>
            </div>
            <div class="col-md">
                <h4><i class="fa fa-trophy text-primary"></i></h4>
                <h4>Competitions</h4>
                <p>We provide specialized features for tournaments and competitions, such as match results and automatic leaderboards.</p>
            </div>
        </div>
    </section>

    <section id="topEvents" class="mt-4">
        <div class="col-md-12 col-lg-8 mx-auto">
            <h3 class="text-center">Top Events this Month</h3>
            <div class="d-flex align-items-center align-items-md-start justify-content-md-start flex-column gap-2">
                <article class="card">
                    <div class="row g-0">
                        <div class="col-md-4 d-flex bg-light align-items-center">
                            <img class="card-img-top" src="../assets/chess_event.jpg">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <a class="text-primary" href="event.php"><h5 class="card-title text-center">Amateur Blitz Chess Tournament</h5></a>
                                <ul class="list-unstyled">
                                    <li class="card-text"><i class="col-1 fa fa-calendar" aria-label="Date"></i>28 March, 2021</li>
                                    <li class="card-text"><i class="col-1 fa fa-globe" aria-label="Type"></i>Mixed</li>
                                    <li class="card-text"><i class="col-1 fa fa-map-marker" aria-label="Location"></i>Marshall Street, 283</li>
                                    <li class="card-text"><i class="col-1 fa fa-user" aria-label="Number of participants"></i>37 participants</li>
                                </ul>
                                <p class="card-text">
                                Test your blitz skills in this amateur chess competition!
                                Players with up to 1500 rating can participate.
                                The time control is 5 minutes with 3 seconds of move increment. 
                                </p>
                            </div>
                        </div>
                    </div>
                </article>

                <article class="card">
                    <div class="row g-0">
                        <div class="col-md-4 d-flex bg-light align-items-center">
                            <img class="card-img-bottom" src="../assets/starcraft.jpg">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <a class="text-primary" href="event.php"><h5 class="card-title text-center">Starcraft 2 Tournament</h5></a>
                                <ul class="list-unstyled">
                                    <li class="card-text"><i class="col-1 fa fa-calendar" aria-label="Date"></i>21 March, 2021</li>
                                    <li class="card-text"><i class="col-1 fa fa-globe" aria-label="Type"></i>Virtual</li>
                                    <li class="card-text"><i class="col-1 fa fa-user" aria-label="Number of participants"></i>27 participants</li>
                                </ul>
                                <p class="card-text">
                                Our store's first ever draft of the new set! Come enjoy exciting matches, new mechanics 
                                and a chance to win special prizes.
                                </p>
                            </div>
                        </div>
                    </div>
                </article>

                <article class="card">
                    <div class="row g-0">
                        <div class="col-md-4 d-flex bg-light align-items-center">
                            <img class="card-img-bottom" src="../assets/tibalt.jpg">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <a class="text-primary" href="event.php"><h5 class="card-title text-center">Magic: the Gathering - Kaldheim Draft</h5></a>
                                <ul class="list-unstyled">
                                    <li class="card-text"><i class="col-1 fa fa-calendar" aria-label="Date"></i>25 March, 2021</li>
                                    <li class="card-text"><i class="col-1 fa fa-globe" aria-label="Type"></i>In person</li>
                                    <li class="card-text"><i class="col-1 fa fa-map-marker" aria-label="Location"></i>Friendly Local Game Store</li>
                                    <li class="card-text"><i class="col-1 fa fa-user" aria-label="Number of participants"></i>15 participants</li>
                                </ul>
                                <p class="card-text">
                                Our store's first ever draft of the new set! Come enjoy exciting matches, new mechanics 
                                and a chance to win special prizes.
                                </p>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</div>

<?php
    include_once('../templates/footer.php');
?>