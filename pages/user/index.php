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
    <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/mainStyle.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .btn {
            position: relative;
        }
        .input-group {
            position: relative;
        }
        .form-control {
            padding-right: 50px; /* Adjusted to accommodate the button */
        }
        .btn-search {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 50%;
        }

        #search {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        #suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            max-height: 200px;
            border: 1px solid #ddd;
            border-top: none;
            background-color: var(--bg-base-lt);
            border-radius: 10px;
            border:1px solid #000;
            z-index: 1000;
            overflow-y: auto;
            display: none;
        }
        #suggestions div {
            padding: 8px;
            cursor: pointer;
        }
        #suggestions div:hover {
            background-color: #f0f0f0;
        }

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
            color: blue !important; /* Change the icon color to blue */
            font-weight: bold !important; /* Optional: make it bold */
        }

    </style>
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

                        <!-- Search Bar -->
                        <div class="row my-4">
                             <!-- Filter Dropdowns -->
                             <div class="col-md-6 d-flex justify-content-end">
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <select id="monthFilter" class="form-select">
                                            <option value="">All Month</option>
                                            <!-- Options will be dynamically added here -->
                                        </select>
                                    </div>
                                    <div class="mx-2">
                                        <select id="yearFilter" class="form-select">
                                            <option value="">All Year</option>
                                            <!-- Options will be dynamically added here -->
                                        </select>
                                    </div>
                                    <div class="">
                                        <select id="trackFilter" class="form-select">
                                            <option value="">All Strand</option>
                                            <!-- Options will be dynamically added here -->
                                        </select>
                                    </div>
                                </div>
                            </div>

                             <!-- Search Bar -->
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <form id="search-form" class="d-flex w-100">
                                        <div class="input-group">
                                            <input class="form-control rounded-pill" type="search" id="query" placeholder="Search" aria-label="Search" autocomplete='off'>
                                            <span class="btn rounded-pill" type="submit" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                                <i class="fas fa-search"></i>
                                            </span>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="..\..\includes\functions.js"></script>
    <!-- <script src="../../scripts/fetchRecords.js"></script> -->
    <script src="../../scripts/searchfetch.js"></script>
    <script src="../../scripts/toggleLike.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('login');
            handleStatus('comment');
        });
    </script>
</body>

</html>
