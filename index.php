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
            background-repeat: repeat;
            height: 100vh;
            margin: 0;
        }

        /* Styling for the login form to be positioned at the left center */
        .login-form {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            color: white;
            background: transparent;
            width: 350px;
            padding: 20px;
            border: 2px solid white;
            box-shadow: 5px 5px 10px black;
            border-radius: 20px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="hero-header-bg p-2">
        <div class="container d-flex align-items-center">
            <div class="d-flex align-items-center">
                <img src="./assets/icons/LNHS-icon.png" alt="icon" class="rounded-circle ms-3 me-3 hero-header-icon">
                <div>
                    <h1 class="hero-header-title mb-0">Ligao National High School</h1>
                    <h2 class="hero-header-title mb-0">Research Hub</h2>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="login-form ms-5">
                <h3 class="text-center mb-4 mt-4">MEMBER LOGIN</h3>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary" name="login">Login</button>
                    <button type="button" class="btn btn-secondary" name="register">Register</button>
                </div>
            </div>
        </section>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
