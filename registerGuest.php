<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER - LNHS Research Hub</title>
    <link rel="icon" href="./assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mainStyle.css"> <!-- Ensure this is correctly linked -->
</head>

<body>
    <!-- Header -->
    <?php
        include 'includes/header.php';
    ?>

    <main>
        <!-- Register Section -->
        <section class="register-section">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header text-center">
                                <h3>Sign Up</h3>
                            </div>
                            <div class="card-body">
                                <form action="#" method="POST" enctype="multipart/form-data">
                                    <!-- Name, Last Name, M.I. -->
                                    <div class="row mb-3">
                                        <div class="col-md-5">
                                            <label for="firstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="firstName" name="firstName" required>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="lastName" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" name="lastName" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="middleInitial" class="form-label">M.I.</label>
                                            <input type="text" class="form-control" id="middleInitial" name="middleInitial" maxlength="1">
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                    </div>

                                    <!-- School -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="text" class="form-label">School</label>
                                            <input type="text" class="form-control" id="school" name="school" required>
                                        </div>
                                    </div>

                                    <!-- Upload ID Image -->
                                    <div class="mb-3">
                                        <label for="idImage" class="form-label">Upload ID Image</label>
                                        <input type="file" class="form-control" id="idImage" name="idImage" accept="image/*" required>
                                    </div>

                                    <!-- Password and Confirm Password -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                        </div>
                                    </div>
                                    
                                    <!-- Reason -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="reason" class="form-label">Reason</label>
                                            <textarea class="form-control" id="reason" name="reason" rows="4" required></textarea>
                                        </div>
                                    </div>


                                    <!-- Submit Button -->
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Register</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center">
                                <small>Already have an account? <a href="#">Login here</a></small>
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
