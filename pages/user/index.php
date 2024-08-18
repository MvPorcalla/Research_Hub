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
                        <div class="mt-3 d-flex justify-content-end">
                            <!-- Search Bar -->
                            <div class="input-group rounded" style="max-width: 800px;">
                                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" id="search-bar">
                                <span class="input-group-text border-0" id="search-addon">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>

                         <!-- Content Table -->
                         <div class="container mt-3 table-container">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th></th>
                                            <th>Title</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Example static row -->
                                        <tr>
                                            <td><i class="fas fa-file-pdf"></i></td>
                                            <td>Sample Research Title</td>
                                            
                                            <td>
                                                <a href="./#?id=1" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-comment"></i>
                                                </a>
                                                <a href="./#?id=1" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">
                                                    <i class="fas fa-heart"></i>
                                                </a>
                                                <a href="./#?id=1" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-file-pdf"></i></td>
                                            <td>I still miss U</td>
                                            <td>
                                                <a href="./#?id=1" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-comment"></i>
                                                </a>
                                                <a href="./#?id=1" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">
                                                    <i class="fas fa-heart"></i>
                                                </a>
                                                <a href="./#?id=1" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">
                                                    <i class="fas fa-download"></i>
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
    <script src="..\..\includes\functions.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('login');
        });
    </script>
</body>

</html>
