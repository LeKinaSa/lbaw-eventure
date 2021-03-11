<?php
    include_once('../templates/header.php');
?>
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Password Recovery</li>
        </ol>
    </nav>
    
    <div class="row justify-content-center">
        <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4 bg-light p-3">
            <h1 class="text-center">Password Recovery</h1>
            <p class="text-center">Enter a new password for your account.</p>

            <form class="d-flex flex-column justfiy-content-center">
                <div class="mb-3 text-start">
                    <label for="password" class="form-label">Password *</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3 text-start">
                    <label for="passwordConfirm" class="form-label">Confirm your Password *</label>
                    <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" required>
                </div>
                <input type="submit" class="btn btn-primary" value="Confirm">
            </form>
        </div>
    </div>
</div>
<?php
    include_once('../templates/footer.php');
?>
