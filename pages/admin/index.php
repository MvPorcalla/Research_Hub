<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME PAGE - LNHS Research Hub</title>
    <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/mainStyle.css">
    <style>
        .table-container {
            max-height: 500px; /* Adjust as needed */
            overflow-y: auto;
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
                            <h1 class="admin_title">Research Records</h1>
                        </div>
                        
                        <!-- Search Bar -->
                        <div class="row">
                            <div class="col-md-5 d-flex justify-content-start">
                                <a href="./addRecord.php" class="btn btn-secondary px-3">Add</a>
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
                        </div>

                        <!-- Content Table -->
                        <div class="container mt-3 table-container">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Title</th>
                                            <th>Year</th>
                                            <th>Month</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Example static row -->
                                        <tr>
                                            <td>Sample Research Title</td>
                                            <td>2024</td>
                                            <td>August</td>
                                            <td>
                                                <a href="./editRecord.php?id=1" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="./deleteRecord.php?id=1" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>I still miss U</td>
                                            <td>2023</td>
                                            <td>June</td>
                                            <td>
                                                <a href="./editRecord.php?id=1" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="./deleteRecord.php?id=1" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        

                                        <!-- PHP loop to display dynamic rows here -->
                                        <?php
                                        // Example: Assuming you have an array of records from a database
                                        // $records = fetchRecordsFromDatabase();

                                        // foreach ($records as $record) {
                                        //     echo "<tr>";
                                        //     echo "<td>{$record['record_title']}</td>";
                                        //     echo "<td>{$record['record_year']}</td>";
                                        //     echo "<td>{$record['record_month']}</td>";
                                        //     echo "<td>";
                                        //     echo "<a href='./editRecord.php?id={$record['record_id']}' class='btn btn-warning btn-sm'>";
                                        //     echo "<i class='fas fa-edit'></i>";
                                        //     echo "</a> ";
                                        //     echo "<a href='./deleteRecord.php?id={$record['record_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this record?\");'>";
                                        //     echo "<i class='fas fa-trash-alt'></i>";
                                        //     echo "</a>";
                                        //     echo "</td>";
                                        //     echo "</tr>";
                                        // }
                                        ?>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const loginStatus = urlParams.get('login');

            if (loginStatus === 'success') {
                Swal.fire({
                    icon: "info",
                    title: "Welcome to Research Hub!"
                });
            }
        });
    </script>
</body>

</html>
