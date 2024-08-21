<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approval - LNHS Research Hub</title>
    <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/mainStyle.css">

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
                            <h1 class='admin-subtitle'>Pending Approval</h1>
                        </div>
                        <div class="row">
                           <!-- Content -->
                            <?php
                            // Example data, replace with actual database results
                            $users = [
                                [
                                    'user_firstname' => 'sample', 
                                    'user_mi' => 'S', 
                                    'user_lastname' => 'shesheshs', 
                                    'user_email' => 'samplesheshsampe12332@gmail.com'
                                ],
                                [
                                    'user_firstname' => 'python', 
                                    'user_mi' => 'd', 
                                    'user_lastname' => 'cpde', 
                                    'user_email' => 'python@gmail.com'
                                ],
                                [
                                    'user_firstname' => 'mac',
                                    'user_mi' => 'g', 
                                    'user_lastname' => 'arthur', 
                                    'user_email' => 'mac@gmail.com'
                                ],
                                // Add more users as needed
                            ];

                            foreach ($users as $user) {
                                $fname = htmlspecialchars($user['user_firstname']);
                                $mi = htmlspecialchars($user['user_mi']);
                                $lname = htmlspecialchars($user['user_lastname']);
                                $email = htmlspecialchars($user['user_email']);

                                echo '<div class="col-12 mb-3">';
                                    echo '<div class="card border-dark rounded-4">';
                                        echo '<div class="card-body">';
                                            echo '<div class="row text-center">';
                                                echo '<div class="col-md-4 d-flex align-items-center justify-content-center border-end">' . $fname . ' ' . $mi . '. ' . $lname . '</div>';
                                                echo '<div class="col-md-5 d-flex align-items-center justify-content-center border-end">' . $email . '</div>';
                                                echo '<div class="col-md-3 d-flex align-items-center justify-content-center">';
                                                    echo '<a href="#" class="btn btn-primary btn-sm me-2">Accept</a>';
                                                    echo '<a href="#" class="btn btn-danger btn-sm">Decline</a>';
                                                echo '</div>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>'; 
                                echo '</div>'; 
                            }
                            ?>
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
        
    </script>
</body>

</html>
