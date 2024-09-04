async function displayComments(abstractId = '') {
    if (document.getElementById('commentsContainer')) {

        const commentsContainer = document.getElementById('commentsContainer');
        if (!abstractId) {
            abstractId = commentsContainer.getAttribute('data-abstract-id');
        }

        const response = await fetch(`../../backend/fetchRecords.php?fetch=comments&comment_on=record_id&record_id=${abstractId}`);
        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();

        if (data.length == 0) {

            let tileHTML = `<small>No comments yet.</small>`;
            commentsContainer.innerHTML += tileHTML;
            
        } else {

            data.forEach(dataRow => {

                const timestamp = dataRow.commentTimestamp;
        
                const timePassed = timeAgo(timestamp);
                const formattedDateTime = formatDateTime(timestamp);
        
                var url = window.location.href;
                var type = url.includes('admin') ? 'admin' : 'user';
        
                let buttonHTML;
                let likesHTML = '';
                
                // Change the button HTML based on the context
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
        
                let tileHTML = `
                    <div class="card comment-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="d-flex flex-row align-items-center">
                                    <img src="../${dataRow.userIdImage}" alt="avatar" class="img-fluid rounded-circle" style="width: 25px; height: 25px;" />
                                    <p class="small mb-0 ms-2">${dataRow.userName}</p>
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
                commentsContainer.innerHTML += tileHTML;
            });
        }
    }
}