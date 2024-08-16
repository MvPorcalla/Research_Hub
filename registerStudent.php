<?php include_once "includes\db.php"; ?>

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
                                <form action="backend\register.php" method="POST" enctype="multipart/form-data">
                                    <!-- Role -->
                                    <div class="row mb-3" hidden>
                                        <label for="role" class="form-label">Role</label>
                                        <input type="text" class="form-control" id="role" name="role" required
                                            value="S">
                                    </div>

                                    <!-- Name, Last Name, M.I. -->
                                    <div class="row mb-3">
                                        <div class="col-md-5">
                                            <label for="firstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="firstName" name="firstName"
                                                required>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="lastName" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" name="lastName"
                                                required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="middleInitial" class="form-label">M.I.</label>
                                            <input type="text" class="form-control" id="middleInitial"
                                                name="middleInitial" maxlength="1">
                                        </div>
                                    </div>

                                    <!-- Username and Email -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                    </div>

                                    <!-- LRN / Student Number -->
                                    <div class="mb-3">
                                        <label for="lrn" class="form-label">LRN / Student Number</label>
                                        <input type="text" class="form-control" id="lrn" name="lrn" required>
                                    </div>

                                    <!-- Track/Strand -->
                                    <div class="mb-3">
                                        <label for="trackStrand" class="form-label">Track/Strand</label>
                                        <input type="text" class="form-control" id="trackStrand" name="trackStrand"
                                            required>
                                    </div>

                                    <!-- Upload ID Image -->
                                    <div class="mb-3">
                                        <label for="idImage" class="form-label">Upload ID Image</label>
                                        <input type="file" class="form-control" id="idImage" name="idImage"
                                            accept="image/*" required>
                                    </div>

                                    <!-- Password and Confirm Password -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirmPassword"
                                                name="confirmPassword" required>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            form.addEventListener('submit', function (e) {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmPassword').value;

                if (password !== confirmPassword) {
                    e.preventDefault(); // Prevent form submission
                    Swal.fire({
                        icon: "error",
                        title: "Passwords do not match!",
                        text: "Please try again."
                    });
                }
            });

            const urlParams = new URLSearchParams(window.location.search);
            const registrationStatus = urlParams.get('registration');

            switch (registrationStatus) {
                case "wronglrn":
                    Swal.fire({
                        icon: "error",
                        title: "Wrong LRN!",
                        text: "Your LRN does not exist in the database."
                    });
                    break;
                case "existing":
                    Swal.fire({
                        icon: "error",
                        title: "LRN already registered!",
                        text: "Your LRN has already been registered to an account."
                    });
                    break;
                case "failed":
                    Swal.fire({
                        icon: "error",
                        title: "Oops!",
                        text: "Your registration failed. Please try again."
                    });
                    break;
            }
        });
    </script>
</body>

</html>