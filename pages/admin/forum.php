<?php
    include_once "..\..\includes\db.php";

    if (!isset($_SESSION['user_type'])) {
        header("location: ../../index.php");
        exit;
    } elseif ($_SESSION['user_type'] != 'A') {
        header("location: ../../backend/logout.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORUM - LNHS Research Hub</title>
    <?php include './../admin/components/links-head-css.php'; ?>

    <style>
        .comment {
            border-left: 2px solid #ccc;
            padding-left: 15px;
            margin-bottom: 10px;
        }
        .post-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .post-stats span {
            margin-right: 15px;
        }
        .post-buttons {
            display: flex;
            gap: 10px;
        }
        .btn-link {
            color: inherit; /* Maintain the text color */
            text-decoration: none; /* Remove underline */
        }
        .comments-section {
            display: none; /* Hide comments section initially */
        }

        .like-button {
            cursor: pointer;
        }

        .liked {
            color: blue !important; /* Change the icon color to blue */
            font-weight: bold !important; /* Optional: make it bold */
        }
        
    </style>
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
                        <div class="col-md-12 mt-4">
                            <!--  Content -->
                            <div class="my-3 text-center">
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

    <?php include './../admin/components/links-footer-script.php'; ?>


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

