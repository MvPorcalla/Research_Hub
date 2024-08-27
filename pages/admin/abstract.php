<?php
include_once "..\..\includes\db.php";
if ($_SESSION['user_type'] != 'A') header("location: ../../index.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="abstractTitle">Add Record - LNHS Research Hub</title>
    <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/mainStyle.css">
    <style>
        .admin-card {
            border-radius: 20px;
            border:1px solid #000;
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
                        <div class="mt-5 mb-3">
                            <h1 class='admin-subtitle' id="recordSubtitle">Add Record</h1>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="card admin-card bg-transparent">
                                    
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
                                            <div class="mb-3">
                                                <label for="file" class="form-label">Upload Research</label>
                                                <input type="file" class="form-control" id="file" name="file" accept=".pdf" required>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="..\..\includes\functions.js"></script>
    <script src="../../scripts/fetchOneRecord.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('addRecord');
            handleStatus('editRecord');
        });
    </script>
</body>

</html>
