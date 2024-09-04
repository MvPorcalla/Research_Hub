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
    <!-- <script src="../../scripts/fetchRecords.js"></script> -->
    <script src="../../scripts/toggleLike.js"></script>

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

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const entriesContainer = document.getElementById('entriesContainer');
            if (entriesContainer) {
                try {
                    const response = await fetch('../../backend/fetchRecords.php?fetch=entries');
                    if (!response.ok) throw new Error('Network response was not ok');

                    const data = await response.json();
                    data.forEach(async (dataRow) => {
                        const { entryTimestamp, mi, firstName, lastName, imgDir, userName, entryContent, entryId, entryLikes } = dataRow;
                        const timePassed = timeAgo(entryTimestamp);
                        const formattedDateTime = formatDateTime(entryTimestamp);
                        const fullName = `${firstName} ${mi ? `${mi}. ` : ''}${lastName}`;

                        const tile = document.createElement('div');
                        tile.className = 'card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0';
                        tile.innerHTML = `
                            <div class="row mt-3 mx-3">
                                <div class="col-md-12 mb-sm-0">
                                    <div class="entry-container">
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="d-flex align-items-center">
                                                        <img src="../${imgDir}" alt="${userName}" title="${fullName}" class="img-fluid rounded-circle me-3" style="width: 50px; height: 50px;">
                                                        <div>
                                                            <h4 title="${fullName}" class="mb-0">@${userName}</h4>
                                                            <p title="${formattedDateTime}" class="ms-1 mb-0">${timePassed}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button class="btn btn-outline-danger" onclick="deleteEntry(${entryId})" title="Delete">
                                                        <i class='fas fa-trash-alt'></i>
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="border p-3 rounded">
                                            <h5>${entryContent}</h5>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12 text-end">
                                                <div class="d-inline-block text-center me-3 likes-section">
                                                    <button class="btn btn-link p-0 ms-1 text-decoration-none like-button" data-entry-id="${entryId}" disabled>
                                                        <i class="fa-solid fa-thumbs-up"></i> Like
                                                    </button>
                                                    <span class="ms-2"> ${entryLikes }</span>
                                                </div>
                                                <div class="d-inline-block text-center me-3">
                                                    <button class="btn btn-link p-0 ms-1 text-decoration-none" onclick="toggleComments(${entryId})">
                                                        <i class="fa-solid fa-comment-dots"></i> Reply
                                                    </button>
                                                    <span id="entryComments-${entryId}" class="ms-2">0</span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div id="comment-section-${entryId}" data-entry-id="${entryId}" class="comments-section ms-3 mt-3" style="display: none;">
                                            <div id="comments-${entryId}" class="card-body"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        entriesContainer.appendChild(tile);

                        const entryComments = document.getElementById(`entryComments-${entryId}`);
                        if (entryComments) {
                            await displayCommentsForEntry(entryId, entryComments);
                        }
                    });
                } catch (error) {
                    console.error('Error fetching entries:', error);
                }
            }
        });

        async function displayCommentsForEntry(entryId, entryComments) {
            const commentsContainer = document.getElementById(`comment-section-${entryId}`);
            if (commentsContainer) {
                try {
                    const response = await fetch(`../../backend/fetchRecords.php?fetch=comments&comment_on=entry_id&record_id=${entryId}`);
                    if (!response.ok) throw new Error('Network response was not ok');

                    const data = await response.json();

                    // Update reply count
                    entryComments.textContent = data.length;

                    if (data.length === 0) {
                        commentsContainer.innerHTML = `<small id="no_comment">No comments yet.</small>`;
                    } else {
                        const commentsElement = document.getElementById(`comments-${entryId}`);
                        data.forEach(comment => {
                            const { userIdImage, userName, commentContent, commentTimestamp } = comment;
                            const commentTimePassed = timeAgo(commentTimestamp);
                            const commentFormattedDateTime = formatDateTime(commentTimestamp);

                            const commentElement = document.createElement('div');
                            commentElement.className = 'row';
                            commentElement.innerHTML = `
                                <div class="comment d-flex col-md-10">
                                    <img src="../${userIdImage}" alt="${userName}" class="img-fluid rounded-circle me-3" style="width: 30px; height: 30px;">
                                    <p><strong>${userName}:</strong> ${commentContent}</p>
                                    <hr>
                                </div>
                                <div class="col-md-2">
                                    <p title="${commentFormattedDateTime}" style="cursor: pointer;">${commentTimePassed}</p>
                                </div>
                            `;
                            commentsElement.appendChild(commentElement);
                        });

                    }
                } catch (error) {
                    console.error('Error fetching comments:', error);
                }
            }
        }

        function toggleComments(entryId) {
            const commentsSection = document.getElementById(`comment-section-${entryId}`);
            if (commentsSection) {
                commentsSection.style.display = (commentsSection.style.display === 'none' || commentsSection.style.display === '') ? 'block' : 'none';
            }
        }

        async function deleteEntry(entryId) {
            try {
                const response = await fetch('../../backend/deleteEntry.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ entryId })
                });
                if (!response.ok) throw new Error('Network response was not ok');

                const result = await response.json();
                if (result.success) {
                    // Log entryId and check if the element is found
                    const entryElement = document.querySelector(`div[data-entry-id="${entryId}"]`);
                    console.log('Entry element:', entryElement);

                    if (entryElement) {
                        entryElement.remove();
                    } else {
                        console.warn('No element found with data-entry-id:', entryId);
                    }
                } else {
                    alert(result.message || 'Failed to delete entry.');
                }
            } catch (error) {
                console.error('Error deleting entry:', error);
            }
        }
        
    </script>

</body>

</html>

