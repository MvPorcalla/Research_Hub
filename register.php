<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER - LNHS Research Hub</title>
    <link rel="icon" href="./assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mainStyle.css">
</head>
<body>
    <!-- Header -->
    <?php
        include 'includes/header.php';
    ?>
    
    <main>
        <div class="container">
            <div class="row">
                <div class="content d-flex align-items-center justify-content-center">
                    <div class="row">
                        <div>
                            <img class="register-icon" src="./assets/icons/Vector.png" alt="icon">
                        </div>
                    </div>
                    <div class="row">
                        <div class="m-3">
                            <h1 class="register-text">Register</h1>
                        </div>
                    </div>
                    <div class="row g-5">
                        <!-- Student Card -->
                        <div class="col-md-4">
                            <a href="./registerStudent.php" class="text-decoration-none">
                                <div class="register_card d-flex align-items-center justify-content-center p-4">
                                    <h1 class="register_card-text mb-0">Student</h1>
                                </div>
                            </a>
                        </div>

                         <!-- Guest Card -->
                         <div class="col-md-4">
                            <a href="#" class="text-decoration-none">
                                <div class="register_card d-flex align-items-center justify-content-center p-4">
                                    <h1 class="register_card-text mb-0">Admin</h1>
                                </div>
                            </a>
                        </div>
                        
                        <!-- Guest Card -->
                        <div class="col-md-4">
                            <a href="./registerGuest.php" class="text-decoration-none">
                                <div class="register_card d-flex align-items-center justify-content-center p-4">
                                    <h1 class="register_card-text mb-0">Guest</h1>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
