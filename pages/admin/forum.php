<?php include_once './../admin/includes/session_check.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORUM - LNHS Research Hub</title>
    <?php include './../admin/includes/links_head-css.php'; ?>
</head>

<body>
    <!-- header -->
    <?php include './../admin/components/header.php'; ?>

    <!-- main content with sidebar -->
    <div class="container-fluid">
        <div class="row ">
            <!-- sidebar -->
            <?php include './../admin/components/sidebar.php'; ?>

            <!-- Main content area -->
            <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <!--  Content -->
                            <div class="text-center mt-5 mb-4">
                                <h1 class='admin-subtitle'>Research Hub Forum</h1>
                            </div>

                            <div id="entriesContainer" data-user-id="<?php echo $_SESSION['user_id']; ?>" class="container" data-entry-id="${entryId}">
                                <!-- Data will be dynamically inserted here -->
                            </div>
                        </div>

                    </div>

                </div>
            </main>
        </div>
    </div>

    <?php include './../admin/includes/links_footer-script.php'; ?>

    <script src="../../includes/functions.js"></script>
    <script src="../../scripts/toggleLike.js"></script>
    <script src="../../scripts/fetchEntriesComments.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('entry');
            handleStatus('comment');
        });
    </script>

</body>
</html>

