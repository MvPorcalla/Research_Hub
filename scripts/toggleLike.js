document.addEventListener('DOMContentLoaded', () => {

    // Attach event listener to a parent element
    document.body.addEventListener('click', function(event) {
        if (event.target && (event.target.matches('.like-button') || event.target.closest('.like-button'))) {

            const button = event.target.matches('.like-button') 
            ? event.target 
            : event.target.closest('.like-button');
        
            if (!button) return;

            const recordId = button.getAttribute('data-record-id');
            const userId = document.getElementById('abstractTiles').getAttribute('data-user-id');

            fetch('../../backend/toggle_like.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ recordId, userId })
            })
            .then(response => response.json())
            .then(result => {
                if (result.liked !== undefined) {
                    button.classList.toggle('btn-outline-danger');
                    button.classList.toggle('btn-danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
});