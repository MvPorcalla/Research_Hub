<?php include_once './../user/includes/session_check.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites - LNHS Research Hub</title>
    <!-- Include the head-links-css.php file which contains all necessary CSS links for the page. -->
    <?php include './../user/includes/links_head-css.php'; ?>
</head>

<body>
    <!-- header -->
    <?php include './../user/components/header.php'; ?>

    <!-- main content with sidebar -->
    <div class="container-fluid">
        <div class="row">
            <!-- sidebar -->
            <?php include './../user/components/sidebar.php'; ?>

            <!-- Main content area -->
            <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
                <div class="container text-center">
                    <div id="favoriteTiles" class="row" data-user-id="<?php echo $_SESSION['user_id']; ?>">

                        <div class="mt-5 mb-3">
                            <h1 class='admin-subtitle'>Favorites</h1>
                        </div>
                        <!-- Data will be dynamically inserted here -->
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Include the links-footer-script.php file which contains all necessary JavaScript links for the page. -->
    <?php include './../user/includes/links_footer-script.php'; ?>

    <script src="../../includes/functions.js"></script>
    <script src="../../scripts/fetchFavorites.js"></script>
    <script src="../../scripts/toggleLike.js"></script>

</body>
</html>
