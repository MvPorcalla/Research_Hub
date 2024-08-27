<?php
include_once "..\..\includes\db.php";
if ($_SESSION['user_type'] != 'A') header("location: ../../index.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - LNHS Research Hub</title>
    <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/mainStyle.css">

    <style>
        .admin-info-title {
            font-size: var(--fs-xl);
            font-weight: var(--fw-semibold);
            color: var(--text-base-lt);
        }
        .admin-profile-pic {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
        .admin-name-text {
            font-size: var(--fs-2xl);
            font-weight: var(--fw-semibold);
            color: var(--text-base);
        }
        .admin-username-text {
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
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-body p-4">
                                                <h1 class="admin-info-title text-center">Personal Information</h1>
                                                <hr class="border-2 border-secondary mb-4">

                                                <div class="row align-items-center">
                                                    <div class="col-md-12 text-center">
                                                        <img id="idImage" src="#" alt="Admin Image" class="admin-profile-pic img-fluid rounded-circle mb-2">
                                                        <div>
                                                            <!-- Display Current Name and Username -->
                                                            <h2 id="completeName" class="admin-name-text mb-1" data-user-id="<?php echo $_SESSION['user_id']; ?>"></h2>
                                                            <h2 id="userName" class="admin-username-text"></h2>
                                                            <h2 id="emailAdd" class="admin-username-text mb-3"></h2>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr class="border-2 border-secondary mb-4">

                                                <!-- Editable Fields -->
                                                <div class="text-start">
                                                    <form action="../../backend/update_profile.php" method="post">
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <label for="lastName" class="form-label">Last Name</label>
                                                                <input type="text" class="form-control" id="lastName" name="lastName">
                                                            </div>
                                                            <div class="col-md-5">
                                                                <label for="firstName" class="form-label">First Name</label>
                                                                <input type="text" class="form-control" id="firstName" name="firstName">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label for="middleInitial" class="form-label">M.I.</label>
                                                                <input type="text" class="form-control" id="middleInitial" name="middleInitial" maxlength="1">
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Username -->
                                                        <div class="col-md-12 mt-3">
                                                            <label for="usernameField" class="form-label">Username</label>
                                                            <input type="text" class="form-control" id="usernameField" name="usernameField">
                                                        </div>

                                                        <!-- Save Changes Button -->
                                                        <div class="col-md-12 mt-3 text-center">
                                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Notification -->
                                    <div class="col-md-4 text-start">
                                        <div class="row">
                                            <div class="card">
                                                <div class="card-body p-4">
                                                    <h1 class="admin-info-title text-center">Notification</h1>
                                                    <hr class="border-2 border-secondary mb-4">

                                                    <form>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                                            <label class="form-check-label" for="emailNotifications">
                                                                Send notifications by email
                                                            </label>
                                                            <p class='ms-3'>
                                                                You’ll still get other <br>
                                                                emails from Research Hub
                                                            </p>
                                                        </div>
                                                        
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input" type="checkbox" id="comments">
                                                            <label class="form-check-label" for="comments">
                                                                Comments
                                                            </label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input" type="checkbox" id="reactions">
                                                            <label class="form-check-label" for="reactions">
                                                                Reactions
                                                            </label>
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input" type="checkbox" id="newUploads">
                                                            <label class="form-check-label" for="newUploads">
                                                                New upload research
                                                            </label>
                                                        </div>
                                                    </form>
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

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </main>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="..\..\includes\functions.js"></script>
    <script src="../../scripts/fetchOneRecord.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('editInfo');
        });
    </script>
</body>

</html>