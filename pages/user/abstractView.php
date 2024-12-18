<?php 
    include_once './../user/includes/session_check.php'; 
    include_once "../../backend/history.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABSTRACT - LNHS Research Hub</title>
    <!-- Include the head-links-css.php file which contains all necessary CSS links for the page. -->
    <?php include './../user/includes/links_head-css.php'; ?>
</head>

<body>
    <!-- header -->
    <?php include './../user/components/header.php'; ?>

    <!-- main content with sidebar -->
    <div class="container-fluid">
        <div class="row">

            <!-- Main content area -->
            <main class="col-md-12 ms-sm-auto col-lg-12 mt-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="pdf-container">
                                <iframe id="fileDisplay" src="" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="col-md-4">

                            <!-- Comment Form -->
                            <form id="commentForm" class="d-flex align-items-start">
                                <!-- Back Button -->
                                <a href="#" class="btn btn-secondary me-2 mb-2" onclick="history.back(); return false;">
                                    <i class="fas fa-arrow-left"></i>
                                </a>

                                <div class="form-outline flex-grow-1 mb-2">
                                    <input type="hidden" name="record_id" value="<?php echo $_GET['abstractId']; ?>"> 
                                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="text" id="comment_content" name="comment_content" class="form-control border-dark" placeholder="+ Add comment..." maxlength="200" required />
                                    <div class="text-end">
                                        <small id="charCounter" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary ms-2 mb-2">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>

                            <p id="error" style="color: red;"></p>

                            <!-- Comment List -->
                            <div id="commentsContainer" class="comment-container" data-abstract-id="<?php echo $_GET['abstractId']; ?>" data-user-id="<?php echo $_SESSION['user_id']; ?>">
                                <!-- Data will be dynamically inserted here -->
                            </div>
                        </div>
                    </div>
                </div>
            </main>

        </div>
    </div>

    <!-- Include the links-footer-script.php file which contains all necessary JavaScript links for the page. -->
    <?php include './../user/includes/links_footer-script.php'; ?>

    <script src="../../includes/functions.js"></script>
    <script src="../../scripts/fetchAbstractComments.js"></script>
    <script src="../../scripts/fetchOneRecord.js"></script>
    <script src="../../scripts/toggleLike.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('comment');
            displayComments();
            handleInputSubmit('commentForm', 'comment_content', 'error');
            characterCounter('comment_content', 'charCounter');
        });
    </script>
</body>
</html>
