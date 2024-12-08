<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN - LNHS Research Hub</title>
    <link rel="icon" href="./assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mainStyle.css">
    <link rel="stylesheet" href="css/bgStyle.css">

    <style>
        .login-card {
            width: 100%; 
            max-width: 500px;
            position: relative; /* Position relative for absolute children */
            padding-top: 40px; /* Space for the logo */
        }

        .logo {
            position: absolute; /* Absolute positioning for overlap */
            top: -60px; /* Adjust to move the logo above the card */
            left: 50%;
            transform: translateX(-50%); /* Center the logo */
            max-width: 130px; /* Adjust size as needed */
            background-color: transparent; /* Optional: Background for visibility */
            padding: 5px; /* Optional: Space around the logo */
            border-radius: 10px; /* Optional: Rounded corners */
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
                <img src="./assets/icons/LNHS-icon.png" alt="LNHS Logo" class="logo rounded-circle">
              
                <div class="card-body p-4">
                    <h3 class="login_card-title text-center mt-3 mb-4">Login</h3>
                    <form action="backend/login.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label required">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                        </div>
                        <div class="mb-2">
                            <label for="password" class="form-label required">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                        </div>

                        <div class="mb-2 d-flex justify-content-end">
                            <a href="forgotPassword.php" class="text-decoration-none">Forgot Password? </a>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary fs-4">Log in</button>
                        </div>
                    </form>
                    
                    <div class="card-footer text-center">
                        <small>Don't have an account? <a href="./register.php">Register here</a></small>
                    </div>
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
            handleStatus('login');
            handleStatus('reset');
        });
    </script>
</body>

</html>
