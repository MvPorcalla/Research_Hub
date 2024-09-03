// handleAfterFetch.js

function handleAfterFetch() {
    var url = window.location.href;

    if (url.includes('pages/user/index.php')) {
        const updateButtonStatuses = () => {
            let userIdElement = document.getElementById('abstractTiles');
            const userId = userIdElement ? userIdElement.getAttribute('data-user-id') : null;
            const buttons = document.querySelectorAll('.like-button');

            const requests = Array.from(buttons).map(button => {
                const abstractId = button.getAttribute('data-record-id');
                const commentId = button.getAttribute('data-comment-id');

                if (abstractId) {
                    return fetch(`../../backend/get_like_status.php?record_type=record&recordId=${abstractId}&userId=${userId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.like_status === 'A') {
                                button.classList.add('btn-danger');
                                button.classList.remove('btn-outline-danger');
                            } else {
                                button.classList.add('btn-outline-danger');
                                button.classList.remove('btn-danger');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching like status:', error);
                        });

                } else if (commentId) {
                    return fetch(`../../backend/get_like_status.php?record_type=comment&recordId=${commentId}&userId=${userId}`)
                        .then(response => response.json())
                        .then(data => {
                            const icon = button.querySelector('svg');
                            if (data.like_status == 'A') {
                                icon.classList.add('liked');
                            } else {
                                icon.classList.remove('liked');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching like status:', error);
                        });
                }
            });

            // Ensure all requests are completed
            Promise.all(requests).then(() => {
                console.log('All like statuses updated');
            });
        };

        // Call the function to update button statuses
        updateButtonStatuses();

        const commentsModal = document.getElementById('commentsModal');

        if (commentsModal) {
            // Event listener for when the modal is shown
            commentsModal.addEventListener('show.bs.modal', async function (event) {
                // Your existing logic for handling modal events
                const button = event.relatedTarget;
                const abstractId = button.getAttribute('data-record-id');
                const abstractTitle = button.getAttribute('data-record-title');

                const modalLabel = document.getElementById('commentsModalLabel');
                modalLabel.innerText = abstractTitle;

                const abstractIdField = document.getElementById('record_id');
                abstractIdField.value = abstractId;

                if (document.getElementById('commentsContainer')) {
                    const commentsContainer = document.getElementById('commentsContainer');

                    const response = await fetch(`../../backend/fetchRecords.php?fetch=comments&comment_on=record_id&record_id=${abstractId}`);
                    if (!response.ok) throw new Error('Network response was not ok');

                    const data = await response.json();

                    if (data.length == 0) {
                        let tileHTML = `<small>No comments yet.</small>`;
                        commentsContainer.innerHTML += tileHTML;
                    } else {
                        const noCommentElement = document.getElementById('no_comment');
                        if (noCommentElement) noCommentElement.remove();

                        displayCommentTiles(data, commentsContainer, abstractId);
                    }
                }

                // Call the function to update button statuses
                updateButtonStatuses();
            });
        }
    }
}
