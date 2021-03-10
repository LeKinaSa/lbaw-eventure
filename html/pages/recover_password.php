<? include_once('../templates/header.php'); ?>

<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Password Recovery</li>
        </ol>
    </nav>

    <div class="align-self-center text-center">
        <h1 class="display-4">Password Recovery</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="border border-3">
                    <div class="container-fluid p-3">
                        <p>Enter your account's email address and we will send you a link to reset your password.</p>
                        <form>
                            <div class="mb-3 text-start">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <input type="submit" class="btn btn-primary" value="Send email">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<? include_once('../templates/footer.php'); ?>
