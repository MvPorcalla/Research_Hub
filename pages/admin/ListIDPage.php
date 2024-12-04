<?php include_once './../admin/includes/session_check.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LRN List - LNHS Research Hub</title>
    <?php include './../admin/includes/links_head-css.php'; ?>
</head>

<body>
    <!-- header -->
    <?php include './../admin/components/header.php'; ?>

    <!-- main content with sidebar -->
    <div class="container-fluid">
        <div class="row">
            <!-- sidebar -->
            <?php include './../admin/components/sidebar.php'; ?>

            <!-- Main content area -->
            <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-center mt-5 mb-4">
                                <h1 class='admin-subtitle'>LRN Lists</h1>
                            </div>
                            <?php include 'ListIDLRN.php'; ?>
                        </div>

                        <div class="col-md-6">
                            <div class="text-center mt-5 mb-4">
                                <h1 class="admin-subtitle">Employee Numbers List</h1>
                            </div>
                            <?php include 'ListIDEmployeeNo.php'; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>

</html>