@extends('layouts.app')

@section('content')
<div class="container py-3">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-primary" href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a class="text-primary" href="{{ route('users.profile', ['username' => $user->username]) }}">Profile</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
    
    <div class="row justify-content-md-center">
        <div class="col-md-7">
            <form method="POST" enctype="multipart/form-data" class="mb-3" action="{{ route('users.profile.edit', ['username' => $user->username]) }}">
                {{ csrf_field() }}

                <h1 class="text-center">Edit Profile</h1>

                <div class="mb-3">
                    <label for="name" class="h5 form-label">Name *</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
                    @error ('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="username" class="h5 form-label">Username *</label>
                    <input type="text" id="username" name="username" class="form-control" value="{{ $user->username }}" required>
                    @error ('username')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label for="email" class="h5 form-label">Email *</label>
                    </div>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    @error ('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="h5 form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Tell us a bit about yourself">{{ $user->description }}</textarea>
                    @error ('description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <h5>Gender</h5>

                        @foreach (['Male', 'Female', 'Other'] as $gender)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="{{ strtolower($gender) }}" name="gender" value="{{ $gender }}" {{ $user->gender === $gender ? 'checked' : '' }}>
                            <label for="{{ strtolower($gender) }}" class="form-check-label">{{ $gender }}</label>
                        </div>
                        @endforeach
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="unspecified" name="gender" value="Unspecified" {{ is_null($user->gender) ? 'checked' : '' }}>
                            <label for="unspecified" class="form-check-label">Prefer not to say</label>
                        </div>

                        @error ('gender')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-9">
                        <label for="age" class="h5 form-label">Age</label>
                        <input type="number" id="age" name="age" class="form-control" value="{{ $user->age }}" min="13" max="150">
                        @error ('age')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="location" class="h5 form-label">Location</label>
                    <input type="text" id="location" name="location" class="form-control" value="{{ $user->address }}">
                    @error ('location')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="website" class="h5 form-label">Website</label>
                    <input type="text" id="website" name="website" class="form-control" value="{{ $user->website }}">
                    @error ('website')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="picture" class="h5 form-label">Profile Picture</label>
                    <input type="file" class="form-control" id="picture" name="picture" accept="image/x-png,image/jpeg">
                    @error ('picture')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
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
            @error ('password')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordLabel">Change password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('api.users.user.password.update', ['username' => $user->username]) }}" id="changePasswordForm">
                            @method('PATCH')
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

                            <div class="modal-footer d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-danger mb-0" id="changePasswordError"></p>
                                    <p class="text-success mb-0" id="changePasswordSuccess"></p>
                                </div>
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
                        <p><b>Warning:</b> deleting your account is irreversible. All the events you are organizing and
                        comments you have posted will be permanently deleted. Votes you made on polls will also be removed.</p>

                        <p>If you are sure you wish to delete your account, please enter your current password below.</p>
                        
                        <form method="POST" action="{{ route('users.profile.delete', ['username' => $user->username]) }}">
                            {{ csrf_field() }}

                            @method('DELETE')
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
@endsection