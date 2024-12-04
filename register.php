<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER - LNHS Research Hub</title>
    <link rel="icon" href="./assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mainStyle.css">
    
    <style>
        body {
            background:
                /* top, transparent black, faked with gradient */ 
                linear-gradient(
                    rgba(0, 0, 0, 0.0), 
                    rgba(0, 0, 0, 0.4)
                ),
                /* bottom, image */
                url('./assets/images/registerPageBg.png');
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
    <?php include 'includes/header.php'; ?>
    
    <main class="mt-5">
        <div class="container py-5 mt-5">
            <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <img class="register-icon mb-4" src="./assets/icons/Vector.png" alt="icon">
                <h1 class="register-text mb-5">Register</h1>
            </div>
            <div class="row d-flex item-align-center justify-content-center">
                <!-- Student Card -->
                <div class="col-md-4">
                    <a href="./registerStudent.php" class="text-decoration-none">
                        <div class="register_card">
                            <h1 class="register_card-text mb-0">Student</h1>
                        </div>
                    </a>
                </div>

                <!-- teacer Card -->
                <div class="col-md-4">
                    <a href="./registerTeacher.php" class="text-decoration-none">
                        <div class="register_card">
                            <h1 class="register_card-text mb-0">Teacher</h1>
                        </div>
                    </a>
                </div>

                <!-- Guest Card -->
                <div class="col-md-4">
                    <a href="./registerGuest.php" class="text-decoration-none">
                        <div class="register_card">
                            <h1 class="register_card-text mb-0">Guest</h1>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
