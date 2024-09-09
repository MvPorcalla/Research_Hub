<?php include_once './../admin/includes/session_check.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME PAGE - LNHS Research Hub</title>
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
                                <div class="col-md-5 overflow-hidden">
                                    <div class="d-flex">
                                        <form id="search-form" class="d-flex w-100" onsubmit="return false;">
                                            <div class="input-group rounded-pill bg-light position-relative w-100">
                                                <input class="form-control rounded-pill border border-dark bg-transparent" type="text" id="query" placeholder="Search" aria-label="Search" autocomplete="off">
                                                <span id="suggestion-text" class="suggestion-text bg-transparent"></span>
                                            </div>
                                        </form>
                                    </div>
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
                </div>
            </main>
        </div>
    </div>

    <?php 
        include './../admin/components/toasts.php'; 
    ?>

    <!-- Bootstrap JS -->
    <?php include './../admin/includes/links_footer-script.php'; ?>
    
    <script src="../../includes/functions.js"></script>
    <script src="../../scripts/fetchAbstract.js"></script>
    <script src="../../scripts/fetchFilters.js"></script>
    <script src="../../scripts/searchSuggestion.js"></script>

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
