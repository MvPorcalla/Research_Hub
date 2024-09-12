<?php include_once './../admin/includes/session_check.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="abstractTitle">Add Record - LNHS Research Hub</title>
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
                        <div class="mt-5 mb-3">
                            <h1 class='admin-subtitle' id="recordSubtitle">Add Record</h1>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="card border border-dark rounded-5 bg-transparent">
                                    <div class="card-body mx-5 text-start">

                                        <form id="recordForm" action="..\..\backend\abstract.php" method="POST" enctype="multipart/form-data">

                                            <!-- Title -->
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="title" class="form-label">Title</label>
                                                    <input type="text" class="form-control" id="title" name="title" required>
                                                </div>
                                            </div>

                                            <!-- Author -->
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="authors" class="form-label">Authors</label>
                                                    <input type="text" class="form-control" id="authors" name="authors" required>
                                                </div>
                                            </div>

                                            <!-- Month - Year -->
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="monthYear" class="form-label">Year</label>
                                                    <input type="month" class="form-control" id="monthYear" name="monthYear" required>
                                                </div>
                                            </div>

                                            <!-- Track/Strand -->
                                            <div class="mb-3">
                                                <label for="trackStrand" class="form-label">Track/Strand</label>
                                                <select class="form-control" id="trackStrand" name="trackStrand" required>
                                                    <option value="" disabled selected>Select your Track/Strand</option>
                                                    <option value="STEM">STEM (Science, Technology, Engineering, and Mathematics)</option>
                                                    <option value="ABM">ABM (Accountancy, Business, and Management)</option>
                                                    <option value="HUMSS">HUMSS (Humanities and Social Sciences)</option>
                                                </select>
                                            </div>

                                            <!-- Upload Research File -->
                                            <div class="mb-4">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <label for="file" class="form-label">Upload Research</label>
                                                    </div>
                                                    <div id="changeFileCheckbox" class="col-md-3 d-flex justify-content-end">
                                                        <input type="checkbox" id="enableUpload" class="form-check-input me-2" onchange="toggleFileInput()" hidden>
                                                        <label for="enableUpload" class="form-check-label" hidden>Change File</label>
                                                    </div>
                                                </div>
                                                <input type="file" class="form-control mt-2" id="file" name="file" accept=".pdf ">
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="d-grid my-3">
                                                <button type="submit" class="btn btn-primary">Submit</button>
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

    <?php include './../admin/includes/links_footer-script.php'; ?>

    <script src="../../includes/functions.js"></script>
    <script src="../../scripts/fetchOneRecord.js"></script>

    <script>
        function toggleFileInput() {
            const checkbox = document.getElementById('enableUpload');
            const fileInput = document.getElementById('file');

            if (checkbox.checked) {
                fileInput.disabled = false;
                fileInput.required = true;
            } else {
                fileInput.disabled = true;
                fileInput.required = false;
            }
        }
    </script>
    
</body>

</html>
