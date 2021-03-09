<?php
    include_once('../templates/header.php');
?>
<div class="container-fluid p-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Password Recovery</li>
        </ol>
    </nav>
    <div class="align-self-center text-center">
        <h1 class="display-4">Password Recovery</h1>
        <div class="d-grid gap-4">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="border border-3">
                        <div class="container-fluid p-3">
                            <p>
                                Enter a new password for your account.
                            </p>
                            <form>
                                <div class="mb-3 text-start">
                                    <label for="password" class="form-label">
                                        Password *
                                    </label>
                                    <input type="password" class="form-control" id="password">
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="passwordConfirm" class="form-label">
                                        Confirm your Password *
                                    </label>
                                    <input type="password" class="form-control" id="passwordConfirm">
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Confirm
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include_once('../templates/footer.php');
?>
