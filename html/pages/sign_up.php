<? include_once('../templates/header.php'); ?>

<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sign up</li>
        </ol>
    </nav>
    <div class="align-self-center text-center">
        <h1>Sign up</h1>
        <div class="row justify-content-center">
            <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <form>
                    <div class="mb-3 text-start">
                        <label for="name" class="form-label">Name *</label>
                        <input type="text" class="form-control" id="name" name="name">

                        <label for="username" class="form-label">Username *</label>
                        <input type="text" class="form-control" id="username" name="username">
                        
                        <label for="email" class="form-label">Email address *</label>
                        <input type="email" class="form-control" id="email" name="email">
                        
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" class="form-control" id="password" name="password">

                        <label for="passwordConfirm" class="form-label">Confirm your Password *</label>
                        <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm">
                    </div>
                    <div class="d-flex flex-column align-items-stretch gap-3">
                        <button type="submit" class="btn btn-primary btn-block">
                            Create Account
                        </button>

                        <button type="button" class="btn btn-outline-primary">
                            Sign up with your <img src="../assets/google.png" class="google" alt="Google"> Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<? include_once('../templates/footer.php'); ?>
