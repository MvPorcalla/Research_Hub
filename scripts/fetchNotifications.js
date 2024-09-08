async function fetchNotifications() {
    try {

        const response = await fetch('../../backend/fetch_notifications.php');

        // Handle any network errors
        if (!response.ok) throw new Error('Network response was not ok');

        // Parse the JSON response
        const result = await response.json();

        // Iterate through the notifications array and handle each notification
        result.notifications.forEach(notification => {

            const notificationsContainer = document.getElementById('notificationsContainer');

            const latest = timeAgo(notification.latest);

                switch (notification.type) {
                    case 'pending':
    
                        const pendingCount = document.getElementById('pendingCount');
    
                        if (pendingCount) {
                
                            if (sessionStorage.getItem('seenPendingGuests') !== 'true') {
                                if (notification.count != 0) pendingCount.innerText = notification.count;
                            }
    
                            if (window.location.href.includes('pendingRequest.php')) {
                                pendingCount.hidden = true;
    
                                sessionStorage.setItem('seenPendingGuests', 'true');
                            }
                        }
    
                        break;
                
                    case 'abstract':
                        
                        const liveToast = document.getElementById('liveToast');
                        
                        if (liveToast && notification.count != 0) {
                            const abstractCount = liveToast.querySelector('#abstractCount');
                            abstractCount.innerText = notification.count;

                            const time = liveToast.querySelector('#time');
                            time.innerText = latest;

                            const toastBody = liveToast.querySelector('#toastBody');
                            toastBody.innerHTML = (notification.count == 1)
                                ? `A <span class="fw-bold text-danger">new abstract has been uploaded</span>. Please review them at your convenience.`
                                : `${notification.count} <span class="fw-bold text-danger"> new abstracts has been uploaded</span>. Please review them at your convenience.`;

                            var toast = new bootstrap.Toast(liveToast);
                            toast.show();
                        }
                        
                        break;
                
                    case 'comment':
    
                        if (notificationsContainer) {

                            if (result.totalCommentCount === 0) {
                                
                                notifHTML = `
                                    <li>
                                        <p class="text-center mb-0">No notifications.</p>
                                    </li>
                                `;
                                notificationsContainer.innerHTML = notifHTML;

                            } else {
    
                                const notifHTML = `
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="forum.php?entry_id=${notification.entryId}">
                                        <div class="d-flex flex-column w-100">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    New comment(s) on your entry: "${notification.entryContent}"
                                                    <div class="text-muted">
                                                        <small>${latest}</small>
                                                    </div>
                                                </div>
                                                <span class="badge ms-5 bg-success rounded-pill">
                                                    ${notification.count}
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                `;
        
                                const li = document.createElement('li');
                                li.innerHTML = notifHTML;
        
                                notificationsContainer.appendChild(li);

                            }
                        }
                        
                        break;
                }
                                
            const notificationCount = document.getElementById('notificationCount');
            if (result.totalCommentCount != 0) notificationCount.innerText = result.totalCommentCount;
        });

    } catch (error) {
        console.error('Error fetching records:', error); // Log any errors that occur during the fetch operation
    }
}

document.addEventListener('DOMContentLoaded', function() {
    fetchNotifications();
});