<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites - LNHS Research Hub</title>
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

                        <div class="mt-5 mb-3">
                            <h1 class='admin-subtitle'>Favorites</h1>
                        </div>
                    
                        <!-- Content -->
                        <?php
                        // Example data, replace with actual database results
                        $users = [
                            ['record_id' => 'Advancements in Artificial Intelligence', ],
                            ['record_id' => 'Impact of Climate Change on Agriculture',],
                            ['record_id' => 'Statistical Data on Renewable Energy',],
                            
                            // Add more users as needed
                        ];

                        foreach ($users as $user) {
                            $record = htmlspecialchars($user['record_id']);
 
                            echo '<div class="col-12 mb-2">';
                                echo '<div class="card border-dark rounded-4">';
                                    echo '<div class="card-body">';
                                        echo '<div class="row text-center">';
                                            echo '<div class="col-md-11 d-flex align-items-center justify-content-start border-end">' . $record . '</div>';
                                            echo '<div class="col-md-1 d-flex align-items-center justify-content-center">';
                                            echo '<button class="btn btn-danger btn-sm mx-1 toggle-heart">';
                                            echo '<i class="fas fa-heart"></i>';
                                            echo '</button>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>'; 
                            echo '</div>';   
                        }
                        ?>

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

    <!-- Custom JS for heart toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-heart').forEach(button => {
                button.addEventListener('click', function() {
                    this.classList.toggle('btn-danger');
                    this.classList.toggle('btn-outline-danger');
                    const icon = this.querySelector('i');
                    icon.classList.toggle('fa-heart');
                    icon.classList.toggle('fa-heart-broken');
                });
            });
        });
    </script>
      
</body>

</html>
