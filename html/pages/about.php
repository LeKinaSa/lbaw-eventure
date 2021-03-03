<? include_once('../templates/header.php'); ?>

<div class="container-fluid p-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">About</li>
        </ol>
    </nav>

    <div class="d-grid gap-4">
        <div class="row">
            <div class="col-lg">
                <img src="../assets/computers.jpg" class="img-fluid" alt="Several computer setups for gaming">
            </div>
            <div class="col align-self-center text-center">
                <h1 class="display-4">A dedicated platform for tournaments and competitions</h1>
                <p class="fs-4">Eventure provides tournament organizers tools to schedule matches, post results and automatically generate leaderboards. 
                These tools are customisable and can be adapted to several kinds of tournaments and games</p>
            </div>
        </div>

        <div class="row">
            <div class="col align-self-center text-center">
                <h1 class="display-4">A way to interact with the community</h1>
                <p class="fs-4">We know the importance of the feeling of community and social interaction in these events, 
                so Eventure grants you several ways to interact with the community and get feedback so you can 
                craft the best experience possible.</p>
            </div>
            <div class="col-lg">
                <img src="../assets/evo.jpg" class="img-fluid" alt="Several computer setups for gaming">
            </div>
        </div>
    </div>
</div>

<? include_once('../templates/footer.php'); ?>