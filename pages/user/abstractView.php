<?php
include "..\..\backend\history.php";

// Simulated comments array
$comments = [
    [
        'comment_id' => 1,
        'record_id' => 1,
        'entry_id' => 1,
        'user_id' => 1,
        'repliedto_user_id' => null,
        'comment_content' => 'This is a great introduction!',
        'comment_likes' => 10,
        'comment_status' => 'A',
        'date' => '2024-08-21'
    ],
    [
        'comment_id' => 2,
        'record_id' => 1,
        'entry_id' => 1,
        'user_id' => 2,
        'repliedto_user_id' => 1,
        'comment_content' => 'I agree with Alice!',
        'comment_likes' => 5,
        'comment_status' => 'A',
        'date' => '2024-08-21'
    ],
    [
        'comment_id' => 3,
        'record_id' => 1,
        'entry_id' => 2,
        'user_id' => 3,
        'repliedto_user_id' => null,
        'comment_content' => 'The abstract is well-written.',
        'comment_likes' => 3,
        'comment_status' => 'A',
        'date' => '2024-08-20'
    ],
    [
        'comment_id' => 4,
        'record_id' => 2,
        'entry_id' => 3,
        'user_id' => 2,
        'repliedto_user_id' => null,
        'comment_content' => 'The conclusion could be stronger.',
        'comment_likes' => 0,
        'comment_status' => 'A',
        'date' => '2024-08-20'
    ],
    [
        'comment_id' => 5,
        'record_id' => 2,
        'entry_id' => 2,
        'user_id' => 1,
        'repliedto_user_id' => 3,
        'comment_content' => 'Interesting point, Charlie!',
        'comment_likes' => 2,
        'comment_status' => 'A',
        'date' => '2024-08-19'
    ],
    [
        'comment_id' => 6,
        'record_id' => 3,
        'entry_id' => 1,
        'user_id' => 3,
        'repliedto_user_id' => null,
        'comment_content' => 'This needs more references.',
        'comment_likes' => 1,
        'comment_status' => 'A',
        'date' => '2024-08-18'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABSTRACT - LNHS Research Hub</title>
    <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/mainStyle.css">
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

        .like-button {
            cursor: pointer;
        }
        
        .liked {
            color: red; /* Change the icon color to red */
            font-weight: bold; /* Optional: make it bold */
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

                            <!-- Comment Form -->
                            <form id="commentForm" method="POST" action="../../backend/comment.php" class="d-flex align-items-center">
                                <div class="form-outline flex-grow-1 mb-2">
                                    <input type="hidden" name="record_id" value="<?php echo $_GET['abstractId']; ?>"> 
                                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                    <input type="text" id="addANote" name="comment_content" class="form-control border-dark" placeholder="+ Add comment..." required />
                                </div>
                                <button type="submit" class="btn btn-primary ms-2 mb-2">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>

                            <!-- Comment List -->
                            <div id="commentsContainer" class="comment-container" data-abstract-id="<?php echo $_GET['abstractId']; ?>" data-user-id="<?php echo $_SESSION['user_id']; ?>">

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
    <script src="../../scripts/fetchRecords.js"></script>
    <script src="../../scripts/fetchOneRecord.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('comment');
        });

        document.querySelectorAll('.like-btn').forEach(button => {

            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                const likeCountElement = document.getElementById(`like-count-${commentId}`);
                let currentLikes = parseInt(likeCountElement.textContent);

                // Simulate a server request here
                // Example: send an AJAX request to update likes in the database

                // Update the like count
                likeCountElement.textContent = currentLikes + 1;

                // Optional: Provide feedback to the user (e.g., a success message)
                // Swal.fire('Liked!', 'You have liked this comment.', 'success');
            });
        });
    </script>
</body>
</html>
