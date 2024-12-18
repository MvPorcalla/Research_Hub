<?php include_once "includes/db.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER - LNHS Research Hub</title>
    <link rel="icon" href="./assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/mainStyle.css">
    <link rel="stylesheet" href="css/bgStyle.css">
</head>

<body>
    <!-- Header -->
    <?php
    include 'includes/header.php';
    ?>

    <main>
        <!-- Register Section -->
        <div class="container">
            <div class="row">
                <div class="mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card mt-5 my-4 py-3">
                                <div class="text-center m-3">
                                    <h3 class="orbitron">Register</h3>
                                </div>
                                <div class="card-body mx-5">
                                    <form id="registrationForm">
                                        
                                        <!-- Role -->
                                        <div class="row mb-3" hidden>
                                            <label for="role" class="form-label">Role</label>
                                            <input type="text" class="form-control" id="role" name="role" required value="S">
                                        </div>

                                        <!-- Name, Last Name, M.I. -->
                                        <div class="row mb-3">
                                            <div class="col-md-5">
                                                <label for="lastName" class="form-label required">Last Name</label>
                                                <input type="text" class="form-control" id="lastName" name="lastName" required>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="firstName" class="form-label required">First Name</label>
                                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="middleInitial" class="form-label">M.I.</label>
                                                <input type="text" class="form-control" id="middleInitial" name="middleInitial" maxlength="1">
                                            </div>
                                        </div>

                                        <!-- Username and Email -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="username" class="form-label required">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="form-label required">Email Address</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                        </div>

                                        <!-- LRN / Student Number -->
                                        <div class="mb-3">
                                            <label for="lrn" class="form-label required">Leaner's Reference Number (LRN)</label>
                                            <input type="text" class="form-control" id="lrn" name="lrn" maxlength="12" required>
                                        </div>

                                        <!-- Strand -->
                                        <div class="mb-3">
                                            <label for="trackStrand" class="form-label required">Strand</label>
                                            <select class="form-control" id="trackStrand" name="trackStrand" required>
                                                <option value="" disabled selected>Select your Strand</option>
                                                <option value="STEM">STEM (Science, Technology, Engineering, and Mathematics)</option>
                                                <option value="ABM">ABM (Accountancy, Business, and Management)</option>
                                                <option value="HUMSS">HUMSS (Humanities and Social Sciences)</option>
                                            </select>
                                        </div>

                                        <!-- Password and Confirm Password -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="password" class="form-label required">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="confirmPassword" class="form-label required">Confirm Password</label>
                                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">Register</button>
                                        </div>

                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <small>Already have an account? <a href="./login.php">Login here</a></small>
                                </div>
                            </div>

                        </div>
                    </div>
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
    <script src="scripts/register.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('registration');
            confirmPassword('registrationForm');
        });
    </script>
</body>

</html>