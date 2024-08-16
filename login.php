<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN - LNHS Research Hub</title>
    <link rel="icon" href="./assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mainStyle.css"> <!-- Ensure this is correctly linked -->
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
        <!-- Login Section -->
        <section class="login-section d-flex justify-content-center align-items-center min-vh-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body p-4">
                                <h3 class="card-title text-center mb-4">Login</h3>
                                <form>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" placeholder="Enter your username" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
