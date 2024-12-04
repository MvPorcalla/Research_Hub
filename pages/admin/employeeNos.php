<?php include_once './../admin/includes/session_check.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="employeeTitle">Add DepEd Employee Number - LNHS Research Hub</title>
    <?php include './../admin/includes/links_head-css.php'; ?>
</head>

<body>
    <!-- header -->
    <?php include './../admin/components/header.php'; ?>

    <!-- main content with sidebar -->
    <div class="container-fluid">
        <div class="row">
            <!-- sidebar -->
            <?php include './../admin/components/sidebar.php'; ?>


            <!-- Main content area -->
            <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
                <div class="container">
                    <div class="row">
                        <div class="mt-5 mb-3  text-center">
                            <h1 id="employeeSubtitle" class='admin-subtitle'>Add DepEd Employee Number</h1>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-7">
                                <div class="card border border-dark rounded-4 bg-transparent">
                                    <div class="card-body mx-5 text-start">
                                        <form id="employeeForm" action="../../backend/employee_no.php" method="POST">

                                            <!-- Full name -->
                                            <div class="row mb-4">
                                                <div class="col-md-5">
                                                    <label for="lastName" class="form-label fw-bold">Last Name</label>
                                                    <input type="text" class="form-control" id="lastName" name="lastName">
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="firstName" class="form-label fw-bold">First Name</label>
                                                    <input type="text" class="form-control" id="firstName" name="firstName">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="middleInitial" class="form-label fw-bold">M.I.</label>
                                                    <input type="text" class="form-control" id="middleInitial" name="middleInitial" maxlength="1">
                                                </div>
                                            </div>

                                            <div class="row mb-4">
                                                <!-- DepEd Employee Number -->
                                                <div class="col-md-12">
                                                    <label for="employeeNo" class="form-label fw-bold">DepEd Employee Number</label>
                                                    <input type="text" pattern="\d{7}" minlength="7" maxlength="7" class="form-control" id="employeeNo" name="employeeNo" required>
                                                </div>
                                            </div>

                                            <!-- Back and Submit Button -->
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-secondary w-100" onclick="history.back()">Back</button>
                                                </div>

                                                <div class="col-md-8 ">
                                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                                                </div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <?php include './../admin/includes/links_footer-script.php'; ?>

    <script src="../../includes/functions.js"></script>
    <script src="../../scripts/fetchOneRecord.js"></script>
    
</body>

</html>