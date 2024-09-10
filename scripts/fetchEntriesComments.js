var url = window.location.href;

if (url.includes('forum.php')) {

    document.addEventListener('DOMContentLoaded', () => {

        // Function to fetch entries and their associated comments from the backend
        const fetchEntriesComments = async () => {
            try {
                // Check if the container for entries exists in the DOM
                if (document.getElementById('entriesContainer')) {

                    const entriesContainer = document.getElementById('entriesContainer');

                    // Get the current URL's query string
                    let queryString = window.location.search;
                    queryString = queryString ? queryString.replace('?', '&') : '';

                    const urlParams = new URLSearchParams(queryString);
                    const entryParam = urlParams.has('entry_id') ? urlParams.get('entry_id') : '';
                    clearUrlParam('entry_id');

                    // Fetch entries data from the backend
                    const response = await fetch(`../../backend/fetchRecords.php?fetch=entries${queryString}`);
                    if (!response.ok) throw new Error('Network response was not ok'); // Handle errors

                    const data = await response.json(); // Parse the JSON response data

                    let count = 0;
                    // Loop through each entry data row
                    for (const dataRow of data) {

                        if (entryParam == dataRow.entryId) {
                            if (count == 0) {
                                count++;
                            } else {
                                continue;
                            }
                        }

                        const timestamp = dataRow.entryTimestamp;

                        const timePassed = timeAgo(timestamp); // Calculate the time passed since the entry was posted
                        const formattedDateTime = formatDateTime(timestamp); // Format the timestamp for display

                        // Build the user's full name
                        const mi = (dataRow.mi == '') ? '' : `${dataRow.mi}. `;
                        const fullName = `${dataRow.firstName} ${mi}${dataRow.lastName}`;

                        // Generate the HTML for the entry poster (user who posted the entry)
                        let entryPoster = `
                            <div class="d-flex align-items-center">
                                <img src="../${dataRow.imgDir}" alt="${dataRow.userName}" title="${fullName}" class="img-fluid rounded-circle me-3" style="width: 50px; height: 50px;">
                                <div>
                                    <h4 title="${fullName}" class="mb-0">@${dataRow.userName}</h4>
                                    <p title="${formattedDateTime}" class="ms-1 mb-0">${timePassed}</p>
                                </div>
                            </div>
                        `;

                        let disabled = ''; // Variable to hold the disabled state of buttons

                        // If the URL contains 'admin/forum.php', add delete button functionality for admin
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
                            disabled = ' disabled'; // Disable buttons for admin view
                        }

                        // Generate the HTML for each entry tile
                        let tileHTML = `
                            <div class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                                <div class="row mt-3 mx-3">
                                    <div class="col-md-12 mb-sm-0">
                                        <div class="entry-container">

                                            <!-- Entry poster section -->
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
                        
                        // Insert the generated tile HTML into the entries container
                        entriesContainer.innerHTML += tileHTML;

                        const entryComments = document.getElementById(`entryComments-${dataRow.entryId}`);
                        if (entryComments) {
                            // Display the comments for the entry
                            await displayCommentsForEntry(dataRow.entryId, entryComments);
                        }
                    }

                    if (entryParam != '') toggleComments(entryParam);
                }
            } catch (error) {
                console.error('Error fetching records:', error); // Log any errors that occur during the fetch operation
            }
        };

        // Fetch entries and comments, then get likes for each entry
        fetchEntriesComments()
            .then(() => { getLikes(); })
            .then(() => {
                const commentForms = document.querySelectorAll('.forum-comment-form');

                commentForms.forEach(form => {

                    const entryId = form.querySelector('#entry_id').value;

                    filterBadWords(`forumCommentForm_${entryId}`, `commentContent_${entryId}`, `error_${entryId}`);
                });
            });
    });
    
    // Function to display comment section for a specified entry and hide other comment sections
    function toggleComments(entryId) {
        console.log('function');

        const commentsSection = document.getElementById(`comment-section-${entryId}`);
    
        if (commentsSection) {
            console.log('toggle');
            // Toggle the display property of the comments section between 'block' and 'none'
            commentsSection.style.display = (commentsSection.style.display === 'none' || commentsSection.style.display === '') ? 'block' : 'none';
    
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

// Fetch comments for entry
async function displayCommentsForEntry(entryId, entryComments) {

    const commentsContainer = document.getElementById(`comment-section-${entryId}`);
    if (commentsContainer) {
        try {
            // Fetch comments related to the specific entry from the backend
            const response = await fetch(`../../backend/fetchRecords.php?fetch=comments&comment_on=entry_id&record_id=${entryId}`);
            if (!response.ok) throw new Error('Network response was not ok');

            // Parse the response JSON data
            const data = await response.json();

            // Update the reply count display
            entryComments.textContent = data.length;

            // Display a message if no comments are found
            if (data.length === 0) {
                commentsContainer.innerHTML = `<small>No comments yet.</small>`;
            } else {
                // Get the element where comments will be appended
                const commentsElement = document.getElementById(`comments-${entryId}`);
                
                // Loop through each comment and create HTML for each
                data.forEach(comment => {
                    const { userIdImage, userName, commentContent, commentTimestamp } = comment;
                    const commentTimePassed = timeAgo(commentTimestamp); // Calculate the time passed since the entry was posted
                    const commentFormattedDateTime = formatDateTime(commentTimestamp); // Format the timestamp for display

                    // HTML structure for each comment
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
                    // Append the comment HTML to the comments element
                    commentsElement.innerHTML += tileHTML;
                });
            }
                
            // If on the user/forum page, add a comment form
            if (url.includes('user/forum.php')) {
                const addCommentForm = `
                    <!-- Comment Form for Main Entry -->
                    <div class="card-body mt-1">
                        <form id="forumCommentForm_${entryId}" method="post" action="../../backend/comment.php" class="forum-comment-form">
                            <div class="form-row align-items-center">
                                <div class="col">
                                    <div class="input-group">
                                        <textarea class="form-control" name="comment_content" id="commentContent_${entryId}" rows="1" placeholder="Add a comment..." required></textarea>
                                        <button type="submit" class="btn btn-primary ms-2" title="Post Comment">
                                            <i class="fa-solid fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="entry_id" name="entry_id" value="${entryId}">
                            <p id="error_${entryId}" style="color: red;"></p>
                        </form>
                    </div>
                `;
                // Append the comment form to the comments container
                commentsContainer.innerHTML += addCommentForm;
            }
        } catch (error) {
            // Log any errors encountered during fetch
            console.error('Error fetching comments:', error);
        }
    }
}

async function deleteEntry(entryId) {
    // Display a SweetAlert confirmation dialog before proceeding with deletion
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to delete an entry.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete'
    }).then(async (result) => {
        // If the user confirms the deletion
        if (result.isConfirmed) {
            try {
                // Send a POST request to delete the entry
                const response = await fetch('../../backend/deleteEntry.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json' // Set the content type to JSON
                    },
                    body: JSON.stringify({ entryId }) // Send the entryId in the request body
                });

                // Check if the response is okay (status in the range 200-299)
                if (!response.ok) throw new Error('Network response was not ok');

                // Parse the JSON response
                const result = await response.json();

                // If the deletion was successful
                if (result.success) {
                    // Show a success alert
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'The entry has been deleted.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Reload the page to reflect the changes
                        location.reload();
                    });
                } else {
                    // Show an error alert with the message from the response
                    Swal.fire({
                        title: 'Error!',
                        text: result.message || 'Failed to delete entry.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                // Show an error alert if an exception occurs
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while deleting the entry.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                // Log the error for debugging purposes
                console.error('Error deleting entry:', error);
            }
        }
    });
}
