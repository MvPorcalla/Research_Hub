<?php
include_once "..\..\includes\db.php";
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == 'A') header("location: ../../index.php");
?>

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
    <?php include './../user/components/header.php'; ?>

    <!-- main content with sidebar -->
    <div class="container-fluid">
        <div class="row text-center">
            <!-- sidebar -->
            <?php include './../user/components/sidebar.php'; ?>

            <!-- Main content area -->
            <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
                <div class="container">
                    <div class="row">
                        <div class="my-4 d-flex justify-content-end">
                            <!-- Search Bar -->
                            <div class="input-group rounded" style="max-width: 800px;">
                                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" id="search-bar">
                                <span class="input-group-text border-0" id="search-addon">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Content Table -->
                        <div class="container mt-3 admin-table-container">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped abstracts">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>File</th>
                                            <th>Title</th>
                                            <th>Action</th>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('login');

            // Sample data array
            const sampleData = [
                {
                    file: 'Research_Paper_1.pdf',
                    title: 'Advancements in Artificial Intelligence',
                    action: `
                        <button class="btn btn-outline-primary btn-sm mx-1">
                            <i class="fas fa-comment"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-sm mx-1">
                            <i class="fas fa-heart"></i>
                        </button>
                        <button class="btn btn-outline-success btn-sm mx-1">
                            <i class="fas fa-download"></i>
                        </button>
                    `
                },
                {
                    file: 'Study_Report_2.docx',
                    title: 'Impact of Climate Change on Agriculture',
                    action: `
                        <button class="btn btn-outline-primary btn-sm mx-1">
                            <i class="fas fa-comment"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-sm mx-1">
                            <i class="fas fa-heart"></i>
                        </button>
                        <button class="btn btn-outline-success btn-sm mx-1">
                            <i class="fas fa-download"></i>
                        </button>
                    `
                },
                {
                    file: 'Data_Analysis_3.xlsx',
                    title: 'Statistical Data on Renewable Energy',
                    action: `
                        <button class="btn btn-outline-primary btn-sm mx-1">
                            <i class="fas fa-comment"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-sm mx-1">
                            <i class="fas fa-heart"></i>
                        </button>
                        <button class="btn btn-outline-success btn-sm mx-1">
                            <i class="fas fa-download"></i>
                        </button>
                    `
                }
            ];

            // Select the <tbody> of the table with class 'abstracts'
            const tbody = document.querySelector('.abstracts tbody');

            // Function to populate the table with sample data
            function populateTable(data) {
                data.forEach(item => {
                    // Create a new table row
                    const tr = document.createElement('tr');

                    // Create and populate the 'File' cell
                    const tdFile = document.createElement('td');
                    tdFile.textContent = item.file;
                    tr.appendChild(tdFile);

                    // Create and populate the 'Title' cell
                    const tdTitle = document.createElement('td');
                    tdTitle.textContent = item.title;
                    tr.appendChild(tdTitle);

                    // Create and populate the 'Action' cell
                    const tdAction = document.createElement('td');
                    tdAction.innerHTML = item.action;
                    tr.appendChild(tdAction);

                    // Append the row to the table body
                    tbody.appendChild(tr);
                });
            }

            // Call the function to populate the table with the sample data
            populateTable(sampleData);
        });
    </script>
</body>

</html>
