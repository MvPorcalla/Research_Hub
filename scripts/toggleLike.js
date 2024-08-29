document.addEventListener('DOMContentLoaded', () => {

    // Attach event listener to a parent element
    document.body.addEventListener('click', function(event) {
        if (event.target && (event.target.matches('.like-button') || event.target.closest('.like-button'))) {

            const button = event.target.matches('.like-button') 
            ? event.target 
            : event.target.closest('.like-button');
        
            if (!button) return;
            const icon = button.querySelector('svg');

            const recordId = button.getAttribute('data-record-id');
            const commentId = button.getAttribute('data-comment-id');
            const entryId = button.getAttribute('data-entry-id');
            
            let container = document.getElementById('abstractTiles') || document.getElementById('favoriteTiles') || document.getElementById('commentsContainer') || document.getElementById('entriesContainer');
            const userId = container ? container.getAttribute('data-user-id') : null;

            fetch('../../backend/toggle_like.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ recordId, entryId, commentId, userId })
            })
            .then(response => response.json())
            .then(result => {
                if (result.liked !== undefined) {
                    if (recordId) {

                        button.classList.toggle('btn-outline-danger');
                        button.classList.toggle('btn-danger');

                    } else if ((commentId || entryId) && icon) {

                        icon.classList.toggle('liked');

                        const likesSection = button.closest('.likes-section');
                        const likesText = commentId ? likesSection.querySelector('p') : likesSection.querySelector('span');
                        let number = parseInt(likesText.innerText, 10);
                        likesText.innerText = (result.liked) ? (number + 1) : (number - 1);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
});