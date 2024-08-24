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

    <style>
        /* .table-container {
            overflow-x: auto;
        } */
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
                            <h1 class="admin_title">LRN List</h1>
                        </div>

                        <!-- Search Bar -->
                        <div class="row">
                            <div class="col-md-5 d-flex justify-content-start">
                                <a href="lrn.php" class="btn btn-secondary px-3">Add</a>
                                
                                <a href="#" class="btn btn-success ms-3 px-3" data-bs-toggle="modal" data-bs-target="#importModal">Import</a>

                               
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
                                <table class="table table-bordered table-striped LRNs">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Name</th>
                                            <th>LRN</th>
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
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="..\..\includes\functions.js"></script>
    <script src="./scripts/fetchRecords.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('addRecord');
            handleStatus('editRecord');
            handleStatus('deleteRecord');
            handleStatus('importRecords');
            handleStatus('existingRecords');
        });
    </script>
</body>

</html>