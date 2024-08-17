<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORGOT PASSWORD - LNHS Research Hub</title>
    <link rel="icon" href="./assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mainStyle.css">

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
        <!-- Login Section -->
        <div class="container d-flex justify-content-center align-items-center">
            <div class="card login-card">
                <div class="card-body p-4">
                    <h3 class="login_card-title text-center mb-4">Forgot Password</h3>
                    <form action="backend\forgot_password.php" method="POST">
                        <div class="">
                            <label for="email" class="form-label">Enter your email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email"
                                required>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary">Send Reset Password Link</button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const resetStatus = urlParams.get('reset');

            switch (resetStatus) {
                case "success":
                    Swal.fire({
                        icon: "success",
                        title: "Password Reset Link Sent!",
                        text: "The link will be sent you shortly. Please check your email."
                    });
                    break;
                case "failed":
                    Swal.fire({
                        icon: "error",
                        title: "Password Reset Failed",
                        text: "No account found with that email address."
                    });
                    break;
            }
            let url = new URL(window.location.href);
            url.searchParams.delete('reset');
            window.history.replaceState({}, document.title, url.toString());
        });
    </script>
</body>

</html>