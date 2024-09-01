document.addEventListener('DOMContentLoaded', function() {
    const queryInput = document.querySelector('#query');
    
    let recordTableBody, lrnTableBody, studentTableBody, guestTableBody, recordType;

    if (document.getElementById(`records-table`)) {

        recordTableBody = document.querySelector(`#records-table tbody`);
        recordType = 'record';

    } else if (document.getElementById(`users-table`)) {

        studentTableBody = document.querySelector(`#students-table tbody`);
        guestTableBody = document.querySelector(`#guests-table tbody`);

    } else if (document.getElementById(`lrns-table`)) {

        lrnTableBody = document.querySelector(`#lrns-table tbody`);
        recordType = 'lrn';

    } else if (document.getElementById(`abstractTiles`)) {
        
        recordTableBody = document.getElementById(`abstractTiles`);
        recordType = 'record';
    }

    const tableBodies = {
        record: recordTableBody,
        student: studentTableBody,
        guest: guestTableBody,
        lrn: lrnTableBody
    };

    function fetchRecords(recordType, query = '') {
        console.log('Fetching records with query:', query); // Debugging line
        
        return new Promise((resolve, reject) => {
            fetch(`../../backend/searchfetch.php?record_type=${encodeURIComponent(recordType)}&query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Data received:', data); // Debugging line

                    let rows = '';
    
                    if (data.length === 0) {
                        rows = '<tr><td colspan="6">No records found.</td></tr>';
                    } else {
                        switch (recordType) {
                            case 'record':
                                data.forEach(record => {
                                    var url = window.location.href;
                                    if (url.includes('admin')) {
                                        const month = Intl.DateTimeFormat('en', { month: 'long' }).format(new Date(2024, record.record_month - 1));
                                        rows += `
                                            <tr onclick="if (!event.target.closest('a')) { window.location.href='abstractView.php?abstractId=${record.record_id}'; }" style="cursor: pointer;">
                                                <td>${highlightText(record.record_title, query)}</td>
                                                <td>${month + ' ' + record.record_year}</td>
                                                <td>${highlightText(record.record_authors, query)}</td>
                                                <td>${record.record_trackstrand}</td>
                                                <td>
                                                    <a href="abstract.php?abstractId=${record.record_id}" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                                    <a href="../../backend/delete.php?abstractId=${record.record_id}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                                </td>
                                            </tr>
                                        `;
                                    } else {
                                        rows += `
                                            <div class="col-12 mb-2">
                                                <div class="card">
                                                    <div class="card-body" onclick="if (!event.target.closest('button')) { window.location.href='abstractView.php?abstractId=${record.record_id}'; }" style="cursor: pointer;">
                                                        <div class="row text-center">
                                                            <div class="col-md-2 d-flex align-items-center justify-content-center border-end">
                                                                <img src="https://via.placeholder.com/75x100" class="img-fluid rounded-1" alt="${record.record_title}">
                                                            </div>
                                                            <div class="col-md-8 d-flex flex-column align-items-start justify-content-center border-end">
                                                                <p class="mb-1">${highlightText(record.record_title, query)}</p>
                                                                <small>${highlightText(record.record_authors, query)}</small>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                                                                <button class="btn btn-outline-primary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#commentsModal" data-record-id="${record.record_id}" data-record-title="${record.record_title}">
                                                                    <i class="fas fa-comment"></i>
                                                                </button>
                                                                <button class="btn btn-outline-danger btn-sm mx-1 like-button" data-record-id="${record.record_id}">
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
                                    }
                                });
                                break;
                            case 'student':
                                data.forEach(record => {
                                    rows += `
                                        <tr>
                                            <td>${highlightText(record.user_lastname, query)}</td>
                                            <td>${highlightText(record.user_firstname, query)}</td>
                                            <td>${highlightText(record.user_mi, query)}</td>
                                            <td>${highlightText(record.lrn_lrnid, query)}</td>
                                            <td>${highlightText(record.user_trackstrand, query)}</td>
                                            <td>
                                                <a href="../../backend/delete.php?userId=${record.user_id}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                            </td>
                                        </tr>
                                    `;
                                });
                                break;
                            case 'guest':
                                data.forEach(record => {
                                    rows += `
                                        <tr>
                                            <td>${highlightText(record.user_lastname, query)}</td>
                                            <td>${highlightText(record.user_firstname, query)}</td>
                                            <td>${highlightText(record.user_mi, query)}</td>
                                            <td>${highlightText(record.user_school, query)}</td>
                                            <td>
                                                <a href="../../backend/delete.php?userId=${record.user_id}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                            </td>
                                        </tr>
                                    `;
                                });
                                break;
                            case 'lrn':
                                data.forEach(record => {
                                    rows += `
                                        <tr>
                                            <td>${highlightText(record.lrn_student, query)}</td>
                                            <td>${highlightText(record.lrn_lrnid, query)}</td>
                                            <td>
                                                <a href="lrn.php?lrnId=${record.lrn_id}" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                                <a href="../../backend/delete.php?lrnId=${record.lrn_id}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                            </td>
                                        </tr>
                                    `;
                                });
                                break;
                        }
                    }
    
                    tableBodies[recordType].innerHTML = rows;

                    let options = '';
                    switch (recordType) {
                        case 'record':
                            options = {
                                multiTd: false,
                                actionText: "You are about to delete",
                                confirmButtonText: "Delete"
                            };
                            break;
                        case 'lrn':
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
    
                    // Resolve the promise after data has been processed
                    resolve();
                })
                .catch(error => {
                    console.error('Error fetching records:', error);
                    reject(error); // Reject the promise if there's an error
                });
        });
    }

    function handleAfterFetch() {
        var url = window.location.href;
    
        if (url.includes('pages/user/index.php')) {
            const updateButtonStatuses = () => {
                let userIdElement = document.getElementById('abstractTiles');
                const userId = userIdElement ? userIdElement.getAttribute('data-user-id') : null;
                const buttons = document.querySelectorAll('.like-button');
                
                const requests = Array.from(buttons).map(button => {
                    const abstractId = button.getAttribute('data-record-id');
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
    
            const commentsModal = document.getElementById('commentsModal');
            
            if (commentsModal) {
                // Event listener for when the modal is shown
                commentsModal.addEventListener('show.bs.modal', async function (event) {
                    // Your existing logic for handling modal events
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
    }    

    function highlightText(text, query) {
        if (!query) return text;
        const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp('(' + escapedQuery + ')', 'gi');
        return text.replace(regex, '<strong>$1</strong>');
    }

    if (document.getElementById(`users-table`)) {
        fetchRecords('student');
        fetchRecords('guest');
    } else {
        fetchRecords(recordType).then(handleAfterFetch).catch(error => {
            console.error('Error during fetchRecords:', error);
        });
    }

    queryInput.addEventListener('input', function() {
        const query = queryInput.value.trim();
        if (document.getElementById(`users-table`)) {
            fetchRecords('student', query);
            fetchRecords('guest', query);
        } else {
            fetchRecords(recordType, query).then(handleAfterFetch).catch(error => {
                console.error('Error during fetchRecords:', error);
            });
        }
    });

    document.querySelector('#search-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const query = queryInput.value.trim();
        if (document.getElementById(`users-table`)) {
            fetchRecords('student', query);
            fetchRecords('guest', query);
        } else {
            fetchRecords(recordType, query).then(handleAfterFetch).catch(error => {
                console.error('Error during fetchRecords:', error);
            });
        }
    });

});
