<?php
    include_once('../templates/header.php');
?>

<div class="container-fluid ps-0">
    <div class="row">
        <div class="col-md-8">
            <img src="../assets/chess.jpg" class="img-fluid" alt="An image">
            <h1 class="display-4 text-center p-3">
                Helping you organize and participate in all the events you dream of
            </h1>
        </div>

        <div class="col-md-4 p-3">
            <h3 class="text-center">Top Events this Month</h3>

    	    <div class="d-flex flex-column gap-2">
                <article class="card">
                    <div class="row g-0">
                        <div class="bg-light col-md-3 d-flex align-items-center">
                            <img class="card-img-bottom" src="../assets/chess_event.jpg">
                        </div>
                        <div class="col-md-9">
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
                        <div class="bg-light col-md-3 d-flex align-items-center">
                            <img class="card-img-bottom" src="../assets/starcraft.jpg">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <a class="text-primary" href="#"><h5 class="card-title text-center">Starcraft 2 Tournament</h5></a>
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
                        <div class="bg-light col-md-3 d-flex align-items-center">
                            <img class="card-img-bottom" src="../assets/tibalt.jpg">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <a class="text-primary" href="#"><h5 class="card-title text-center">Magic: the Gathering - Kaldheim Draft</h5></a>
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
    </div>
</div>

<?php
    include_once('../templates/footer.php');
?>