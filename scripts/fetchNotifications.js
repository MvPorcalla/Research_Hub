async function fetchNotifications() {
    try {
        const notificationsContainer = document.getElementById('notificationsContainer');

        if (notificationsContainer) {

            const response = await fetch('../../backend/fetch_notifications.php');

            // Handle any network errors
            if (!response.ok) throw new Error('Network response was not ok');

            // Parse the JSON response
            const result = await response.json();

            // Iterate through the notifications array and handle each notification
            result.notifications.forEach(notification => {

                switch (notification.type) {
                    case 'pending':

                        const pendingCount = document.getElementById('pendingCount');
                
                        if (sessionStorage.getItem('seenPendingGuests') !== 'true') {
                            if (notification.count != 0) pendingCount.innerText = notification.count;
                        }
    
                        if (window.location.href.includes('pendingRequest.php')) {
                            pendingCount.hidden = true;
    
                            sessionStorage.setItem('seenPendingGuests', 'true');
                        }

                        break;
                
                    case 'abstract':

                        // ${notification.count}
                        // ${notification.latest}
                        
                        break;
                
                    case 'comment':
                        
                        break;
                
                    default:
                        break;
                }
            });
        }

    } catch (error) {
        console.error('Error fetching records:', error); // Log any errors that occur during the fetch operation
    }
}

document.addEventListener('DOMContentLoaded', function() {
    fetchNotifications();
});