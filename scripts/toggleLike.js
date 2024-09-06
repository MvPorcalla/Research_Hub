document.addEventListener('DOMContentLoaded', () => {

    document.body.addEventListener('click', function(event) {
        // Check if the clicked element or its closest parent matches the '.like-button' class
        if (event.target && (event.target.matches('.like-button') || event.target.closest('.like-button'))) {

            // Determine the actual button element clicked, either directly or through its closest parent
            const button = event.target.matches('.like-button') 
                ? event.target 
                : event.target.closest('.like-button');

            if (!button) return; // Exit if no button is found

            const icon = button.querySelector('svg');

            const recordId = button.getAttribute('data-record-id');
            const commentId = button.getAttribute('data-comment-id');
            const entryId = button.getAttribute('data-entry-id');

            let container = document.getElementById('abstractTiles') || document.getElementById('favoriteTiles') || document.getElementById('commentsContainer') || document.getElementById('entriesContainer');
            const userId = container ? container.getAttribute('data-user-id') : null;

            // Send a POST request to the server to toggle the like status
            fetch('../../backend/toggle_like.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ recordId, entryId, commentId, userId })
            })
            .then(response => response.json()) // Parse the response as JSON
            .then(result => {
                if (result.liked !== undefined) { // Check if the result contains a 'liked' status
                    if (recordId) {
                        // Toggle button classes for record like
                        button.classList.toggle('btn-outline-danger');
                        button.classList.toggle('btn-danger');

                    } else if ((commentId || entryId) && icon) {

                        icon.classList.toggle('liked');

                        // Update the likes count display
                        const likesSection = button.closest('.likes-section');
                        const likesText = commentId ? likesSection.querySelector('p') : likesSection.querySelector('span');
                        let number = parseInt(likesText.innerText, 10);
                        likesText.innerText = (result.liked) ? (number + 1) : (number - 1);
                    }
                }
            })
            .catch(error => {
                // Log any errors that occur during the fetch operation
                console.error('Error:', error);
            });
        }
    });
});
