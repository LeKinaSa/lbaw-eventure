<? include_once('../templates/header.php'); ?>

<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sign up</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4 bg-light p-3">
            <h1 class="text-center">Sign up</h1>

            <form class="d-flex flex-column justify-content-center mb-3">
                <div class="mb-2">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-2">
                    <label for="username" class="form-label">Username *</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-2">
                    <label for="email" class="form-label">Email address *</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label">Password *</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="passwordConfirm" class="form-label">Confirm your Password *</label>
                    <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" required>
                </div>

                <input type="submit" class="btn btn-primary" value="Create accout">
            </form>

            <div class="d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-primary">
                    Sign up with your <img src="../assets/google.png" class="google" alt="Google logo"> account
                </button>
            </div>
        </div>
    </div>
</div>

<? include_once('../templates/footer.php'); ?>
