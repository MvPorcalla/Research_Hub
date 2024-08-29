// fetchRecords.js - Fetch records for admin index.php

document.addEventListener('DOMContentLoaded', () => {
    const classes = ['abstracts', 'students', 'guests', 'LRNs'];
    
    const fetchRecords = async () => {
        try {
            for (let table of document.querySelectorAll('table')) {
                let foundClass = classes.find(cls => table.classList.contains(cls));
                if (!foundClass) continue;

                const response = await fetch(`../../backend/fetchRecords.php?fetch=${foundClass}`);
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                const tableBody = table.querySelector('tbody');
                tableBody.innerHTML = '';

                data.forEach(dataRow => {
                    let rowHTML = '';
                    switch (foundClass) {
                        case 'abstracts':
                            rowHTML = `
                                <tr onclick="window.location.href='abstractView.php?abstractId=${dataRow.id}';" style="cursor: pointer;">
                                    <td>${dataRow.title}</td>
                                    <td>${dataRow.yearmonth}</td>
                                    <td>${dataRow.authors}</td>
                                    <td>${dataRow.trackstrand}</td>
                                    <td>
                                        <a href="abstract.php?abstractId=${encodeURIComponent(dataRow.id)}" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                        <a href="../../backend/delete.php?abstractId=${encodeURIComponent(dataRow.id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                    </td>
                                </tr>`;
                            break;
                        case 'students':
                            rowHTML = `
                                <tr>
                                    <td>${dataRow.lname}</td>
                                    <td>${dataRow.fname}</td>
                                    <td>${dataRow.mi}</td>
                                    <td>${dataRow.lrn}</td>
                                    <td>${dataRow.track}</td>
                                    <td>
                                        <a href="../../backend/delete.php?userId=${encodeURIComponent(dataRow.id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                    </td>
                                </tr>`;
                            break;
                        case 'guests':
                            rowHTML = `
                                <tr>
                                    <td>${dataRow.lname}</td>
                                    <td>${dataRow.fname}</td>
                                    <td>${dataRow.mi}</td>
                                    <td>${dataRow.school}</td>
                                    <td>
                                        <a href="../../backend/delete.php?userId=${encodeURIComponent(dataRow.id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                    </td>
                                </tr>`;
                            break;
                        case 'LRNs':
                            rowHTML = `
                                <tr>
                                    <td>${dataRow.fullname}</td>
                                    <td>${dataRow.lrn}</td>
                                    <td>
                                        <a href="lrn.php?lrnId=${encodeURIComponent(dataRow.id)}" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                        <a href="../../backend/delete.php?lrnId=${encodeURIComponent(dataRow.id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                    </td>
                                </tr>`;
                            break;
                    }
                    tableBody.innerHTML += rowHTML;
                });

                let options = '';
                switch (foundClass) {
                    case 'abstracts':
                        options = {
                            multiTd: false,
                            actionText: "You are about to delete",
                            confirmButtonText: "Delete"
                        };
                        break;
                    case 'LRNs':
                        options = {
                            multiTd: false,
                            actionText: "You are about to delete the LRN of:",
                            confirmButtonText: "Delete"
                        };
                        break;
                    default:
                        options = {
                            multiTd: true,
                            tdCount: 3, // Number of <td> elements to extract text from
                            actionText: "You are about to deactivate the account of",
                            confirmButtonText: "Deactivate"
                        };
                        break;

                }
                setupConfirmationDialog('.delete-button', options);
            }

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
                                        <a href="../../backend/pending_actions.php?accept=${dataRow.id}" class="btn btn-primary btn-sm me-2">Accept</a>
                                        <a href="../../backend/pending_actions.php?decline=${dataRow.id}" class="btn btn-danger btn-sm">Decline</a>
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

        if (url.includes('pages/user/index.php') || url.includes('pages/user/favorites.php') || url.includes('pages/user/abstractView.php') || url.includes('pages/user/forum.php')) {
            const updateButtonStatuses = () => {

                let userIdElement = document.getElementById('abstractTiles') || document.getElementById('favoriteTiles') || document.getElementById('commentsContainer') || document.getElementById('entriesContainer');
                const userId = userIdElement ? userIdElement.getAttribute('data-user-id') : null;
                const buttons = document.querySelectorAll('.like-button');
                
                const requests = Array.from(buttons).map(button => {
                    const abstractId = button.getAttribute('data-record-id');
                    const entryId = button.getAttribute('data-entry-id');
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

                    } else if (entryId) {
                    
                        return fetch(`../../backend/get_like_status.php?record_type=entry&recordId=${entryId}&userId=${userId}`)
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

                    } else if (commentId) {
                    
                        return fetch(`../../backend/get_like_status.php?record_type=comment&recordId=${commentId}&userId=${userId}`)
                            .then(response => response.json())
                            .then(data => {

                                const icon = button.querySelector('svg');
    
                                if (data.like_status == 'A') {
                                    console.log('yep here');
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
                    // You can add any other logic here
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
    });
});
