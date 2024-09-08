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
                        
            const liveToast = document.getElementById('liveToast');
            let recordCount, toastTitle, time, toastBody;
            if (liveToast) {
                recordCount = liveToast.querySelector('#recordCount');
                toastTitle = liveToast.querySelector('#toastTitle');
                time = liveToast.querySelector('#time');
                toastBody = liveToast.querySelector('#toastBody');
            }

            const formattedTimePassed = timeAgo(notification.latest);
            const formattedDateTime = formatDateTime(notification.latest);

                switch (notification.type) {
                    case 'pending':
                        
                        if (liveToast && notification.count != 0) {
                            recordCount.innerText = notification.count;

                            toastTitle.innerText = 'Pending Request' + ((notification.count == 1) ? '' : 's');

                            time.innerText = formattedTimePassed;
                            time.setAttribute("title", formattedDateTime);

                            toastBody.innerHTML = (notification.count == 1)
                                ? `There's a <span class="fw-bold text-danger">pending request</span>. Please review it at your convenience.`
                                : `There's <span class="fw-bold text-danger">${notification.count} pending requests</span>. Please review them at your convenience.`;

                            var toast = new bootstrap.Toast(liveToast);
                            toast.show();
                        }
    
                        break;
                
                    case 'abstract':
                        
                        if (liveToast && notification.count != 0) {
                            recordCount.innerText = notification.count;

                            toastTitle.innerText = 'New Abstract' + ((notification.count == 1) ? '' : 's');

                            time.innerText = formattedTimePassed;
                            time.setAttribute("title", formattedDateTime);

                            toastBody.innerHTML = (notification.count == 1)
                                ? `A <span class="fw-bold text-danger">new abstract</span> has been uploaded. Please review it at your convenience.`
                                : `${notification.count} <span class="fw-bold text-danger"> new abstracts has been uploaded</span>. Please review them at your convenience.`;

                            var toast = new bootstrap.Toast(liveToast);
                            toast.show();
                        }
                        
                        break;
                
                    case 'comment':
    
                        if (notificationsContainer) {

                            if (result.totalNotifCount === 0) {
                                
                                notifHTML = `
                                    <li>
                                        <p class="text-center mb-0">No new notifications.</p>
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
                                                        <small title="${formattedDateTime}">${formattedTimePassed}</small>
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
                
                    case 'like':
    
                        if (notificationsContainer) {

                            if (result.totalNotifCount === 0) {
                                
                                notifHTML = `
                                    <li>
                                        <p class="text-center mb-0">No new notifications.</p>
                                    </li>
                                `;
                                notificationsContainer.innerHTML = notifHTML;

                            } else {
    
                                const notifHTML = `
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="forum.php?entry_id=${notification.entryId}">
                                        <div class="d-flex flex-column w-100">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    New like(s) on your entry: "${notification.entryContent}"
                                                    <div class="text-muted">
                                                        <small title="${formattedDateTime}">${formattedTimePassed}</small>
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
            if (result.totalNotifCount != 0) notificationCount.innerText = result.totalNotifCount;
        });

    } catch (error) {
        console.error('Error fetching records:', error); // Log any errors that occur during the fetch operation
    }
}

document.addEventListener('DOMContentLoaded', function() {
    fetchNotifications();
});