<? include_once('../templates/header.php') ?>

<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active">User management</li>
        </ol>
    </nav>

    <section id="suspendedUsers" class="mb-4">
        <h2>Suspended users</h2>

        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-md-flex gap-3 align-items-center">
                    <div class="mb-1">
                        <h5 class="card-title mb-0">Sophie London</h5>
                        <h6 class="text-primary mb-0">@sophietherude</h6>
                    </div>

                    <ul class="list-unstyled mb-0">
                        <li class="card-text"><b>Suspension date:</b> 15 January 2021</li>
                        <li class="card-text"><b>Suspension duration:</b> 7 days</li>
                        <li class="card-text"><b>Motive:</b> spamming in comments</li>
                    </ul>
                </div>

                <div class="d-flex gap-1 flex-column">
                    <button class="btn btn-secondary" aria-label="Edit"><i class="fa fa-pencil"></i></button>
                    <button class="btn btn-danger" aria-label="Remove"><i class="fa fa-remove"></i></button>
                </div>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-md-flex gap-3 align-items-center">
                    <div class="mb-1">
                        <h5 class="card-title mb-0">Joseph Dolyov</h5>
                        <h6 class="text-primary mb-0">@jdolyov12</h6>
                    </div>

                    <ul class="list-unstyled mb-0">
                        <li class="card-text"><b>Suspension date:</b> 10 January 2021</li>
                        <li class="card-text"><b>Suspension duration:</b> 14 days</li>
                        <li class="card-text"><b>Motive:</b> posting link to malicious website</li>
                    </ul>
                </div>

                <div class="d-flex gap-1 flex-column">
                    <button class="btn btn-secondary" aria-label="Edit"><i class="fa fa-pencil"></i></button>
                    <button class="btn btn-danger" aria-label="Remove"><i class="fa fa-remove"></i></button>
                </div>
            </li>
        </ul>
    </section>

    <section id="bannedUsers">
        <h2>Banned users</h2>

        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-md-flex gap-3 align-items-center">
                    <div class="mb-1">
                        <h5 class="card-title mb-0">David Horton</h5>
                        <h6 class="text-primary mb-0">@davidthehorton</h6>
                    </div>

                    <ul class="list-unstyled mb-0">
                        <li class="card-text"><b>Ban date:</b> 5 January 2021</li>
                        <li class="card-text"><b>Motive:</b> repeated offensive behaviour</li>
                    </ul>
                </div>

                <div class="d-flex gap-1 flex-column">
                    <button class="btn btn-danger" aria-label="Remove"><i class="fa fa-remove"></i></button>
                </div>
            </li>
        </ul>
    </section>
</div>

<? include_once('../templates/footer.php') ?>