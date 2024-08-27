<?php
include_once "..\..\includes\db.php";
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == 'A') header("location: ../../index.php");

// Mock data for forum entries
$forum_entries = [
    [
        'entry_id' => 1,
        'user_id' => 1,
        'entry_content' => 'Challenges in Conducting Qualitative Research',
        'entry_likes' => 87,
        'entry_status' => 'A',
        'posted_time' => '10 minutes ago',
        'user_name' => 'JaneDoe',
        'replies' => 45,
        'views' => 150,
    ],
    [
        'entry_id' => 2,
        'user_id' => 2,
        'entry_content' => 'Best Practices for Data Analysis in Research',
        'entry_likes' => 112,
        'entry_status' => 'A',
        'posted_time' => '1 hour ago',
        'user_name' => 'JohnSmith',
        'replies' => 78,
        'views' => 200,
    ],
    // Add more mock entries as needed
];
?>

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
        <div class="row ">
            <!-- sidebar -->
            <?php include './../user/components/sidebar.php'; ?>

            <!-- Main content area -->
            <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
                <div class="container">
                    <div class="row">

                        <div class="mt-5 mb-3 text-center">
                            <h1 class='admin-subtitle'>Forum</h1>
                        </div>

                        <div class="col-md-12">
                            <!-- filter Content -->
                            <div class="row text-left mb-3">
                                <div class="col-lg-4 mb-2 mb-sm-0">
                                    <div class="dropdown bootstrap-select form-control form-control-sm bg-white bg-op-9 text-sm" style="width: 100%;">
                                        <select class="form-control form-control-sm bg-white bg-op-9 text-sm" data-toggle="select">
                                            <option> Categories </option>
                                            <option> STEM </option>
                                            <option> ABM </option>
                                            <option> HUMSS </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-lg-right">
                                    <div class="dropdown bootstrap-select form-control form-control-sm bg-white bg-op-9 ml-auto text-sm" style="width: 100%;">
                                        <select class="form-control form-control-sm bg-white bg-op-9 ml-auto text-sm" data-toggle="select">
                                            <option> Filter by </option>
                                            <option> Most Recent </option>
                                            <option> Most Votes </option>
                                            <option> Most Replies </option>
                                        </select>
                                    </div>
                                </div>

                                <div class='col-lg-4 text-center'>
                                    <a class="btn btn-sm btn-block btn-success rounded-0 py-2 mb-2 bg-op-6" href="#">Ask a Question</a>
                                </div>
                            </div>

                            <!-- Forum Posts -->
                            <?php foreach ($forum_entries as $entry): ?>
                                <div class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                                    <div class="row align-items-center">
                                        <div class="col-md-8 mb-3 mb-sm-0">
                                            <h5>
                                                <a href="#" class="text-primary"><?= $entry['entry_content']; ?></a>
                                            </h5>
                                            <p class="text-sm"><span class="op-6">Posted</span> <a class="text-black" href="#"><?= $entry['posted_time']; ?></a> <span class="op-6">ago by</span> <a class="text-black" href="#"><?= $entry['user_name']; ?></a></p>
                                            <div class="text-sm op-5">
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-4 op-7">
                                            <div class="row text-center op-7">
                                                <div class="col px-1">
                                                    <i class="ion-connection-bars icon-1x"></i> <span class="d-block text-sm"><?= $entry['entry_likes']; ?> Votes</span>
                                                </div>
                                                <div class="col px-1">
                                                    <i class="ion-ios-chatboxes-outline icon-1x"></i> <span class="d-block text-sm"><?= $entry['replies']; ?> Replies</span>
                                                </div>
                                                <div class="col px-1">
                                                    <i class="ion-ios-eye-outline icon-1x"></i> <span class="d-block text-sm"><?= $entry['views']; ?> Views</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!-- /End of forum posts -->
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
