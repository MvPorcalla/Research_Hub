<?php include_once "includes\db.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LNHS Research Hub</title>
    <link rel="icon" href="./assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mainStyle.css">
    <style>
        body {
            background-image: url('./assets/images/LNHS-background.png');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-color: #000; /* Fallback color */
            margin: 0;
        }

        

    </style>
</head>

<body>
    <!-- Header -->
    <?php
        include 'includes/header.php';
    ?>

    <!-- main content -->
    <main>
        <div class="container-fluid">
            <div class="row ms-5">
                <div class="login-card py-5">
                    <h3 class="text-center mb-5">MEMBER LOGIN</h3>
                    <div class="d-grid gap-3">
                        <a href="./login.php" class="btn btn-primary" role="button" aria-label="Login">Login</a>
                        <a href="./register.php" class="btn btn-secondary" role="button" aria-label="Register">Register</a>
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
            handleStatus('registration');
        });
    </script>
</body>

</html>
