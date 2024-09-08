<?php include './../user/includes/session_check.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histories - LNHS Research Hub</title>
    <!-- Include the head-links-css.php file which contains all necessary CSS links for the page. -->
    <?php include './../user/includes/links_head-css.php'; ?>
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
                            <h1 class="admin-subtitle">History</h1>
                        </div>

                        <div id="historyContainer" class="side-container">
                            <!-- Data will be dynamically inserted here -->
                        </div>
                    </div>
                </div>
            </main>

        </div>
    </div>

    <!-- Include the links-footer-script.php file which contains all necessary JavaScript links for the page. -->
    <?php include './../user/includes/links_footer-script.php'; ?>

    <script src="../../includes/functions.js"></script>
    <script src="../../scripts/fetchHistories.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('deleteRecord');
        });
    </script>

</body>

</html>
