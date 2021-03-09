<?php
    include_once('../templates/header.php');
?>
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sign in</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="bg-light">
                <div class="container-fluid p-3">
                    <h1 class="text-center">Sign in</h1>
                    <div class="d-grid gap-4">
                        <div class="row justify-content-center">
                            <div class="col-10">
                                <form>
                                    <div class="mb-3 text-start">
                                        <label for="username" class="form-label">Username *</label>
                                        <input type="text" class="form-control" id="username" required>
                                        <div class="col d-flex justify-content-between">
                                            <label for="password" class="form-label">Password *</label>
                                            <a class="text-primary" href="recover.php"> Forgot your password?</a>
                                        </div>
                                        <input type="password" class="form-control" id="password" required>
                                    </div>
                                    <div class="d-grid col-12">
                                        <button type="submit" class="btn btn-primary btn-block">
                                        Sign in
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-10">
                                <div class="d-grid col-12">
                                    <button type="button" class="btn btn-outline-primary btn-block">
                                        Sign in with your <img src="../assets/google.png" class="google" alt="Google"> Account
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 text-center">
                            <div class="container-fluid ml-2">
                                <label for="password" class="form-label">
                                New to Eventure?
                                </label>
                                <a class="text-primary" href="sign_up.php"> Sign up</a>
                                <label for="password" class="form-label">
                                now!
                                </label>
                            </div>
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