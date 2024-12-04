<?php include_once './../admin/includes/session_check.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List - LNHS Research Hub</title>
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
            <main class="col-md-9 ms-sm-auto col-lg-9">
                <div class="container">
                    <div class="row">
                        <div class="text-center mt-5 mb-4">
                            <h1 class='admin-subtitle'>User Lists</h1>
                        </div>
                        
                        <!-- Search Bar -->
                        <div class="row">
                            <div class="col-md-5 d-flex justify-content-start">
                                <ul class="nav nav-tabs bg-transparent" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="student-list-tab" data-bs-toggle="tab" data-bs-target="#student-list" type="button" role="tab" aria-controls="student-list" aria-selected="true">Student List</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="teacher-list-tab" data-bs-toggle="tab" data-bs-target="#teacher-list" type="button" role="tab" aria-controls="teacher-list" aria-selected="false">Teacher List</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="guest-list-tab" data-bs-toggle="tab" data-bs-target="#guest-list" type="button" role="tab" aria-controls="guest-list" aria-selected="false">Guest List</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-7">
                                <?php include './../admin/components/searchbar.php' ?>
                            </div>
                        </div>

                        <!-- Content Table -->
                        <div id="users-table" class="container mt-3 side-container text-light mt-1">
                            <div class="tab-content " id="myTabContent">

                                <!-- Student list -->

                                <div class="tab-pane fade show active" id="student-list" role="tabpanel" aria-labelledby="student-list-tab">
                                    <div class="row">
                                        <div class="col">
                                            <div class=" bg-transparent">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered students" id="students-table">
                                                        <thead>
                                                            <tr class="col-md-12">
                                                                <th class="col-md-2">Last Name</th>
                                                                <th class="col-md-2">First Name</th>
                                                                <th class="col-md-2">Middle Initial</th>
                                                                <th class="col-md-3">LRN</th>
                                                                <th class="col-md-2">Strand</th>
                                                                <th class="col-md-1">Actions</th>
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

                                <!-- Teacher List -->

                                <div class="tab-pane fade" id="teacher-list" role="tabpanel" aria-labelledby="teacher-list-tab">
                                    <div class="row">
                                        <div class="col">
                                            <div class=" bg-transparent">

                                                <div class="table-responsive">
                                                    <table class="table table-bordered teachers" id="teachers-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Last Name</th>
                                                                <th>First Name</th>
                                                                <th>Middle Initial</th>
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
                                                    <table class="table table-bordered guests" id="guests-table">
                                                        <thead>
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

    <?php include './../admin/includes/links_footer-script.php'; ?>

    <script src="../../includes/functions.js"></script>
    <script src="../../scripts/searchfetch.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('deleteRecord');
        });
    </script>
</body>

</html>