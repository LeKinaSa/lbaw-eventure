<?php
    include_once('../templates/header.php');
?>
<div class="container-fluid p-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Password Recovery</li>
        </ol>
    </nav>
    <div class="align-self-center text-center">
        <h1 class="display-4">Password Recovery</h1>
        <div class="d-grid gap-4">
            <div class="row justify-content-center">
                <div class="col-3">
                    <div class="border border-3">
                        <div class="container-fluid p-3">
                            <p>
                                Enter your account email and we will send you a link to reset your password.
                            </p>
                            <form>
                                <div class="mb-3 text-start">
                                    <label for="email" class="form-label">
                                        Email address
                                    </label>
                                    <input type="email" class="form-control" id="emailForPasswordRecovery">
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Send Email
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
