<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN - LNHS Research Hub</title>
    <link rel="icon" href="./assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mainStyle.css">

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
                    <h3 class="login_card-title text-center mb-4">Login</h3>
                    <form action="backend\login.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                        </div>
                        <div class="mb-2">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                        </div>

                        <div class="mb-2 d-flex justify-content-end">
                            <a href="forgotPassword.php" class="text-decoration-none">Forgot Password? </a>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                    
                    <div class="card-footer text-center">
                        <small>Dont have an account? <a href="./register.php">Register here</a></small>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="includes\functions.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('login');
        });
    </script>
</body>

</html>
