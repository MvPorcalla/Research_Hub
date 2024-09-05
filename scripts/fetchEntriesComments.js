var url = window.location.href;

if (url.includes('forum.php')) {
    document.addEventListener('DOMContentLoaded', () => {
    
        const fetchEntriesComments = async () => {
            try {
                
                if (document.getElementById('entriesContainer')) {
    
                    const entriesContainer = document.getElementById('entriesContainer');
    
                    const response = await fetch(`../../backend/fetchRecords.php?fetch=entries`);
                    if (!response.ok) throw new Error('Network response was not ok');
    
                    const data = await response.json();
    
                    for (const dataRow of data) {
    
                        const timestamp = dataRow.entryTimestamp;
    
                        const timePassed = timeAgo(timestamp);
                        const formattedDateTime = formatDateTime(timestamp);
    
                        const mi = (dataRow.mi == '') ? '' : `${dataRow.mi}. `;
                        const fullName = `${dataRow.firstName} ${mi}${dataRow.lastName}`;

                        let entryPoster = `
                            <div class="d-flex align-items-center">
                                <img src="../${dataRow.imgDir}" alt="${dataRow.userName}" title="${fullName}" class="img-fluid rounded-circle me-3" style="width: 50px; height: 50px;">
                                <div>
                                    <h4 title="${fullName}" class="mb-0">@${dataRow.userName}</h4>
                                    <p title="${formattedDateTime}" class="ms-1 mb-0">${timePassed}</p>
                                </div>
                            </div>
                        `;

                        let disabled = '';

                        if (url.includes('admin/forum.php')) {
                            entryPoster = `
                                <div class="row">
                                    <div class="col-md-11">
                                            ${entryPoster}
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-outline-danger" onclick="deleteEntry(${dataRow.entryId})" title="Delete">
                                            <i class='fas fa-trash-alt'></i>
                                        </button>

                                    </div>
                                </div>
                            `;
                            disabled = ' disabled';
                        }
    
                        let tileHTML = `
                            <div class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                                <div class="row mt-3 mx-3">
                                    <div class="col-md-12 mb-sm-0">
                                        <div class="entry-container">

                                            <div class=" mb-3">
                                                ${entryPoster}
                                            </div>

                                            <!-- Entry content displayed -->
                                            <div class="border p-3 rounded">
                                                <h5>${dataRow.entryContent}</h5>
                                            </div>

                                            <!-- Stats and Buttons Row -->
                                            <div class="row mt-3">
                                                <div class="col-12 text-end">

                                                    <!-- Likes with Like Button -->
                                                    <div class="d-inline-block text-center me-3 likes-section">
                                                        <button class="btn btn-link p-0 ms-1 text-decoration-none like-button" data-entry-id="${dataRow.entryId}"${disabled}>
                                                            <i class="fa-solid fa-thumbs-up"></i> Like
                                                        </button>
                                                        <span class="ms-2">${dataRow.entryLikes}</span>
                                                    </div>

                                                    <!-- Replies with Comment Button -->
                                                    <div class="d-inline-block text-center me-3">
                                                        <button class="btn btn-link p-0 ms-1 text-decoration-none" onclick="toggleComments(${dataRow.entryId})">
                                                            <i class="fa-solid fa-comment-dots"></i> Reply
                                                        </button>
                                                        <span id="entryComments-${dataRow.entryId}" class="ms-2"></span>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <hr>

                                            <!-- Comments Section -->
                                            <div id="comment-section-${dataRow.entryId}" data-entry-id="${dataRow.entryId}" class="comments-section ms-3 mt-3">
                                                <div id="comments-${dataRow.entryId}" class="card-body">
                                                    <!-- Data will be dynamically inserted here -->
                                                </div>
                                            </div>
                                            <!-- /End of Comments Section -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        entriesContainer.innerHTML += tileHTML;

                        const entryComments = document.getElementById(`entryComments-${dataRow.entryId}`);
                        if (entryComments) {
                            await displayCommentsForEntry(dataRow.entryId, entryComments);
                        }
                    };
                }
            } catch (error) {
                console.error('Error fetching records:', error);
            }
        };
    
        fetchEntriesComments().then(() => { getLikes(); });
    });
    
    function toggleComments(entryId) {
        // Get the comments section element by its ID, which includes the entryId to ensure uniqueness
        const commentsSection = document.getElementById(`comment-section-${entryId}`);
    
        if (commentsSection) {
            // Toggle the display property of the comments section between 'block' and 'none'
            commentsSection.style.display = (commentsSection.style.display === 'none' || commentsSection.style.display === '') ? 'block' : 'none';
    
            // Select all elements with the class 'comments-section'
            const sections = document.querySelectorAll('.comments-section');
    
            // Loop through each section to hide all other comments sections
            sections.forEach((section) => {
                // Skip the current comments section being toggled
                if (section.id == `comment-section-${entryId}`) return;
    
                // Hide all other comments sections
                section.style.display = 'none';
            });
        }
    }
    
}

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
                commentsContainer.innerHTML = `<small>No comments yet.</small>`;
            } else {
                const commentsElement = document.getElementById(`comments-${entryId}`);
                data.forEach(comment => {
                    const { userIdImage, userName, commentContent, commentTimestamp } = comment;
                    const commentTimePassed = timeAgo(commentTimestamp);
                    const commentFormattedDateTime = formatDateTime(commentTimestamp);

                    let tileHTML = `
                        <div class="row">
                            <div class="comment d-flex col-md-10">
                                <img src="../${userIdImage}" alt="${userName}" class="img-fluid rounded-circle me-3" style="width: 30px; height: 30px;">
                                <p><strong>${userName}:</strong> ${commentContent}</p>
                                <hr>
                            </div>
                            <div class="col-md-2">
                                <p title="${commentFormattedDateTime}" style="cursor: pointer;"><small>${commentTimePassed}</small></p>
                            </div>
                        </div>
                    `;
                    commentsElement.innerHTML += tileHTML;
                });
                
                if (url.includes('user/forum.php')) {
                    const addCommentForm = `
                        <!-- Comment Form for Main Entry -->
                        <div class="card-body mt-1">
                            <form method="post" action="../../backend/comment.php">
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
                                <input type="hidden" name="entry_id" value="${entryId}">
                            </form>
                        </div>
                    `;
                    commentsContainer.innerHTML += addCommentForm;
                }

            }
        } catch (error) {
            console.error('Error fetching comments:', error);
        }
    }
}

async function deleteEntry(entryId) {
    // SweetAlert confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to delete an entry.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete'
    }).then(async (result) => {
        if (result.isConfirmed) {
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
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'The entry has been deleted.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Refresh the page
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: result.message || 'Failed to delete entry.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while deleting the entry.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.error('Error deleting entry:', error);
            }
        }
    });
}