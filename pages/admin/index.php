<?php
    include_once "..\..\includes\db.php";

    if (!isset($_SESSION['user_type'])) {
        header("location: ../../index.php");
        exit;
    } elseif ($_SESSION['user_type'] != 'A') {
        header("location: ../../backend/logout.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME PAGE - LNHS Research Hub</title>
    <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/mainStyle.css">    
</head>
<body>
    <!-- header -->
    <?php include './../admin/components/header.php'; ?>

    <!-- main content with sidebar -->
    <div class="container-fluid">
        <div class="row">
            <!-- sidebar -->
            <?php include './../admin/components/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
                <div class="container">
                    <div class="row">

                    <div class="my-3">
                            <h1 class="admin_title text-center">Research Records</h1>
                        </div>

                        <!-- Search Bar and Filters -->
                        <div class="row align-items-center">
                            <!-- Add Button -->
                            <div class="col-md-1">
                                <a href="./abstract.php" class="btn btn-secondary px-3">Add</a>
                            </div>

                            <!-- Filter Dropdowns -->
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <select id="monthFilter" class="form-select">
                                            <!-- Options will be dynamically added here -->
                                        </select>
                                    </div>
                                    <div class="mx-2">
                                        <select id="yearFilter" class="form-select">
                                            <!-- Options will be dynamically added here -->
                                        </select>
                                    </div>
                                    <div class="">
                                        <select id="trackFilter" class="form-select">
                                            <!-- Options will be dynamically added here -->
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Bar -->
                            <div class="col-md-5">
                                <?php include './../admin/components/searchbar.php'; ?>
                            </div>
                        </div>
                        

                        <!-- Content Table -->
                        <div class="container mt-3 side-container">
                            <div class="table-responsive">
                                <table id="records-table" class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr class="col-md-12">
                                            <th class="col-md-4">Title</th>
                                            <th class="col-md-2">Month/Year</th>
                                            <th class="col-md-3">Author</th>
                                            <th class="col-md-2">Track/Strand</th>
                                            <th class="col-md-1">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="abstractTiles">
                                        <!-- Table rows will be populated by JavaScript -->
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
    <script src="../../includes/functions.js"></script>

    <script src="../../scripts/fetchAbstract.js"></script>
    <script src="../../scripts/fetchFilters.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('login');
            handleStatus('addRecord');
            handleStatus('editRecord');
            handleStatus('deleteRecord');
        });
    </script>

</body>
</html>
