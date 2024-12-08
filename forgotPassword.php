<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORGOT PASSWORD - LNHS Research Hub</title>
    <link rel="icon" href="./assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/mainStyle.css">
    <link rel="stylesheet" href="css/bgStyle.css">

    <style>
        .login-card {
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php
    include './includes/header.php';
    ?>

    <main>
        <!-- Forgot Password Section -->
        <div class="container d-flex justify-content-center align-items-center">
            <div class="card login-card">
                <div class="card-body p-4">

                    <h3 class="login_card-title text-center mb-4">Forgot Password</h3>
                    <form id="forgotPasswordForm" action="" method="POST">

                        <input type="text" name="website_name" id="website_name" hidden value="Research Hub">
                        <input type="text" name="user_firstname" id="user_firstname" hidden>
                        <input type="text" name="reset_link" id="reset_link" hidden>

                        <div class="my-5">
                            <label for="email" class="form-label required">Email Address</label>
                            <input type="email" class="form-control" id="email" name="user_email" placeholder="Enter your email address" required autocomplete="email">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" id="resetButton">Send Reset Password Link</button>
                        </div>

                        <div class="card-footer text-center">
                            <small> <a href="./login.php">Go back</a></small>
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
    <script src="scripts/forgotPassword.js"></script>
    <script src="includes/functions.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('token');
        });
    </script>
</body>

</html>