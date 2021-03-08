<?php
    include_once('../templates/header.php');
?>
<div class="container-fluid p-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
            <li class="breadcrumb-item"><a href="events.php">Events</a></li>
            <li class="breadcrumb-item"><a href="event.php">Magic Encounter</a></li>
            <li class="breadcrumb-item active" aria-current="page">Requests to Participate</li>
        </ol>
    </nav>
    <div class="align-self-center text-center">
        <h1 class="display-4">Requests to Participate</h1>
        <div class="d-grid">
            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="container-fluid p-3">
                        <form>
                            <div class="d-grid gap-1 p-2">
                                <div class="row">
                                    <div class="col-11">
                                        <input type="text" class="form-control border-dark" id="invite" placeholder="Invite Someone">
                                    </div>
                                    <div class="col-1">
                                        <button type="submit" class="btn btn-outline-primary btn-block">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="container fluid p-3">
                        <form>
                            <div class="row p-2">
                                <div class="col-5">
                                    <div type="text" class="rounded border border-dark h-100 w-100 text-start p-1">
                                        Accept All
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-outline-success">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </div>
                                <div class="col-5">
                                    <div type="text" class="rounded border border-dark h-100 w-100 text-start p-1">
                                        Deny All
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-outline-danger">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col-10">
                                    <div type="text" class="rounded border border-dark h-100 w-100 text-start p-1">
                                        Afonso Caiado
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-outline-success" id="accept">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-outline-danger" id="deny">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col-10">
                                    <div type="text" class="rounded border border-dark h-100 w-100 text-start p-1">
                                        Clara Martins
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-outline-success" id="accept">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-outline-danger" id="deny">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col-10">
                                    <div type="text" class="rounded border border-dark h-100 w-100 text-start p-1">
                                        Daniel Monteiro
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-outline-success" id="accept">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-outline-danger" id="deny">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row p-2">
                                <div class="col-10">
                                    <div type="text" class="rounded border border-dark h-100 w-100 text-start p-1">
                                        Gonçalo Pascoal
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-outline-success" id="accept">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-outline-danger" id="deny">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include_once('../templates/footer.php');
?>
