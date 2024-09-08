<?php include_once './../admin/includes/session_check.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABSTRACT - LNHS Research Hub</title>
    <?php include './../admin/includes/links_head-css.php'; ?>
</head>

<body>
    <!-- header -->
    <?php include './../admin/components/header.php'; ?>

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
                            <!-- Back Button -->
                            <a href="#" class="btn btn-secondary me-2 mb-2" onclick="history.back(); return false;">
                                <i class="fas fa-arrow-left"></i>
                            </a>

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

    <!-- Bootstrap JS -->
    <?php include './../admin/includes/links_footer-script.php'; ?>


    <script src="../../includes/functions.js"></script>
    <script src="../../scripts/fetchAbstractComments.js"></script>
    <script src="../../scripts/fetchOneRecord.js"></script>
    <script src="../../scripts/toggleLike.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('comment');
            handleStatus('deleteRecord');
            displayComments();
        });
    </script>
</body>
</html>
