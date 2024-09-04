// fetchRecords.js - Fetch records for admin index.php

document.addEventListener('DOMContentLoaded', () => {
    
    const fetchRecords = async () => {
        try {

            if (document.getElementById('pendingTiles')) {

                const pendingTiles = document.getElementById('pendingTiles');

                const response = await fetch(`../../backend/fetchRecords.php?fetch=pending`);
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                pendingTiles.innerHTML = '';

                data.forEach(dataRow => {
                    let tileHTML = `
                        <div class="col-md-6 mb-4">
                            <div class="card border-dark rounded-4 h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-center flex-grow-1">${dataRow.fname} ${dataRow.mi}. ${dataRow.lname}</h5>
                                    <p class="card-text text-center">${dataRow.email}</p>
                                    <p class="card-text text-center">${dataRow.school}</p>
                                    
                                    <div class="border border-secondary rounded p-2 mb-3">
                                        <p class="card-text text-center fw-bold mb-1">Reason</p>
                                        <p class="card-text text-center">${dataRow.reason}</p>
                                    </div>
                                    <div class="d-flex justify-content-center mt-auto">
                                        <form id="pendingForm_${dataRow.id}" method="POST">
                                            <input type="text" name="website_name" id="website_name" hidden value="Research Hub">
                                            <input type="text" name="website_link" id="website_link" hidden value="http://localhost/research_Hub/">
                                            <input type="text" name="user_name" id="user_name" hidden>
                                            <input type="text" name="user_email" id="user_email" hidden>
                                            <input type="text" name="temp_username" id="temp_username" hidden>
                                            <input type="text" name="temp_password" id="temp_password" hidden>
                                            <a id="accept_${dataRow.id}" class="btn btn-primary btn-sm me-2 accept pending">Accept</a>
                                            <a id="decline_${dataRow.id}" class="btn btn-danger btn-sm decline pending">Decline</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    pendingTiles.innerHTML += tileHTML;
                });
            }

            if (document.getElementById('abstractTiles')) {

                const abstractTiles = document.getElementById('abstractTiles');

                const response = await fetch(`../../backend/fetchRecords.php?fetch=abstracts`);
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                abstractTiles.innerHTML = '';

                data.forEach(dataRow => {
                    let tileHTML = `
                        <div class="col-12 mb-2">
                            <div class="card">
                                <div class="card-body" onclick="if (!event.target.closest('button')) { window.location.href='abstractView.php?abstractId=${dataRow.id}'; }" style="cursor: pointer;">
                                    <div class="row text-center">
                                        <div class="col-md-2 d-flex align-items-center justify-content-center border-end">
                                            <img src="https://via.placeholder.com/75x100" class="img-fluid rounded-1" alt="${dataRow.title}">
                                        </div>
                                        <div class="col-md-8 d-flex align-items-center justify-content-start border-end">${dataRow.title}</div>
                                        <div class="col-md-2 d-flex align-items-center justify-content-center">
                                            <button class="btn btn-outline-primary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#commentsModal" data-record-id="${dataRow.id}" data-record-title="${dataRow.title}">
                                                <i class="fas fa-comment"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm mx-1 like-button" data-record-id="${dataRow.id}">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                            <button class="btn btn-outline-success btn-sm mx-1">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    abstractTiles.innerHTML += tileHTML;
                });
            }

            if (document.getElementById('favoriteTiles')) {

                const favoriteTiles = document.getElementById('favoriteTiles');

                const response = await fetch(`../../backend/fetchRecords.php?fetch=favorites`);
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();

                data.forEach(dataRow => {
                    let tileHTML = `
                        <div class="col-12 mb-2">
                            <div class="card border-dark rounded-4">
                                <div class="card-body" onclick="if (!event.target.closest('button')) { window.location.href='abstractView.php?abstractId=${dataRow.record_id}'; }" style="cursor: pointer;">
                                    <div class="row text-center">
                                        <div class="col-md-11 d-flex align-items-center justify-content-start border-end">${dataRow.title}</div>
                                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                                            <button class="btn btn-outline-danger btn-sm mx-1 like-button" data-record-id="${dataRow.record_id}">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    favoriteTiles.innerHTML += tileHTML;
                });
            }

            if (document.getElementById('commentsContainer')) {

                const commentsContainer = document.getElementById('commentsContainer');
                const abstractId = commentsContainer.getAttribute('data-abstract-id');

                const response = await fetch(`../../backend/fetchRecords.php?fetch=comments&comment_on=record_id&record_id=${abstractId}`);
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();

                if (data.length == 0) {

                    let tileHTML = `<small id="no_comment">No comments yet.</small>`;
                    commentsContainer.innerHTML += tileHTML;
                    
                } else {

                    displayCommentTiles(data, commentsContainer, abstractId);
                }
            }
            
            if (document.getElementById('entriesContainer')) {

                const entriesContainer = document.getElementById('entriesContainer');

                const response = await fetch(`../../backend/fetchRecords.php?fetch=entries`);
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();

                for (const dataRow of data) {

                    const timestamp = dataRow.entryTimestamp;

                    const timePassed = timeAgo(timestamp);
                    const formattedDateTime = formatDateTime(timestamp);

                    const mi = (dataRow.mi == '') ? '' : `${dataRow.mi}. `;
                    const fullName = `${dataRow.firstName} ${mi}${dataRow.lastName}`;

                    let tileHTML = `
                                <div class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                                    <div class="row mt-3 mx-3">
                                        <div class="col-md-12 mb-sm-0">
                                            <div class="entry-container">

                                                <div class=" mb-3">
                                                    
                                                    <div class="d-flex align-items-center">
                                                        <img src="../${dataRow.imgDir}" alt="${dataRow.userName}" title="${fullName}" class="img-fluid rounded-circle me-3" style="width: 50px; height: 50px;">
                                                        <div>
                                                            <h4 title="${fullName}" class="mb-0">@${dataRow.userName}</h4>
                                                            <p title="${formattedDateTime}" class="ms-1 mb-0">${timePassed}</p>
                                                        </div>
                                                    </div>

                                                </div>

                                                <!-- Entry content displayed -->
                                                <div class="border p-3 rounded">
                                                    <h5>${dataRow.entryContent}</h5>
                                                </div>

                                                <!-- Stats and Buttons Row -->
                                                <div class="row mt-3">
                                                    <div class="col-12 text-end">
                                                        <!-- Likes with Like Button -->
                                                        <div class="d-inline-block text-center me-3 likes-section">
                                                            <button class="btn btn-link p-0 ms-1 text-decoration-none like-button" data-entry-id="${dataRow.entryId}">
                                                                <i class="fa-solid fa-thumbs-up"></i> Like
                                                            </button>
                                                            <span class="ms-2">${dataRow.entryLikes}</span>
                                                        </div>
                                                        <!-- Replies with Comment Button -->
                                                        <div class="d-inline-block text-center me-3">
                                                            <button class="btn btn-link p-0 ms-1 text-decoration-none" onclick="toggleComments(${dataRow.entryId})">
                                                                <i class="fa-solid fa-comment-dots"></i> Reply
                                                            </button>
                                                            <span id="entryComments-${dataRow.entryId}" class="ms-2"></span>
                                                        </div>
                                                      
                                                    </div>
                                                </div>

                                                <hr>

                                                <!-- Comments Section -->
                                                <div id="comment-section-${dataRow.entryId}" data-entry-id="${dataRow.entryId}" class="comments-section ms-3 mt-3">
                                                    <div id="comments-${dataRow.entryId}" class="card-body">

                                                    </div>
                                                </div>
                                                <!-- /End of Comments Section -->

                                            </div>
                                        </div>
                                    </div>

                                </div>
                    `;
                    entriesContainer.innerHTML += tileHTML;

                    if (document.getElementById(`comment-section-${dataRow.entryId}`)) {

                        const commentSection = document.getElementById(`comment-section-${dataRow.entryId}`);
                        const comments = document.getElementById(`comments-${dataRow.entryId}`);
            
                        const response = await fetch(`../../backend/fetchRecords.php?fetch=comments&comment_on=entry_id&record_id=${dataRow.entryId}`);
                        if (!response.ok) throw new Error('Network response was not ok');
            
                        const data = await response.json();

                        const entryComments = document.getElementById(`entryComments-${dataRow.entryId}`);
                        entryComments.innerHTML = data.length;

                        const commentTimestamp = dataRow.entryTimestamp;
    
                        const commentTimePassed = timeAgo(commentTimestamp); // 43 minutes ago
                        const commentFormattedDateTime = formatDateTime(commentTimestamp); // August 28, 2024 at 11:41

                        data.forEach(dataRow => {
                            let tileHTML = `
                            <div class="row">
                                <div class="comment d-flex col-md-10">
                                    <img src="../${dataRow.userIdImage}" alt="${dataRow.userName}" class="img-fluid rounded-circle me-3" style="width: 30px; height: 30px;">
                                    <p><strong>${dataRow.userName}:</strong> ${dataRow.commentContent}</p>
                                    <hr>
                                </div>
                                <div class="col-md-2">
                                    <p title="${commentFormattedDateTime}" style="cursor: pointer;">${commentTimePassed}</p>
                                </div>
                            </div>
                            `;
                            comments.innerHTML += tileHTML;
                        });
            
                        const addCommentForm = `
                            <!-- Comment Form for Main Entry -->
                            <div class="card-body mt-1">
                                <form method="post" action="../../backend/comment.php">
                                    <div class="form-row align-items-center">
                                        <div class="col">
                                            <div class="input-group">
                                                <textarea class="form-control" name="comment_content" rows="1" placeholder="Add a comment..."></textarea>
                                                <button type="submit" class="btn btn-primary ms-2" title="Post Comment">
                                                    <i class="fa-solid fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="entry_id" value="${dataRow.entryId}">
                                </form>
                            </div>
                        `;
                        commentSection.innerHTML += addCommentForm;
                    }
                };
            }
        } catch (error) {
            console.error('Error fetching records:', error);
        }
    };

    fetchRecords().then(() => {
        var url = window.location.href;

        if (url.includes('pages/user/favorites.php') 
            || url.includes('pages/user/abstractView.php') 
            || url.includes('pages/user/forum.php'))
            getLikes();

        if (url.includes('pages/admin/pendingRequest.php')) {
            const sendEmail = (e, linkId, pendingFormId) => {
                e.preventDefault();
            
                const actionButton = document.getElementById(linkId);
            
                // Change text to loading spinner icon
                actionButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                // serviceID - templateID - #form - publicKey
                emailjs.sendForm('service_7cwt5yl', 'template_tnti15c', `#${pendingFormId}`, 'Cd2Zq12n93BO-LWlY')
                .then(() => {
                    // Set a flag in sessionStorage
                    sessionStorage.setItem('showAcceptedAlert', 'true');
                    
                    location.reload();
                }, () => {
                    Swal.fire({
                        title: "Service Error",
                        text: "User accepted with no username and password set via email.",
                        icon: "error"
                    });
                });
            }
            
            // Select all anchor elements with the class 'accept'
            const links = document.querySelectorAll('.pending');
            
            // Iterate through the NodeList and add event listeners or perform other actions
            links.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the default link action
                    
                    // get form
                    const pendingForm = this.closest('form');
                    const pendingFormId = pendingForm.id;
                    // pendingForm.submit();

                    const linkId = this.id;
                    const action_id = linkId.split('_');
                    const action = action_id[0];
                    const userId = action_id[1];
            
                    fetch(`../../backend/pending_actions.php`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ action, userId})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (action == 'accept') {

                            console.log('got data');
                            const name = pendingForm.querySelector('#user_name');
                            name.value = data.firstName;
                            console.log(`First Name: ${data.firstName}`);

                            const email = pendingForm.querySelector('#user_email');
                            email.value = data.userEmail;
                            console.log(`Email: ${data.userEmail}`);
                
                            const userName = pendingForm.querySelector('#temp_username');
                            userName.value = data.userName;
                            console.log(`Username: ${data.userName}`);
                
                            const password = pendingForm.querySelector('#temp_password');
                            password.value = data.password;
                            console.log(`Password: ${data.password}`);
                
                            sendEmail(event, linkId, pendingFormId);
                        } else {
                            // Set a flag in sessionStorage
                            sessionStorage.setItem('showDeclinedAlert', 'true');

                            location.reload();
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
                });
            });
            
        }
    });
});
