<?php include_once './../admin/includes/session_check.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Numbers List - LNHS Research Hub</title>
    <?php include './../admin/includes/links_head-css.php'; ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Main content area -->
            <div class="col-md-5 d-flex justify-content-start">
                <a href="employeeNos.php" class="btn btn-secondary px-3">
                    <i class="fas fa-plus me-2"></i> Add
                </a>
                <a href="#" class="btn btn-success ms-3 px-3" data-bs-toggle="modal" data-bs-target="#importEmployeeModal">
                    <i class="fa-solid fa-file-import me-2"></i> Import
                </a>
            </div>
            <div class="col-md-7">
                <?php include './../admin/components/searchbar.php'; ?>
            </div>
        </div>

        <!-- Import Modal -->
        <div class="modal fade" id="importEmployeeModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="importModalLabel">Import DepEd Employee Numbers</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="importForm" action="../../backend/importStudentLRN.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="number_type" value="den">
                            <div class="mb-3">
                                <label for="fileInput" class="form-label">Select Excel file to import</label>
                                <input type="file" class="form-control" id="fileInput" name="file" accept=".xlsx, .xls" required>
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
        <div class="mt-3">
            <div class="table-responsive">
                <table class="table table-bordered" id="employees-table">
                    <thead>
                        <tr>
                            <th class="col-md-5">Full Name</th>
                            <th class="col-md-5">DepEd Employee Number</th>
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