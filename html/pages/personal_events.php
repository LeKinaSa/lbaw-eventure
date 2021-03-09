<? include_once('../templates/header.php'); ?>

<div class="container p-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Events you are organizing</li>
        </ol>
    </nav>
</div>

<div class="row g-5 justify-content-center">
    <section class="col-md-7 pt-3">
        <h3 class="text-center">Events you are organizing</h3>
        <div id="searchResults" class="d-flex flex-column gap-2">
            <article class="card">
                <div class="row g-0">
                    <div class="bg-light col-md-3 d-flex align-items-center">
                        <img src="../assets/chess_event.jpg" class="img-fluid">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <a class="text-primary" href="#"><h5 class="card-title text-center">Casual Chess Meetup - Bullet, Blitz and Rapid</h5></a>
                            <ul class="list-unstyled">
                                <li class="card-text"><i class="col-1 fa fa-calendar" aria-label="Date"></i>16 March, 2021</li>
                                <li class="card-text"><i class="col-1 fa fa-globe" aria-label="Type"></i>Mixed</li>
                                <li class="card-text"><i class="col-1 fa fa-map-marker" aria-label="Location"></i>Friendly Local Game Store</li>
                                <li class="card-text"><i class="col-1 fa fa-user" aria-label="Number of participants"></i>15 participants</li>
                            </ul>
                            <p>
                            Come hangout and play some exciting games with short time control! Players of all skill levels are welcome.
                            </p>
                        </div>
                    </div>
                </div>
            </article>

            <article class="card">
                <div class="row g-0">
                    <div class="bg-light col-md-3 d-flex align-items-center">
                        <img src="../assets/chess_event.jpg" class="img-fluid">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <a class="text-primary" href="#"><h5 class="card-title text-center">Amateur Blitz Chess Tournament</h5></a>
                            <ul class="list-unstyled">
                                <li class="card-text"><i class="col-1 fa fa-calendar" aria-label="Date"></i>28 March, 2021</li>
                                <li class="card-text"><i class="col-1 fa fa-globe" aria-label="Type"></i>Mixed</li>
                                <li class="card-text"><i class="col-1 fa fa-map-marker" aria-label="Location"></i>Marshall Street, 283</li>
                                <li class="card-text"><i class="col-1 fa fa-user" aria-label="Number of participants"></i>37 participants</li>
                            </ul>
                            <p>
                            Test your blitz skills in this amateur chess competition! Players with up to 1500 rating can participate.
                            The time control is 5 minutes with 3 seconds of move increment.
                            </p>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>

<? include_once('../templates/footer.php'); ?>