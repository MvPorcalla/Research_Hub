// fetchRecords.js - Fetch records for admin index.php

document.addEventListener('DOMContentLoaded', () => {
    
    const fetchRecords = async () => {
        try {

            if (document.getElementById('commentsContainer')) {

                const commentsContainer = document.getElementById('commentsContainer');
                const abstractId = commentsContainer.getAttribute('data-abstract-id');

                const response = await fetch(`../../backend/fetchRecords.php?fetch=comments&comment_on=record_id&record_id=${abstractId}`);
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();

                if (data.length == 0) {

                    let tileHTML = `<small id="no_comment">No comments yet.</small>`;
                    commentsContainer.innerHTML += tileHTML;
                    
                } else {

                    displayCommentTiles(data, commentsContainer, abstractId);
                }
            }
            
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

                    let tileHTML = `
                                <div class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                                    <div class="row mt-3 mx-3">
                                        <div class="col-md-12 mb-sm-0">
                                            <div class="entry-container">

                                                <div class=" mb-3">
                                                    
                                                    <div class="d-flex align-items-center">
                                                        <img src="../${dataRow.imgDir}" alt="${dataRow.userName}" title="${fullName}" class="img-fluid rounded-circle me-3" style="width: 50px; height: 50px;">
                                                        <div>
                                                            <h4 title="${fullName}" class="mb-0">@${dataRow.userName}</h4>
                                                            <p title="${formattedDateTime}" class="ms-1 mb-0">${timePassed}</p>
                                                        </div>
                                                    </div>

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
                                                            <button class="btn btn-link p-0 ms-1 text-decoration-none like-button" data-entry-id="${dataRow.entryId}">
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

                                                    </div>
                                                </div>
                                                <!-- /End of Comments Section -->

                                            </div>
                                        </div>
                                    </div>

                                </div>
                    `;
                    entriesContainer.innerHTML += tileHTML;

                    if (document.getElementById(`comment-section-${dataRow.entryId}`)) {

                        const commentSection = document.getElementById(`comment-section-${dataRow.entryId}`);
                        const comments = document.getElementById(`comments-${dataRow.entryId}`);
            
                        const response = await fetch(`../../backend/fetchRecords.php?fetch=comments&comment_on=entry_id&record_id=${dataRow.entryId}`);
                        if (!response.ok) throw new Error('Network response was not ok');
            
                        const data = await response.json();

                        const entryComments = document.getElementById(`entryComments-${dataRow.entryId}`);
                        entryComments.innerHTML = data.length;

                        const commentTimestamp = dataRow.entryTimestamp;
    
                        const commentTimePassed = timeAgo(commentTimestamp); // 43 minutes ago
                        const commentFormattedDateTime = formatDateTime(commentTimestamp); // August 28, 2024 at 11:41

                        data.forEach(dataRow => {
                            let tileHTML = `
                            <div class="row">
                                <div class="comment d-flex col-md-10">
                                    <img src="../${dataRow.userIdImage}" alt="${dataRow.userName}" class="img-fluid rounded-circle me-3" style="width: 30px; height: 30px;">
                                    <p><strong>${dataRow.userName}:</strong> ${dataRow.commentContent}</p>
                                    <hr>
                                </div>
                                <div class="col-md-2">
                                    <p title="${commentFormattedDateTime}" style="cursor: pointer;">${commentTimePassed}</p>
                                </div>
                            </div>
                            `;
                            comments.innerHTML += tileHTML;
                        });
            
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
                                    <input type="hidden" name="entry_id" value="${dataRow.entryId}">
                                </form>
                            </div>
                        `;
                        commentSection.innerHTML += addCommentForm;
                    }
                };
            }
        } catch (error) {
            console.error('Error fetching records:', error);
        }
    };

    fetchRecords().then(() => {
        var url = window.location.href;

        if (url.includes('pages/user/forum.php'))
            getLikes();
    });
});
