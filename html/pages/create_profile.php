<? include_once('../templates/header.php') ?>

<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Profile</li>
        </ol>
    </nav>
    
    <div class="d-grid gap-3">
        <div class="row justify-content-md-center">
            <form class="col-md-8">
                <h1 class="text-center">Create Profile</h1>

                <div class="mb-3">
                    <label for="username" class="h5 form-label">Username *</label>
                    <input type="text" id="name" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="name" class="h5 form-label">Name *</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="h5 form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Tell us a bit about yourself"></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                    <h5>Gender *</h5>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="female" name="gender">
                        <label for="female" class="form-check-label"><i class="fa fa-venus"></i> Female</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="male" name="gender">
                        <label for="male" class="form-check-label"><i class="fa fa-mars"></i> Male</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="undefined" name="gender" checked required>
                        <label for="undefined" class="form-check-label"><i class="fa fa-question"></i> Prefer Not To Say</label>
                    </div>
                    </div>
                    <div class="col-md-9">
                        <label for="age" class="h5 form-label">Age</label>
                        <input type="text" id="age" name="age" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="h5 form-label">Email *</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="h5 form-label">Address</label>
                    <input type="text" id="address" name="address" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="link" class="h5 form-label">Link</label>
                    <input type="text" id="link" name="link" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="image" class="h5 form-label">Profile Picture</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/x-png,image/jpeg">
                </div>

                <div class="row justify-content-center">
                    <div class="col-1">
                        <input type="submit" class="btn btn-primary" value="Create">
                    </div>
                </div>
            </form>
            <div class="col-md-8">
                <div class="row justify-content-start">
                    <div class="col-3">
                        <div class="d-grid">
                            <button class="btn btn-outline-danger btn-block" type="button" data-bs-toggle="collapse" data-bs-target="#sensitiveData" aria-expanded="false" aria-controls="sensitiveData">
                                Sensitive Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <form class="col-md-8">
                <div class="collapse" id="sensitiveData">
                    <div class="card card-body">
                        <h5 class="card-title">Change Password</h5>
                        <div class="card-text">
                            <p class="text-start">
                                <label for="password" class="form-label">Current Password *</label>
                                <input type="password" class="form-control" id="password" required>
                                <label for="newPassword" class="form-label">New Password *</label>
                                <input type="password" class="form-control" id="newPassword">
                                <label for="passwordConfirm" class="form-label">Confirm your New Password *</label>
                                <input type="password" class="form-control" id="passwordConfirm">
                            </p>
                            <button class="btn btn-outline-primary">Change</button>
                        </div>
                    </div>
                </div>
            </form>
            <form class="col-md-8 mt-3">
                <div class="collapse" id="sensitiveData">
                    <div class="row justify-content-end">
                        <div class="col-4">
                            <div class="card card-body">
                                <div class="card-text">
                                    <label for="password" class="form-label">Current Password *</label>
                                    <input type="password" class="form-control" id="password" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-4 mt-1">
                            <div class="d-grid">
                                <button class="btn btn-danger btn-sm">
                                    Delete Account
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<? include_once('../templates/footer.php') ?>