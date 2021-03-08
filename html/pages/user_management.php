<? include_once('../templates/header.php') ?>

<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active">User management</li>
        </ol>
    </nav>

    <section id="suspendedUsers" class="mb-4">
        <h2>Suspended users</h2>
        
        <div class="d-flex flex-wrap gap-3">
            <div class="card" style="max-width: 500px;">
                <div class="row g-0">
                    <div class="col-md-4 d-flex align-items-center">
                        <img src="../assets/profile_default.png" class="card-img-top">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title">Sophie London</h5>
                                    <h6 class="text-primary">@sophietherude</h6>
                                </div>

                                <div class="col d-flex align-items-start justify-content-end gap-2">
                                    <button class="btn btn-secondary" aria-label="Edit"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger" aria-label="Remove"><i class="fa fa-remove"></i></button>
                                </div>
                            </div>
                            
                            <ul class="list-unstyled mb-0">
                                <li class="card-text"><b>Suspension date:</b> 15 January 2021</li>
                                <li class="card-text"><b>Suspension duration:</b> 7 days</li>
                                <li class="card-text"><b>Motive:</b> spamming in comments</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" style="max-width: 500px;">
                <div class="row g-0">
                    <div class="col-md-4 d-flex align-items-center">
                        <img src="../assets/profile_default.png" class="card-img-top">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title">Joseph Dolyov</h5>
                                    <h6 class="text-primary">@jdolyov12</h6>
                                </div>

                                <div class="col d-flex align-items-start justify-content-end gap-2">
                                    <button class="btn btn-secondary" aria-label="Edit"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-danger" aria-label="Remove"><i class="fa fa-remove"></i></button>
                                </div>
                            </div>
                            
                            <ul class="list-unstyled mb-0">
                                <li class="card-text"><b>Suspension date:</b> 10 January 2021</li>
                                <li class="card-text"><b>Suspension duration:</b> 14 days</li>
                                <li class="card-text"><b>Motive:</b> posting link to malicious website</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="bannedUsers">
        <h2>Banned users</h2>

        <div class="d-flex flex-wrap gap-3">
        <div class="card" style="max-width: 500px;">
                <div class="row g-0">
                    <div class="col-md-4 d-flex align-items-center">
                        <img src="../assets/profile_default.png" class="card-img-top">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title">David Horton</h5>
                                    <h6 class="text-primary">@davidthehorton</h6>
                                </div>

                                <div class="col d-flex align-items-start justify-content-end gap-2">
                                    <button class="btn btn-danger" aria-label="Remove"><i class="fa fa-remove"></i></button>
                                </div>
                            </div>
                            
                            <ul class="list-unstyled mb-0">
                                <li class="card-text"><b>Ban date:</b> 5 January 2021</li>
                                <li class="card-text"><b>Motive:</b> repeated offensive behaviour</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<? include_once('../templates/footer.php') ?>