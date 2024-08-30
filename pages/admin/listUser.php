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
    <title>User List - LNHS Research Hub</title>
    <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/mainStyle.css">
    <link rel="stylesheet" href="../../css/mainStyle.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .btn {
            position: relative;
        }
        .input-group {
            position: relative;
        }
        .form-control {
            padding-right: 50px; /* Adjusted to accommodate the button */
        }
        .btn-search {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 50%;
        }

        #search {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        #suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            max-height: 200px;
            border: 1px solid #ddd;
            border-top: none;
            background-color: var(--bg-base-lt);
            border-radius: 10px;
            border:1px solid #000;
            z-index: 1000;
            overflow-y: auto;
            display: none;
        }
        #suggestions div {
            padding: 8px;
            cursor: pointer;
        }
        #suggestions div:hover {
            background-color: #f0f0f0;
        }
    </style>


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

                            <?php include './../admin/components/searchbar.php' ?>
                        </div>


                        <!-- Content Table -->

                        <div id="users-table" class="container mt-3 side-container text-light mt-1">

                            <!-- student list -->

                            <div class="tab-content " id="myTabContent">
                                <div class="tab-pane fade show active" id="student-list" role="tabpanel" aria-labelledby="student-list-tab">
                                    <div class="row">
                                        <div class="col">
                                            <div class=" bg-transparent">

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped students" id="students-table">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th>Last Name</th>
                                                                <th>First Name</th>
                                                                <th>Middle Initial</th>
                                                                <th>LRN</th>
                                                                <th>Track/Strand</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <!-- Data will be dynamically inserted here -->
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
                                            <div class=" bg-transparent">

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped guests" id="guests-table">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th>Last Name</th>
                                                                <th>First Name</th>
                                                                <th>Middle Initial</th>
                                                                <th>School</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <!-- Data will be dynamically inserted here -->
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
    <!-- <script src="../../scripts/fetchRecords.js"></script> -->
    <script src="../../scripts/searchfetch.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('deleteRecord');
        });
    </script>
</body>

</html>