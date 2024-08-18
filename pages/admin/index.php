<?php include_once "..\..\includes\db.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME PAGE - LNHS Research Hub</title>
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
                        <div class="my-2">
                            <h1 class="admin_title">Research Records</h1>
                        </div>

                        <!-- Search Bar -->
                        <div class="row">
                            <div class="col-md-5 d-flex justify-content-start">
                                <a href="./addRecord.php" class="btn btn-secondary px-3">Add</a>
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
                        <div class="container mt-3 admin-table-container">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Title</th>
                                            <th>Year</th>
                                            <th>Month</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php

                                        $records = query($conn, "SELECT * FROM `records` WHERE `record_status` = 'A'");

                                        foreach ($records as $key => $record) {

                                            $id = $record['record_id'];
                                            $title = $record['record_title'];
                                            $year = $record['record_year'];
                                            $monthNumber = $record['record_month'];

                                            $months = [
                                                1 => "January",
                                                2 => "February",
                                                3 => "March",
                                                4 => "April",
                                                5 => "May",
                                                6 => "June",
                                                7 => "July",
                                                8 => "August",
                                                9 => "September",
                                                10 => "October",
                                                11 => "November",
                                                12 => "December"
                                            ];

                                            $month = $months[$monthNumber] ?? null;

                                            echo "<tr>
                                                    <td>{$title}</td>
                                                    <td>{$year}</td>
                                                    <td>{$month}</td>
                                                    <td>
                                                        <a href='#' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i></a>
                                                        <a href='..\..\backend\delete.php?recordId={$id}' class='btn btn-danger btn-sm delete-button'><i class='fas fa-trash-alt'></i></a>
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
            handleStatus('login');
            handleStatus('deleteRecord');
        });

        // =====================================================================

        setupConfirmationDialog('.delete-button', {
            multiTd: false,
            actionText: "You are about to delete",
            confirmButtonText: "Delete"
        });
    </script>
</body>

</html>