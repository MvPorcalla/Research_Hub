// fetchRecords.js - Fetch records for admin index.php

document.addEventListener('DOMContentLoaded', () => {
    const classes = ['abstracts', 'students', 'guests', 'LRNs'];

    const escapeHTML = str => str.replace(/&/g, "&amp;")
                                 .replace(/</g, "&lt;")
                                 .replace(/>/g, "&gt;")
                                 .replace(/"/g, "&quot;")
                                 .replace(/'/g, "&#039;");
    
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
                                <tr onclick="window.location.href='abstractView.php?abstractId=${escapeHTML(dataRow.id)}';" style="cursor: pointer;">
                                    <td>${escapeHTML(dataRow.title)}</td>
                                    <td>${escapeHTML(dataRow.yearmonth)}</td>
                                    <td>${escapeHTML(dataRow.authors)}</td>
                                    <td>${escapeHTML(dataRow.trackstrand)}</td>
                                    <td>
                                        <a href="abstract.php?abstractId=${encodeURIComponent(dataRow.id)}" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                        <a href="../../backend/delete.php?abstractId=${encodeURIComponent(dataRow.id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                    </td>
                                </tr>`;
                            break;
                        case 'students':
                            rowHTML = `
                                <tr>
                                    <td>${escapeHTML(dataRow.lname)}</td>
                                    <td>${escapeHTML(dataRow.fname)}</td>
                                    <td>${escapeHTML(dataRow.mi)}</td>
                                    <td>${escapeHTML(dataRow.lrn)}</td>
                                    <td>${escapeHTML(dataRow.track)}</td>
                                    <td>
                                        <a href="../../backend/delete.php?userId=${encodeURIComponent(dataRow.id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                    </td>
                                </tr>`;
                            break;
                        case 'guests':
                            rowHTML = `
                                <tr>
                                    <td>${escapeHTML(dataRow.lname)}</td>
                                    <td>${escapeHTML(dataRow.fname)}</td>
                                    <td>${escapeHTML(dataRow.mi)}</td>
                                    <td>${escapeHTML(dataRow.school)}</td>
                                    <td>
                                        <a href="../../backend/delete.php?userId=${encodeURIComponent(dataRow.id)}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                    </td>
                                </tr>`;
                            break;
                        case 'LRNs':
                            rowHTML = `
                                <tr>
                                    <td>${escapeHTML(dataRow.fullname)}</td>
                                    <td>${escapeHTML(dataRow.lrn)}</td>
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
                                    <h5 class="card-title text-center flex-grow-1">${escapeHTML(dataRow.fname)} ${escapeHTML(dataRow.mi)}. ${escapeHTML(dataRow.lname)}</h5>
                                    <p class="card-text text-center">${escapeHTML(dataRow.email)}</p>
                                    <p class="card-text text-center">${escapeHTML(dataRow.school)}</p>
                                    
                                    <div class="border border-secondary rounded p-2 mb-3">
                                        <p class="card-text text-center fw-bold mb-1">Reason</p>
                                        <p class="card-text text-center">${escapeHTML(dataRow.reason)}</p>
                                    </div>
                                    <div class="d-flex justify-content-center mt-auto">
                                        <a href="../../backend/pending_actions.php?accept=${escapeHTML(dataRow.id)}" class="btn btn-primary btn-sm me-2">Accept</a>
                                        <a href="../../backend/pending_actions.php?decline=${escapeHTML(dataRow.id)}" class="btn btn-danger btn-sm">Decline</a>
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
                                <div class="card-body" onclick="if (!event.target.closest('button')) { window.location.href='abstractView.php?abstractId=${escapeHTML(dataRow.id)}'; }" style="cursor: pointer;">
                                    <div class="row text-center">
                                        <div class="col-md-2 d-flex align-items-center justify-content-center border-end">
                                            <img src="https://via.placeholder.com/75x100" class="img-fluid rounded-1" alt="${escapeHTML(dataRow.title)}">
                                        </div>
                                        <div class="col-md-8 d-flex align-items-center justify-content-start border-end">${escapeHTML(dataRow.title)}</div>
                                        <div class="col-md-2 d-flex align-items-center justify-content-center">
                                            <button class="btn btn-outline-primary btn-sm mx-1">
                                                <i class="fas fa-comment"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm mx-1 like-button" data-record-id="${escapeHTML(dataRow.id)}">
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
                                <div class="card-body" onclick="if (!event.target.closest('button')) { window.location.href='abstractView.php?abstractId=${escapeHTML(dataRow.record_id)}'; }" style="cursor: pointer;">
                                    <div class="row text-center">
                                        <div class="col-md-11 d-flex align-items-center justify-content-start border-end">${escapeHTML(dataRow.title)}</div>
                                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                                            <button class="btn btn-outline-danger btn-sm mx-1 like-button" data-record-id="${escapeHTML(dataRow.record_id)}">
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

                var url = window.location.href;
                const disabled = url.includes('admin') ? ' disabled' : ''

                if (data.length == 0) {

                    let tileHTML = `<small>No comments yet.</small>`;
                    commentsContainer.innerHTML += tileHTML;
                    
                } else {

                    data.forEach(dataRow => {

                        const timestamp = dataRow.commentTimestamp;

                        const timePassed = timeAgo(timestamp);
                        const formattedDateTime = formatDateTime(timestamp);

                        let tileHTML = `
                            <div class="card comment-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <div class="d-flex flex-row align-items-center">
                                            <img src="../${escapeHTML(dataRow.userIdImage)}" alt="avatar" width="25" height="25" />
                                            <p class="small mb-0 ms-2">${escapeHTML(dataRow.userName)}</p>
                                        </div>
                                        <div class="likes-section d-flex flex-row align-items-center">
                                            <button class="btn like-button px-0" data-comment-id="${escapeHTML(dataRow.commentId)}"${disabled}>
                                                <i class="far fa-thumbs-up mx-2 fa-xs text-body" style="margin-top: -0.16rem;"></i>
                                            </button>
                                            <p class="small text-muted mb-0 me-2">${escapeHTML(dataRow.commentLikes)}</p>
                                        </div>
                                    </div>
                                    <p>${escapeHTML(dataRow.commentContent)}</p>
                                    <p title="${formattedDateTime}" style="cursor: pointer;"><small>${timePassed}</small></p>
                                </div>
                            </div>
                        `;
                        commentsContainer.innerHTML += tileHTML;
                    });
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

                    let tileHTML = `
                                <div class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                                    <div class="row mt-3 mx-3">
                                        <div class="col-md-12 mb-sm-0">
                                            <div class="entry-container">

                                                <div class=" mb-3">
                                                    
                                                    <div class="d-flex align-items-center">
                                                        <img id="idImage" src="../../assets/icons/Vector.png" alt="User Image" class="img-fluid rounded-circle me-3" style="width: 45px; height: 45px;">
                                                        <div>
                                                            <h4 class="mb-0">@${escapeHTML(dataRow.userName)}</h4>
                                                            <p title="${formattedDateTime}" class="ms-1 mb-0">${timePassed}</p>
                                                        </div>
                                                    </div>

                                                </div>

                                                <!-- Entry content displayed -->
                                                <div class="border p-3 rounded">
                                                    <h5>${escapeHTML(dataRow.entryContent)}</h5>
                                                </div>

                                                <!-- Stats and Buttons Row -->
                                                <div class="row mt-3">
                                                    <div class="col-12 text-end">
                                                        <!-- Likes with Like Button -->
                                                        <div class="d-inline-block text-center me-3">
                                                            <button class="btn btn-link p-0 ms-1 text-decoration-none" onclick="likeEntry(${escapeHTML(dataRow.entryId)})">
                                                                <i class="fa-solid fa-thumbs-up"></i> Like
                                                            </button>
                                                            <span class="ms-2">${escapeHTML(dataRow.entryLikes)}</span>
                                                        </div>
                                                        <!-- Replies with Comment Button -->
                                                        <div class="d-inline-block text-center me-3">
                                                            <button class="btn btn-link p-0 ms-1 text-decoration-none" onclick="toggleComments(${escapeHTML(dataRow.entryId)})">
                                                                <i class="fa-solid fa-comment-dots"></i> Reply
                                                            </button>
                                                            <span id="entryComments-${escapeHTML(dataRow.entryId)}" class="ms-2"></span>
                                                        </div>
                                                      
                                                    </div>
                                                </div>

                                                <hr>

                                                <!-- Comments Section -->
                                                <div id="comment-section-${escapeHTML(dataRow.entryId)}" data-entry-id="${escapeHTML(dataRow.entryId)}" class="comments-section ms-3 mt-3">
                                                    <div id="comments-${escapeHTML(dataRow.entryId)}" class="card-body">

                                                    </div>
                                                </div>
                                                <!-- /End of Comments Section -->

                                            </div>
                                        </div>
                                    </div>

                                </div>
                    `;
                    entriesContainer.innerHTML += tileHTML;

                    if (document.getElementById(`comment-section-${escapeHTML(dataRow.entryId)}`)) {

                        const commentSection = document.getElementById(`comment-section-${escapeHTML(dataRow.entryId)}`);
                        const comments = document.getElementById(`comments-${escapeHTML(dataRow.entryId)}`);
            
                        const response = await fetch(`../../backend/fetchRecords.php?fetch=comments&comment_on=entry_id&record_id=${escapeHTML(dataRow.entryId)}`);
                        if (!response.ok) throw new Error('Network response was not ok');
            
                        const data = await response.json();

                        const entryComments = document.getElementById(`entryComments-${escapeHTML(dataRow.entryId)}`);
                        entryComments.innerHTML = data.length;
            
                        data.forEach(dataRow => {
                            let tileHTML = `
                                <div class="comment">
                                    <p><strong>${escapeHTML(dataRow.userName)}:</strong> ${escapeHTML(dataRow.commentContent)}</p>
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
                                    <input type="hidden" name="entry_id" value="${escapeHTML(dataRow.entryId)}">
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

        if (url.includes('pages/user/index.php') || url.includes('pages/user/favorites.php') || url.includes('pages/user/abstractView.php')) {
            const updateButtonStatuses = () => {

                let userIdElement = document.getElementById('abstractTiles') || document.getElementById('favoriteTiles') || document.getElementById('commentsContainer');
                const userId = userIdElement ? userIdElement.getAttribute('data-user-id') : null;
                const buttons = document.querySelectorAll('.like-button');
                
                const requests = Array.from(buttons).map(button => {
                    const abstractId = button.getAttribute('data-record-id');
                    const commentId = button.getAttribute('data-comment-id');

                    if (abstractId) {
                    
                    return fetch(`../../backend/get_like_status.php?record_type=abstract&recordId=${abstractId}&userId=${userId}`)
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
        }
    });
});
