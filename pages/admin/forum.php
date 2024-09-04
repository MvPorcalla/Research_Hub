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
    <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/mainStyle.css">
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <script src="../../includes/functions.js"></script>
    <script src="../../scripts/toggleLike.js"></script>
    <script src="../../scripts/adminForum.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('entry');
            handleStatus('comment');
        });

        function toggleComments(entryId) {
            const commentsSection = document.getElementById(`comment-section-${entryId}`);
            if (commentsSection.style.display === 'none' || commentsSection.style.display === '') {
                commentsSection.style.display = 'block';
            } else {
                commentsSection.style.display = 'none';
            }
        }
    </script>

</body>

</html>

