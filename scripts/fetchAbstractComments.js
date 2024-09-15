// Async function to display comments for a given abstract ID
async function displayComments(abstractId = '') {
    if (document.getElementById('commentsContainer')) {

        const commentsContainer = document.getElementById('commentsContainer');

        // If no abstractId is provided, get it from the 'data-abstract-id' attribute of the container
        if (!abstractId) {
            abstractId = commentsContainer.getAttribute('data-abstract-id');
        }

        // Fetch comments from the backend for the given abstract ID
        const response = await fetch(`../../backend/fetchRecords.php?fetch=comments&comment_on=record_id&record_id=${abstractId}`);
        
        // Throw an error if the response is not ok
        if (!response.ok) throw new Error('Network response was not ok');

        // Parse the response data as JSON
        const data = await response.json();

        if (data.length == 0) {

            // Display a message indicating no comments are available
            let tileHTML = `<small>No comments yet.</small>`;
            commentsContainer.innerHTML += tileHTML;
            
        } else {

            // Iterate through each comment and create HTML for displaying
            data.forEach(dataRow => {

                const timestamp = dataRow.commentTimestamp;
        
                const timePassed = timeAgo(timestamp); // Calculate the time passed since the entry was posted
                const formattedDateTime = formatDateTime(timestamp); // Format the timestamp for display
        
                // Build the user's full name
                const mi = (dataRow.middleInitial == '') ? '' : `${dataRow.middleInitial}. `;
                const fullName = `${dataRow.firstName} ${mi}${dataRow.lastName}`;

                var url = window.location.href;
                var type = url.includes('admin') ? 'admin' : 'user';
        
                let buttonHTML;
                let likesHTML = '';
                
                // Change the button HTML based on the user type
                if (type === 'admin') {
                    buttonHTML = `
                        <div class="d-flex flex-row align-items-center">
                            <button class="btn px-0" onclick="window.location.href='../../backend/delete.php?abstract_id=${abstractId}&comment_id=${dataRow.commentId}'">
                                <i class="fas fa-trash mx-2 fa-xs text-body" style="margin-top: -0.16rem;"></i>
                            </button>
                        </div>
                    `;
                    likesHTML = `
                        <div class="d-flex flex-row align-items-center">
                            <p><small>Likes: ${dataRow.commentLikes}</small></p>
                        </div>
                    `;
                } else {
                    buttonHTML = `
                        <div class="likes-section d-flex flex-row align-items-center">
                            <button class="btn like-button px-0" data-comment-id="${dataRow.commentId}">
                                <i class="far fa-thumbs-up mx-2 fa-xs text-body" style="margin-top: -0.16rem;"></i>
                            </button>
                            <p class="small text-muted mb-0 me-2">${dataRow.commentLikes}</p>
                        </div>
                    `;
                }
        
                // Construct the HTML for each comment card
                let tileHTML = `
                    <div class="card comment-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="d-flex flex-row align-items-center">
                                    <img title="${fullName}" src="../${dataRow.userIdImage}" alt="${dataRow.userName}" class="img-fluid rounded-circle" style="width: 25px; height: 25px;" />
                                    <p title="${fullName}" class="small mb-0 ms-2">${dataRow.userName}</p>
                                </div>
                                ${buttonHTML}
                            </div>
                            <p class="text-start">${dataRow.commentContent}</p>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex flex-row align-items-center">
                                    <p title="${formattedDateTime}" style="cursor: pointer;"><small>${timePassed}</small></p>
                                </div>
                                ${likesHTML}
                            </div>
                        </div>
                    </div>
                `;
                // Append the constructed HTML to the comments container
                commentsContainer.innerHTML += tileHTML;
            });
        }
    }
}
