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
                                <a href="addStudentLRN.php" class="btn btn-secondary px-3">Add</a>
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
                        <div class="container mt-3 admin-table-container">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Name</th>
                                            <th>LRN</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <!-- PHP loop to display dynamic rows here -->
                                        <?php
                                        // Example: Assuming you have a database connection established and you are fetching records
                                        // Replace $user with your actual database query results
                                        $user = [
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],

                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],
                                            ['user_firstname' => 'Shesh', 'user_mi' => 'S', 'user_lastname' => 'Das', 'rn_lrnid' => '123456789098'],

                                            // Add more user as needed
                                        ];

                                        foreach ($user as $user) {
                                            // Concatenate the name
                                            $fullName = $user['user_firstname'] . ' ' . $user['user_mi'] . '. ' . $user['user_lastname'];

                                            // Get the LRN
                                            $lrn = $user['rn_lrnid'];

                                            echo "<tr>
                                                    <td>{$fullName}</td>
                                                    <td>{$lrn}</td>
                                                    <td>
                                                        <a href='#' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i></a>
                                                        <a href='#' class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></a>
                                                    </td>
                                                </tr>";

                                        }
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
