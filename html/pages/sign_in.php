<?php
    include_once('../templates/header.php');
?>
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sign in</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4 bg-light p-3">
            <h1 class="text-center">Sign in</h1>

            <form class="d-flex flex-column justify-content-center mb-3">
                <div class="mb-2">
                    <label for="username" class="form-label">Username *</label>
                    <input type="text" class="form-control" id="username" required>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label for="password" class="form-label">Password *</label>
                        <a href="recover.php"> Forgot your password?</a>
                    </div>
                    <input type="password" class="form-control" id="password" required>
                </div>

                <input type="submit" class="btn btn-primary" value="Sign in">
            </form>

            <div class="d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-primary mb-3">
                    Sign in with your <img src="../assets/google.png" class="google" alt="Google"> account
                </button>
                
                <span class="text-center">New to Eventure? <a href="sign_up.php"> Sign up</a> now!</span>
            </div>
        </div>
    </div>
</div>


<?php
    include_once('../templates/footer.php');
?>