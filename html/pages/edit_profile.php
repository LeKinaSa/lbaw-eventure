<? include_once('../templates/header.php') ?>

<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="homepage.php">Home</a></li>
            <li class="breadcrumb-item"><a class="text-primary" href="profile.php">Profile</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
        </ol>
    </nav>
    
    <div class="row justify-content-md-center">
        <div class="col-md-7">
            <form class="mb-3">
                <h1 class="text-center">Edit Profile</h1>

                <div class="mb-3">
                    <label for="name" class="h5 form-label">Name *</label>
                    <input type="text" id="name" name="name" class="form-control" value="John Doe" required>
                </div>

                <div class="mb-3">
                    <label for="username" class="h5 form-label">Username *</label>
                    <input type="text" id="name" name="username" class="form-control" value="johndoe123" required>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label for="email" class="h5 form-label">Email *</label>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="displayEmail" name="displayEmail" checked>
                            <label for="displayEmail" class="form-check-label">Display in profile</label>
                        </div>
                    </div>
                    <input type="email" id="email" name="email" class="form-control" value="johndoe@gmail.com" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="h5 form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Tell us a bit about yourself">I'm an avid reader and I am interested in trading card games. I frequently compete in Magic: The Gathering events and my favorite format is Draft. I also like to play some chess from time to time.</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                    <h5>Gender</h5>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="male" name="gender" checked>
                        <label for="male" class="form-check-label">Male</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="female" name="gender">
                        <label for="female" class="form-check-label">Female</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="other" name="gender">
                        <label for="other" class="form-check-label">Other</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="notSpecified" name="gender">
                        <label for="notSpecified" class="form-check-label">Prefer not to say</label>
                    </div>
                    </div>
                    <div class="col-md-9">
                        <label for="age" class="h5 form-label">Age</label>
                        <input type="number" id="age" name="age" class="form-control" value="25" min="13" max="150">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="location" class="h5 form-label">Location</label>
                    <input type="text" id="location" name="location" class="form-control" value="Liverpool, UK">
                </div>

                <div class="mb-3">
                    <label for="website" class="h5 form-label">Website</label>
                    <input type="text" id="website" name="website" class="form-control" value="www.johndoeblog.com">
                </div>

                <div class="mb-3">
                    <label for="image" class="h5 form-label">Profile Picture</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/x-png,image/jpeg">
                </div>

                <div class="d-flex justify-content-center">
                    <input type="submit" class="btn btn-primary" value="Save">
                </div>
            </form>

            <h4>Sensitive actions</h4>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    Change password
                </button>
                <button class="btn btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    Delete account
                </button>
            </div>
        </div>
        
        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordLabel">Change password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="password" class="form-label">Current Password *</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label for="newPassword" class="form-label">New Password *</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                            </div>

                            <div class="mb-3">
                                <label for="newPasswordConfirm" class="form-label">Confirm your New Password *</label>
                                <input type="password" class="form-control" id="newPasswordConfirm" name="newPasswordConfirm" required>
                            </div>

                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="Change">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteAccountLabel">Delete account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><b>Warning:</b> deleting your account is irreversible. All the events you are organizing will be
                        permanently deleted, and comments you have posted will no longer display your username. Votes you 
                        made on polls will also be removed.</p>

                        <p>If you are sure you wish to delete your account, please enter your current password below.</p>
                        
                        <form>
                            <div class="mb-3">
                                <label for="passwordDelete" class="form-label">Current Password *</label>
                                <input type="password" class="form-control" id="passwordDelete" name="password" required>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-danger" value="Delete">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<? include_once('../templates/footer.php') ?>