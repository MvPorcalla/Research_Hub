<?php
include_once "..\..\includes\db.php";

if (!isset($_SESSION['user_type'])) {
    header("location: ../../index.php");
    exit;
} elseif ($_SESSION['user_type'] != 'A') {
    header("location: ../../backend/logout.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - LNHS Research Hub</title>
    <?php include './../admin/components/links-head-css.php'; ?>

    <style>
        .setting-info-title {
            font-size: var(--fs-lg);
            font-weight: var(--fw-semibold);
            color: var(--text-base-lt);
        }
        .setting-profile-pic {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
        .setting-name-text {
            font-size: var(--fs-2xl);
            font-weight: var(--fw-semibold);
            color: var(--text-base);
        }
        .setting-username-text {
            font-size: var(--fs-lg);
            font-weight: var(--fw-medium);
            color: var(--text-base-lt);
        }
    </style>
</head>

<body>
    <!-- header -->
    <?php include './../admin/components/header.php'; ?>

    <!-- main content with sidebar -->
    <div class="container-fluid">
        <div class="row text-center">
            <!-- sidebar -->
            <?php include './../admin/components/sidebar.php'; ?>

            <!-- Main content area -->
            <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4 mt-5">
                <div class="row">
                    <div class="container">
                        <div class='card border-dark bg-transparent'>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Personal Information -->
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body p-4">
                                                <h1 class="setting-info-title text-start">Personal Information</h1>
                                                <hr class="border-2 border-secondary mb-2">

                                                <div class="row align-items-center">
                                                    <!-- Image Column -->
                                                    <div class="col-md-2 text-center">
                                                        <img id="idImage" src="#" alt="User Image" class="setting-profile-pic img-fluid rounded-circle mb-2">
                                                    </div>

                                                    <!-- Info Column -->
                                                    <div class="col-md-6 text-start">
                                                        <!-- Display Current Name -->
                                                        <h2 id="completeName" class="setting-name-text mb-1" data-user-id="<?php echo $_SESSION['user_id']; ?>"></h2>

                                                        <!-- Container for Username and Email Address -->
                                                        <div class="d-flex flex-column flex-md-row align-items-center">
                                                            <h2 id="userName" class="setting-username-text mb-0"></h2>
                                                            <span class='mx-2'> | </span>
                                                            <h2 id="emailAdd" class="setting-username-text mb-0"></h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <!-- Notification -->
                                 <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card text-start">
                                                    <div class="card-body p-4">
                                                        <h1 class="setting-info-title">Notification</h1>
                                                        <hr class="border-2 border-secondary mb-2">

                                                        <form>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                                                <label class="form-check-label fw-bold" for="emailNotifications">
                                                                    Send notifications by email
                                                                </label>
                                                                <p class='ms-3'>
                                                                    You’ll still get other emails from Research Hub
                                                                </p>
                                                            </div>
                                                            
                                                            <div class="form-check mt-2">
                                                                <input class="form-check-input" type="checkbox" id="comments">
                                                                <label class="form-check-label fw-bold" for="comments">
                                                                    Comments
                                                                </label>
                                                            </div>
                                                            <div class="form-check mt-2">
                                                                <input class="form-check-input" type="checkbox" id="reactions">
                                                                <label class="form-check-label fw-bold" for="reactions">
                                                                    Reactions
                                                                </label>
                                                            </div>
                                                            <div class="form-check mt-2">
                                                                <input class="form-check-input" type="checkbox" id="newUploads">
                                                                <label class="form-check-label fw-bold" for="newUploads">
                                                                    New upload research
                                                                </label>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card text-start">
                                                    <div class="card-body p-4">
                                                        <h1 class="setting-info-title">Activity</h1>
                                                        <hr class="border-2 border-secondary mb-2">

                                                        <div class="row my-3">
                                                            <div class="col-md-12">
                                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                                                    Edit Profile
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editPassModal">
                                                                    Edit password
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 

                                    </div>

                                    <!-- Logout Button -->
                                    <div class="mt-3">
                                        <div class="col-md-12 text-center">
                                            <form action="../../backend/logout.php" method="post">
                                                <button type="submit" class="btn btn-danger w-100">Logout</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal for edit profile -->
                                <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="formWithPassword" action="../../backend/update_profile.php" method="post">
                                                    <div class='text-start'>
                                                        <div class="row">
                                                            <div class="col-md-5 mb-3">
                                                                <label for="lastName" class="form-label fw-bold">Last Name</label>
                                                                <input type="text" class="form-control" id="lastName" name="lastName">
                                                            </div>
                                                            <div class="col-md-5 mb-3">
                                                                <label for="firstName" class="form-label fw-bold">First Name</label>
                                                                <input type="text" class="form-control" id="firstName" name="firstName">
                                                            </div>
                                                            <div class="col-md-2 mb-3">
                                                                <label for="middleInitial" class="form-label fw-bold">M.I.</label>
                                                                <input type="text" class="form-control" id="middleInitial" name="middleInitial" maxlength="1">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label for="usernameField" class="form-label fw-bold">Username</label>
                                                                <input type="text" class="form-control" id="usernameField" name="usernameField">
                                                            </div>
                                                        </div>

                                                        <!-- email -->
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label for="emailField" class="form-label fw-bold">Email</label>
                                                                <input type="email" class="form-control" id="emailField" name="emailField">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <button type="submit" class="btn btn-primary btn-block w-100">Save Changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal for editing password -->
                                <div class="modal fade" id="editPassModal" tabindex="-1" aria-labelledby="editPassModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="editPassModalLabel">Edit Password</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../../backend/update_password.php" method="post">
                                                    <div class='text-start'>
                                                        <div class="mb-3">
                                                            <label for="currentPassword" class="form-label fw-bold">Current Password</label>
                                                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label for="newPassword" class="form-label fw-bold">New Password</label>
                                                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="confirmNewPassword" class="form-label fw-bold">Confirm New Password</label>
                                                            <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" required>
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary btn-block w-100">Save Changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    
                            </div>
                        </div>

                    </div>
                </div>
            </main>

        </div>
    </div>

    <?php include './../admin/components/links-footer-script.php'; ?>

    <script src="../../includes/functions.js"></script>
    <script src="../../scripts/fetchOneRecord.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            confirmPassword();
            handleStatus('editInfo');
        });
    </script>
</body>

</html>