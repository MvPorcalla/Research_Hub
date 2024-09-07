<?php
include_once "..\..\includes\db.php";

if (!isset($_SESSION['user_type'])) {
    header("location: ../../index.php");
    exit;
} elseif ($_SESSION['user_type'] == 'A') {
    header("location: ../../backend/logout.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME PAGE - LNHS Research Hub</title>
    <!-- Include the head-links-css.php file which contains all necessary CSS links for the page. -->
    <?php include './../user/components/links-head-css.php'; ?>

    <style>
        
        .comment-container {
            position: relative;
            width: 100%;
            height: auto;
            border: 1px solid black;
            border-radius: 8px;
            padding: 10px;
            max-height: 550px;
            overflow-y: auto;
        }

        .comment-card {
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
        }

        .comment-card .card-body {
            padding: 10px;
        }

        .like-button {
            cursor: pointer;
        }

        .liked {
            color: blue !important;
            font-weight: bold !important;
        }

    </style>
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
                <div class="container">
                    <div class="row">

                        <!-- Search Bar -->
                        <div class="row my-4">
                             <!-- Filter Dropdowns -->
                             <div class="col-md-6 d-flex justify-content-end">
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <select id="monthFilter" class="form-select">
                                            <!-- Options will be dynamically added here -->
                                        </select>
                                    </div>
                                    <div class="mx-2">
                                        <select id="yearFilter" class="form-select">
                                            <!-- Options will be dynamically added here -->
                                        </select>
                                    </div>
                                    <div class="">
                                        <select id="trackFilter" class="form-select">
                                            <!-- Options will be dynamically added here -->
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Bar -->
                            <div class="col-md-6 overflow-hidden">
                                <div class="d-flex">
                                    <form id="search-form" class="d-flex w-100" onsubmit="return false;">
                                        <div class="input-group rounded-pill bg-light position-relative w-100">
                                            <input class="form-control rounded-pill border border-dark bg-transparent" type="text" id="query" placeholder="Search" aria-label="Search" autocomplete="off">
                                            <span id="suggestion-text" class="suggestion-text bg-transparent"></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-titler" id="commentsModalLabel">Comments</h5>
                                    </div>
                                    <div class="modal-body">

                                        <!-- Comment Form -->
                                        <form id="commentForm" method="POST" action="../../backend/comment.php" class="d-flex align-items-center">
                                            <div class="form-outline flex-grow-1 mb-2">
                                                <input type="hidden" id="record_id" name="record_id"> 
                                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                                <input type="text" id="addANote" name="comment_content" class="form-control border-dark" placeholder="+ Add comment..." maxlength="200" required />
                                            </div>
                                            <!-- Submit Button -->
                                            <button type="submit" class="btn btn-primary ms-2 mb-2">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </form>

                                        <!-- Comment List -->
                                        <div id="commentsContainer" class="comment-container" data-user-id="<?php echo $_SESSION['user_id']; ?>">
                                            <!-- Data will be dynamically inserted here -->
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content Cards -->
                        <div class="container mt-3 side-container">
                            <div id="abstractTiles" class="row" data-user-id="<?php echo $_SESSION['user_id']; ?>">
                                <!-- Data will be dynamically inserted here -->
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


    

    
    
    <!-- toast -->
    <?php 
        include './../user/components/toasts.php'; 
    ?>

    <!-- Include the links-footer-script.php file which contains all necessary JavaScript links for the page. -->
    <?php include './../user/components/links-footer-script.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>


    <script src="../../includes/functions.js"></script>
    <script src="../../scripts/toggleLike.js"></script>
    <script src="../../scripts/fetchAbstract.js"></script>
    <script src="../../scripts/fetchFilters.js"></script>
    <script src="../../scripts/searchSuggestion.js"></script>
    <script src="../../scripts/fetchAbstractComments.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('login');
            handleStatus('comment');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastEl = document.querySelector('.toast');
            var toast = new bootstrap.Toast(toastEl);

            // Show the toast
            toast.show();
        });
    </script>
    
</body>
</html>
