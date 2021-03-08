<?php
    include_once('../templates/header.php');
?>
<div class="container-fluid p-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sign Up</li>
        </ol>
    </nav>
    <div class="align-self-center text-center">
        <h1 class="display-4">Create your Account</h1>
        <div class="d-grid gap-4">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <form>
                        <div class="mb-3 text-start">
                            <label for="username" class="form-label">
                                Username *
                            </label>
                            <input type="text" class="form-control" id="username">
                            
                            <label for="email" class="form-label">
                                Email address *
                            </label>
                            <input type="email" class="form-control" id="email">
                            
                            <label for="password" class="form-label">
                                Password *
                            </label>
                            <input type="password" class="form-control" id="password">

                            <label for="passwordConfirm" class="form-label">
                                Confirm your Password *
                            </label>
                            <input type="password" class="form-control" id="passwordConfirm">
                        </div>
                        <div class="d-grid col-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                Create Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="d-grid col-12">
                        <button type="button" class="btn btn-outline-primary btn-block">
                            Sign up with your <img src="../assets/google.png" class="google" alt="Google"> Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include_once('../templates/footer.php');
?>
