<? include_once('../templates/header.php'); ?>

<div class="container p-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Search results</li>
        </ol>
    </nav>

    <div class="row g-md-5">
        <section class="col-md-3 p-3 bg-light">
            <h4 class="text-center">Filters</h4>

            <div class="mb-3">
                <label for="startDate" class="h5 form-label">From</label>
                <input class="form-control" id="startDate" name="startDate" type="date">
            </div>

            <div class="mb-3">
                <label for="endDate" class="h5 form-label">To</label>
                <input class="form-control" id="endDate" name="endDate" type="date">
            </div>

            <div class="mb-3">
                <h5>Type</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="typeInPerson" name="typeInPerson">
                    <label class="form-check-label" for="typeInPerson">In person</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="typeMixed" name="typeMixed">
                    <label class="form-check-label" for="typeMixed">Mixed</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="typeVirtual" name="typeVirtual">
                    <label class="form-check-label" for="typeVirtual">Virtual</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="tags" class="h5 form-label">Tags</label>
                <input type="text" class="form-control">
            </div>
            
            <div id="tags" class="d-flex flex-wrap gap-2 mb-3">
                <span class="text-white d-inline-flex bg-primary rounded p-2 gap-1">
                    chess
                    <button type="button" class="btn-close btn-close-white"></button>
                </span>
                <span class="text-white d-inline-flex bg-primary rounded p-2 gap-1">
                    friendly
                    <button type="button" class="btn-close btn-close-white"></button>
                </span>
                <span class="text-white d-inline-flex bg-primary rounded p-2 gap-1">
                    for-beginners
                    <button type="button" class="btn-close btn-close-white"></button>
                </span>
            </div>

            <div class="mb-3">
                <label for="category" class="h5 form-label">Category</label>
                <select class="form-select" id="category" name="category">
                    <option selected>Any</option>
                    <option selected>Video games</option>
                    <option selected>Board games</option>
                    <option selected>Card games</option>
                    <option selected>Other</option>
                </select>
            </div>
        </section>

        <section class="col-md-9 pt-3">
            <h3 class="text-center">Search results</h3>
            <div id="searchResults" class="d-flex flex-column gap-2">
                <article class="card">
                    <div class="row g-0">
                        <div class="bg-light col-md-3 d-flex align-items-center">
                            <img src="../assets/chess_event.jpg" class="img-fluid">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <a href="#"><h5 class="card-title text-center">Casual Chess Meetup - Bullet, Blitz and Rapid</h5></a>
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
                                <a href="event.php"><h5 class="card-title text-center">Amateur Blitz Chess Tournament</h5></a>
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
</div>

<? include_once('../templates/footer.php'); ?>