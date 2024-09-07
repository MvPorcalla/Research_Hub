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
    <title>FORUM - LNHS Research Hub</title>
    <!-- Include the head-links-css.php file which contains all necessary CSS links for the page. -->
    <?php include './../user/components/links-head-css.php'; ?>

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
                        <div class="col-md-12 mt-4">
                            <!--  Content -->
                            <div class="row text-left my-3">
                                <div class="col-lg-10 text-lg-right">
                                    <h1 class='fs-2'>Research Hub Forum</h1>
                                </div>

                                <div class='col-lg-2 text-center'>
                                    <button class="btn btn-sm btn-block btn-primary rounded-2 py-2 mb-2 bg-op-6" data-bs-toggle="modal" data-bs-target="#askQuestionModal">
                                        Ask a Question
                                    </button>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="askQuestionModal" tabindex="-1" aria-labelledby="askQuestionModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="askQuestionModalLabel">Ask a Question</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form id="askQuestionForm" action="../../backend/entry.php" method="post">
                                                <div class="mb-3">
                                                    <label for="question" class="form-label">Your Question</label>
                                                    <textarea class="form-control" id="question" name="question" rows="4" placeholder="Type your question here..." maxlength="2000" required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block w-100">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="entriesContainer" data-user-id="<?php echo $_SESSION['user_id']; ?>" class="container ">
                                <!-- Data will be dynamically inserted here -->
                            </div>
                        </div>

                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Include the links-footer-script.php file which contains all necessary JavaScript links for the page. -->
    <?php include './../user/components/links-footer-script.php'; ?>

    <script src="../../includes/functions.js"></script>
    <script src="../../scripts/fetchEntriesComments.js"></script>
    <script src="../../scripts/toggleLike.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('entry');
            handleStatus('comment');
        });
    </script>
</body>

</html>

