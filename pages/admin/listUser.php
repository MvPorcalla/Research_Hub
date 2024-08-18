<?php include_once "..\..\includes\db.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List - LNHS Research Hub</title>
    <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/mainStyle.css">


</head>

<body>
    <!-- header -->
    <?php include './../admin/components/header.php'; ?>

    <!-- main content with sidebar -->
    <div class="container-fluid">
        <div class="row text-center">
            <!-- sidebar -->
            <?php include './../admin/components/sidebar.php'; ?>


            <!-- Main content area -->
            <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
                <div class="container">
                    <div class="row">
                        <div class="my-3">
                            <h1 class="admin_title">User List</h1>
                        </div>

                        <!-- Search Bar -->
                        <div class="row">
                            <div class="col-md-5 d-flex justify-content-start">
                                <ul class="nav nav-tabs bg-transparent" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="student-list-tab" data-bs-toggle="tab" data-bs-target="#student-list" type="button" role="tab" aria-controls="student-list" aria-selected="true">Student List</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="guest-list-tab" data-bs-toggle="tab" data-bs-target="#guest-list" type="button" role="tab" aria-controls="guest-list" aria-selected="false">Guest List</button>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-md-7">
                                <div class="d-flex justify-content-end">
                                    <form class="d-flex w-100">
                                        <div class="input-group">
                                            <input class="form-control rounded-pill" type="search" placeholder="Search" aria-label="Search">
                                            <button class="btn rounded-pill" type="submit" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <!-- Content Table -->

                        <div class="container mt-3 admin-table-container text-light mt-1">

                            <!-- student list -->

                            <div class="tab-content " id="myTabContent">
                                <div class="tab-pane fade show active" id="student-list" role="tabpanel" aria-labelledby="student-list-tab">
                                    <div class="row">
                                        <div class="col">
                                            <div class="card bg-transparent">

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th>First Name</th>
                                                                <th>Last Name</th>
                                                                <th>Middle Initial</th>
                                                                <th>LRN</th>
                                                                <th>Track/Strand</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            $students = query($conn, "SELECT * FROM `users` u JOIN `lrn` ON u.lrn_id = lrn.lrn_id WHERE `user_type` = 'S' AND `user_status` != 'I'");

                                                            foreach ($students as $key => $student) {

                                                                $id = $student['user_id'];
                                                                $fname = $student['user_firstname'];
                                                                $mi = $student['user_mi'];
                                                                $lname = $student['user_lastname'];
                                                                $lrn = $student['lrn_lrnid'];
                                                                $track = $student['user_trackstrand'];

                                                                echo "<tr>
                                                                        <td>{$fname}</td>
                                                                        <td>{$mi}</td>
                                                                        <td>{$lname}</td>
                                                                        <td>{$lrn}</td>
                                                                        <td>{$track}</td>
                                                                        <td>
                                                                            <a href='#' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i></a>
                                                                            <a href='..\..\backend\delete.php?userId={$id}' class='btn btn-danger btn-sm delete-button'><i class='fas fa-trash-alt'></i></a>
                                                                        </td>
                                                                    </tr>";
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Guest List -->

                                <div class="tab-pane fade" id="guest-list" role="tabpanel" aria-labelledby="guest-list-tab">
                                    <div class="row">
                                        <div class="col">
                                            <div class="card bg-transparent">

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th>First Name</th>
                                                                <th>Last Name</th>
                                                                <th>Middle Initial</th>
                                                                <th>School</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            $guests = query($conn, "SELECT * FROM `users` u WHERE `user_type` = 'G' AND `user_status` != 'I'");

                                                            foreach ($guests as $key => $guest) {

                                                                $id = $guest['user_id'];
                                                                $fname = $guest['user_firstname'];
                                                                $mi = $guest['user_mi'];
                                                                $lname = $guest['user_lastname'];
                                                                $school = $guest['user_school'];

                                                                echo "<tr>
                                                                            <td>{$fname}</td>
                                                                            <td>{$mi}</td>
                                                                            <td>{$lname}</td>
                                                                            <td>{$school}</td>
                                                                            <td>
                                                                                <a href='#' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i></a>
                                                                                <a href='..\..\backend\delete.php?userId={$id}' class='btn btn-danger btn-sm delete-button'><i class='fas fa-trash-alt'></i></a>
                                                                            </td>
                                                                        </tr>";
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="..\..\includes\functions.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('deleteUser');
        });

        // =====================================================================

        setupConfirmationDialog('.delete-button', {
            multiTd: true,
            tdCount: 3, // Number of <td> elements to extract text from
            actionText: "You are about to deactivate the account of",
            confirmButtonText: "Deactivate"
        });
    </script>
</body>

</html>