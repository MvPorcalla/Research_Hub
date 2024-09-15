<?php include_once './../admin/includes/session_check.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LRN List - LNHS Research Hub</title>
    <?php include './../admin/includes/links_head-css.php'; ?>
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
                            <h1 class="admin_title">LRN List</h1>
                        </div>

                        <!-- Search Bar -->
                        <div class="row">
                            <div class="col-md-5 d-flex justify-content-start">
                                <a href="lrn.php" class="btn btn-secondary px-3">Add</a>
                                <a href="#" class="btn btn-success ms-3 px-3" data-bs-toggle="modal" data-bs-target="#importModal">Import</a>
                            </div>
                            

                            <div class="col-md-7">
                                <?php include './../admin/components/searchbar.php' ?>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title" id="importModalLabel">Import Student LRN</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                        <form id="importForm" action="../../backend/importStudentLRN.php" method="post" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="fileInput" class="form-label">Select Excel file to import</label>
                                                <input class="form-control" type="file" id="fileInput" name="file" accept=".xlsx, .xls" required>
                                                <div class="form-text">Only Excel files (.xlsx, .xls) are allowed.</div>
                                            </div>
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-success btn-lg" name="save_excel_data">Import</button>
                                            </div>
                                        </form>


                                        </div>
                                    </div>
                                </div>
                            </div>


                        <!-- Content Table -->
                        <div class="container mt-3 side-container">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped LRNs" id="lrns-table">
                                    <thead class="table-dark">
                                        <tr class="col-md-12">
                                            <th class="col-md-5">Full Name</th>
                                            <th class="col-md-5">LRN</th>
                                            <th class="col-md-2">Actions</th>
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
            </main>
        </div>
    </div>

    <?php include './../admin/includes/links_footer-script.php'; ?>

    <script src="../../includes/functions.js"></script>
    <script src="../../scripts/searchfetch.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('addRecord');
            handleStatus('editRecord');
            handleStatus('deleteRecord');
            handleStatus('importRecords');
            handleStatus('exceptions');
        });
    </script>
</body>

</html>