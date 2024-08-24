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

                        <!-- Content Cards -->
                        <div class="container mt-3 side-container">
                            <div class="row">
                                <?php
                                // Sample data array
                                $users = [
                                    ['title' => 'Advancements in Artificial Intelligence'],
                                    ['title' => 'Impact of Climate Change on Agriculture'],
                                    ['title' => 'Statistical Data on Renewable Energy'],
                                    ['title' => 'Still missing you everyday'],
                                    ['title' => 'How are you baby girl'],
                                    ['title' => 'kung ang pusa ay cat, bakit ka tanga?'],
                                    ['title' => 'Statistical Data on Karupokan'],
                                    ['title' => 'Impact of Pagiging Delulu'],
                                    ['title' => 'Advancement in Assuming'],
                                ];

                                // Generate cards from the data
                                foreach ($users as $user) {
                                    $file = 'https://via.placeholder.com/55x70';
                                    $title = htmlspecialchars($user['title']);
                                    echo '<div class="col-12 mb-2">';
                                        echo '<div class="card">';
                                            echo '<div class="card-body">';
                                                echo '<div class="row text-center">';
                                                    echo '<div class="col-md-2 d-flex align-items-center justify-content-center border-end">';
                                                        echo '<img src="' . $file . '" class="img-fluid rounded-1" alt="' . $title . '">';
                                                    echo '</div>';
                                                    echo '<div class="col-md-8 d-flex align-items-center justify-content-start border-end">' . $title . '</div>';
                                                    echo '<div class="col-md-2 d-flex align-items-center justify-content-center">';
                                                        echo '<button class="btn btn-outline-primary btn-sm mx-1">';
                                                            echo '<i class="fas fa-comment"></i>';
                                                        echo '</button>';
                                                        echo '<button class="btn btn-outline-danger btn-sm mx-1 toggle-heart">';
                                                            echo '<i class="fas fa-heart"></i>';
                                                        echo '</button>';
                                                        echo '<button class="btn btn-outline-success btn-sm mx-1">';
                                                            echo '<i class="fas fa-download"></i>';
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
</body>

</html>
