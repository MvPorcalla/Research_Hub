<?php
include_once "../../includes/db.php";
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == 'A') header("location: ../../index.php");

// Mock data for forum entries and comments
$forum_entries = [
    [
        'entry_id' => 1,
        'user_id' => 'Melvin',
        'entry_content' => 'Challenges in Conducting Qualitative Research',
        'entry_likes' => 87,
        'entry_status' => 'A',
        'posted_time' => '10 minutes ago',
        'user_name' => 'JaneDoe',
        'replies' => 4,
        'views' => 150,
        'comments' => [
            [
                'comment_id' => 1,
                'user_id' => 'McDo',
                'comment_content' => 'This is a very insightful discussion!',
                'comment_likes' => 10,
                'comment_status' => 'A'
            ],
            [
                'comment_id' => 2,
                'user_id' => 'Melvin',
                'comment_content' => '@Mcdo Tanga mo Taena ka',
                'comment_likes' => 10,
                'comment_status' => 'A'
            ],
            [
                'comment_id' => 1,
                'user_id' => 'McDo',
                'comment_content' => '@Melvin who you ka!',
                'comment_likes' => 10,
                'comment_status' => 'A'
            ],
            [
                'comment_id' => 2,
                'user_id' => 'Melvin',
                'comment_content' => '@Mcdo Mama mo who you!',
                'comment_likes' => 10,
                'comment_status' => 'A'
            ],
        ]
    ],
    [
        'entry_id' => 2,
        'user_id' => 'McDo',
        'entry_content' => 'Best Practices for Data Analysis in Research',
        'entry_likes' => 112,
        'entry_status' => 'A',
        'posted_time' => '1 hour ago',
        'user_name' => 'JohnSmith',
        'replies' => 0,
        'views' => 200,
        'comments' => []
    ],
    // Add more mock entries as needed
];
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
                            <!-- filter Content -->
                            <div class="row text-left mb-3">
                                <div class="col-lg-10 text-lg-right">
                                    <h1 class=''>Research Hub Forum</h1>
                                </div>

                                <div class='col-lg-2 text-center'>
                                    <a class="btn btn-sm btn-block btn-success rounded-0 py-2 mb-2 bg-op-6" href="#">Ask a Question</a>
                                </div>
                            </div>

                           <!-- Forum Posts -->
                           <?php foreach ($forum_entries as $entry): ?>
                                <div class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                                    <div class="row mt-3 mx-3">
                                        <div class="col-md-12 mb-sm-0">
                                            <div class="entry-container">

                                                <div class=" mb-3">
                                                    
                                                    <div class="d-flex align-items-center">
                                                        <img id="idImage" src="../../assets/icons/Vector.png" alt="User Image" class="img-fluid rounded-circle me-3" style="width: 45px; height: 45px;">
                                                        <div>
                                                            <h4 class="mb-0">@<?= $entry['user_id']; ?></h4>
                                                            <p class="ms-1 mb-0"><?= $entry['posted_time']; ?></p>
                                                        </div>
                                                    </div>

                                                </div>

                                                <!-- Entry content displayed -->
                                                <div class="border p-3 rounded">
                                                    <h5><?= $entry['entry_content']; ?></h5>
                                                </div>

                                                <!-- Stats and Buttons Row -->
                                                <div class="row mt-3">
                                                    <div class="col-12 text-end">
                                                        <!-- Likes with Like Button -->
                                                        <div class="d-inline-block text-center me-3">
                                                            <button class="btn btn-link p-0 ms-1 text-decoration-none" onclick="likeEntry(<?= $entry['entry_id']; ?>)">
                                                                <i class="fa-solid fa-thumbs-up"></i> Like
                                                            </button>
                                                            <span class="ms-2"><?= $entry['entry_likes']; ?></span>
                                                        </div>
                                                        <!-- Replies with Comment Button -->
                                                        <div class="d-inline-block text-center me-3">
                                                            <button class="btn btn-link p-0 ms-1 text-decoration-none" onclick="toggleComments(<?= $entry['entry_id']; ?>)">
                                                                <i class="fa-solid fa-comment-dots"></i> Reply
                                                            </button>
                                                            <span class="ms-2"><?= $entry['replies']; ?></span>
                                                        </div>
                                                      
                                                    </div>
                                                </div>

                                                <hr>

                                                <!-- Comments Section -->
                                                <div id="comments-<?= $entry['entry_id']; ?>" class="comments-section ms-3 mt-3">
                                                    <?php if (!empty($entry['comments'])): ?>
                                                        <div class="card-body">
                                                            <?php foreach ($entry['comments'] as $comment): ?>
                                                                <div class="comment">
                                                                    <p><strong><?= $comment['user_id']; ?>:</strong> <?= $comment['comment_content']; ?></p>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>

                                                    <!-- Comment Form for Main Entry -->
                                                    <div class="card-body mt-3">
                                                        <form method="post" action="">
                                                            <div class="form-row align-items-center">
                                                                <div class="col">
                                                                    <div class="input-group">
                                                                        <textarea class="form-control" name="comment_content" rows="1" placeholder="Add a comment..."></textarea>
                                                                        <button type="submit" class="btn btn-primary ms-2" title="Post Comment">
                                                                            <i class="fa-solid fa-paper-plane"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="entry_id" value="<?= $entry['entry_id']; ?>">
                                                        </form>
                                                    </div>

                                                </div>
                                                <!-- /End of Comments Section -->

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                            <!-- /End of forum posts -->
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
    <script>
        function toggleComments(entryId) {
            const commentsSection = document.getElementById(`comments-${entryId}`);
            if (commentsSection.style.display === 'none' || commentsSection.style.display === '') {
                commentsSection.style.display = 'block';
            } else {
                commentsSection.style.display = 'none';
            }
        }
    </script>
</body>

</html>

