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
    <title>ABSTRACT - LNHS Research Hub</title>
    <?php include './../admin/components/links-head-css.php'; ?>

    <style>
        .pdf-container {
            position: relative;
            width: 100%;
            height: 650px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .pdf-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .comment-container {
            position: relative;
            width: 100%;
            height: auto;
            border: 1px solid black;
            border-radius: 8px;
            padding: 10px;
            max-height: 600px;
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

    </style>
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
    <?php include './../admin/components/links-heafooterd-script.php'; ?>


    <script src="../../includes/functions.js"></script>
    <script src="../../scripts/fetchRecords.js"></script>
    <script src="../../scripts/fetchOneRecord.js"></script>
    <script src="../../scripts/toggleLike.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('comment');
            handleStatus('deleteRecord');
        });
    </script>
</body>
</html>
