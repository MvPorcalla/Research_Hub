async function fetchNotifications() {
    try {

        const response = await fetch('../../backend/fetch_notifications.php');

        // Handle any network errors
        if (!response.ok) throw new Error('Network response was not ok');

        // Parse the JSON response
        const result = await response.json();

        let notifCount = 0;

        result.notifications.sort((a, b) => {
            // Handle null values by considering them as the earliest
            const dateA = a.latest ? new Date(a.latest) : new Date(0);
            const dateB = b.latest ? new Date(b.latest) : new Date(0);
            return dateB - dateA;
        });

        // Iterate through the notifications array and handle each notification
        result.notifications.forEach(notification => {

            const notificationsContainer = document.getElementById('notificationsContainer');
                        
            const liveToast = document.getElementById('liveToast');

            let content, type;

            const formattedTimePassed = timeAgo(notification.latest);
            const formattedDateTime = formatDateTime(notification.latest);

            if (result.totalNotifCount === 0) {
                
                notifHTML = `
                    <li>
                        <p style="width: 350px;" class="text-center mb-0">No new notifications.</p>
                    </li>
                `;
                notificationsContainer.innerHTML = notifHTML;
    
            }

            if (notifCount != 0) notificationsContainer.innerHTML += `<hr class="my-0">`

            switch (notification.type) {
                case 'pending':
                    content = (notification.count == 1)
                        ? `There's a <span class="fw-bold text-danger">pending request</span>. Please review it at your convenience.`
                        : `There's <span class="fw-bold text-danger">${notification.count} pending requests</span>. Please review them at your convenience.`;

                    populateToastContent(liveToast, notification.count, content, formattedTimePassed, formattedDateTime)

                    break;
            
                case 'abstract':
                    
                    content = (notification.count == 1)
                        ? `A <span class="fw-bold text-danger">new abstract</span> has been uploaded. Please review it at your convenience.`
                        : `${notification.count} <span class="fw-bold text-danger"> new abstracts has been uploaded</span>. Please review them at your convenience.`;

                    populateToastContent(liveToast, notification.count, content, formattedTimePassed, formattedDateTime)
                    
                    break;
            
                case 'comment':

                    type = `repl` + ((notification.count == 1) ? 'y' : 'ies');

                    populateNotificationContent(notificationsContainer, notification.entryId, notification.entryContent, notification.count, type, formattedDateTime, formattedTimePassed, notifCount);
                    
                    break;
            
                case 'like':

                    type = `like` + ((notification.count == 1) ? '' : 's');

                    populateNotificationContent(notificationsContainer,  notification.entryId, notification.entryContent, notification.count, type, formattedDateTime, formattedTimePassed, notifCount);
                    
                    break;
            }
                                
            const notificationCount = document.getElementById('notificationCount');
            if (result.totalNotifCount != 0) notificationCount.innerText = result.totalNotifCount;

            if (notification.type == 'comment' || notification.type == 'like') notifCount++;
        });

    } catch (error) {
        console.error('Error fetching records:', error);
    }
}

if (window.location.href.includes('user')) {
    
    document.addEventListener('DOMContentLoaded', function() {
        fetchNotifications().then(() => {
            
            const notificationSeen = seenNotification();
                                    
            const notificationCount = document.getElementById('notificationCount');
            const notifCount = +notificationCount.innerText;
            if (notifCount != 0) notificationCount.innerText = notifCount - notificationSeen;
        });
    });
}

function populateToastContent(liveToast, count, content, formattedTimePassed, formattedDateTime) {
                        
    if (liveToast && count != 0) {

        const recordCount = liveToast.querySelector('#recordCount');
        recordCount.innerText = count;

        const toastTitle = liveToast.querySelector('#toastTitle');
        toastTitle.innerText = 'Pending Request' + ((count == 1) ? '' : 's');

        const time = liveToast.querySelector('#time');
        time.innerText = formattedTimePassed;
        time.setAttribute("title", formattedDateTime);

        const toastBody = liveToast.querySelector('#toastBody');
        toastBody.innerHTML = content;

        var toast = new bootstrap.Toast(liveToast);
        toast.show();
    }
}

function populateNotificationContent(notificationsContainer, entryId, entryContent, count, type, formattedDateTime, formattedTimePassed, notifCount) {
    
    if (notificationsContainer) {
        
        const notifHTML = `
            <a class="dropdown-item d-flex justify-content-between align-items-center notif-link" href="forum.php?entry_id=${entryId}" data-notif-id="notif-${notifCount}" data-notif-count="${count}">
                <div class="d-flex flex-column w-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="notif-content">
                            <span class="fs-lg">New ${type} on your entry:</span><br>"<strong>${entryContent}</strong>"
                            <div class="text-muted">
                                <small title="${formattedDateTime}">${formattedTimePassed}</small>
                            </div>
                        </div>
                        <span class="badge ms-5 bg-success rounded-pill">
                            ${count}
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

function seenNotification() {
    const notifLinks = document.querySelectorAll('.notif-link');

    let notificationSeen = 0;

    notifLinks.forEach(link => {
        const notifId = link.getAttribute('data-notif-id');
        const notifCount = link.getAttribute('data-notif-count');

        // Check if the notification has been marked as seen in sessionStorage
        if (sessionStorage.getItem(`notif-${notifId}`) === 'seen') {
            link.style.backgroundColor = '#d3d3d3';

            const badge = link.querySelector('.badge');
            badge.classList.remove('bg-success');
            badge.classList.add('bg-secondary');

            notificationSeen += +notifCount;
        }

        link.addEventListener("click", function(e) {
            e.preventDefault();

            // Change the background color and badge classes
            link.style.backgroundColor = '#d3d3d3';
            const badge = link.querySelector('.badge');
            badge.classList.remove('bg-success');
            badge.classList.add('bg-secondary');

            // Store the seen state in sessionStorage
            sessionStorage.setItem(`notif-${notifId}`, 'seen');

            window.location.href = this.href;
        });
    });

    return notificationSeen;
}