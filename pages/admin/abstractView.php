<?php

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

        .like-btn {
            cursor: pointer;
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
                            <!-- <div data-mdb-input-init class="form-outline mb-2">
                                <input type="text" id="addANote" class="form-control border-dark" placeholder="+Add comment..." />
                            </div> -->
                             <!-- Comment Form -->
                             <form id="commentForm" method="POST" action="commentForm.php" class="d-flex align-items-center">
                                <div class="form-outline flex-grow-1 mb-2">
                                    <input type="text" id="addANote" name="comment_content" class="form-control border-dark" placeholder="+Add comment..." required />
                                </div>
                                <input type="hidden" name="record_id" value="1"> 
                                <input type="hidden" name="entry_id" value="1"> 
                                <input type="hidden" name="user_id" value="1"> 
                                <input type="hidden" name="repliedto_user_id" value="">
                                <button type="submit" class="btn btn-primary ms-2 mb-2">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>

                            <!-- Comment List -->
                            <div class="comment-container">
                                <?php foreach ($comments as $comment): ?>
                                    <div class="card comment-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-2">
                                                <div class="d-flex flex-row align-items-center">
                                                    <!-- avatar iamage -->
                                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(<?php echo htmlspecialchars($comment['user_id']); ?>).webp" alt="avatar" width="25" height="25" />
                                                    <p class="small mb-0 ms-2"><?php echo htmlspecialchars($comment['user_id']); ?></p>
                                                </div>
                                                <div class="d-flex flex-row align-items-center">
                                                    <!-- Likes -->
                                                    <button class="btn btn-link like-btn" data-comment-id="<?php echo htmlspecialchars($comment['comment_id']); ?>">
                                                        <i class="far fa-thumbs-up mx-2 fa-xs text-body" style="margin-top: -0.16rem;"></i>
                                                    </button>
                                                    <p class="small text-muted mb-0" id="like-count-<?php echo htmlspecialchars($comment['comment_id']); ?>">
                                                        <?php echo htmlspecialchars($comment['comment_likes']); ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <p><?php echo htmlspecialchars($comment['comment_content']); ?></p>
                                            <p><small>Date: <?php echo htmlspecialchars($comment['date']); ?></small></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
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
