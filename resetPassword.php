<?php
include_once "includes/db.php";

if (!isset($_GET['token'])) {
    header("Location: index.php");
    exit;
}

$token = $_GET['token'];
$sql = "SELECT * FROM `users` WHERE `user_reset_token` = ?";
$result = query($conn, $sql, [$token]);

if (empty($result) || $current_timestamp >= $result[0]['user_reset_token_expire']) {
    header("Location: forgotPassword.php?token=invalid");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESET PASSWORD - LNHS Research Hub</title>
    <link rel="icon" href="./assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mainStyle.css">
    <link rel="stylesheet" href="css/bgStyle.css">


    <style>
        .login-card {
            width: 100%; 
            max-width: 500px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php
        include './includes/header.php';
    ?>

    <main>
        <!-- Login Section -->
        <div class="container d-flex justify-content-center align-items-center">
            <div class="card login-card">
                <div class="card-body p-4">

                    <h3 class="login_card-title text-center mb-4">Reset Password</h3>

                    <form id="resetPasswordForm" action="backend/reset_password.php" method="POST">

                        <input type="text" class="form-control" name="token" required hidden value="<?php echo $_GET['token']; ?>">

                        <!-- Password and Confirm Password -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="password" class="form-label">Enter your new password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="confirmPassword" class="form-label">Confirm your new password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="includes/functions.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            confirmPassword('resetPasswordForm');
            handleStatus('reset');
        });
    </script>
</body>

</html>
