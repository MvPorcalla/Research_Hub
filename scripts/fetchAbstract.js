document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('search-form');
    const queryInput = document.getElementById('query');
    const monthFilter = document.getElementById('monthFilter');
    const yearFilter = document.getElementById('yearFilter');
    const trackFilter = document.getElementById('trackFilter');
    const tableBody = document.getElementById('abstractTiles');

    // Function to fetch and display data
    const fetchData = () => {
        const query = queryInput.value.trim();
        const month = monthFilter.value;
        const year = yearFilter.value;
        const track = trackFilter.value;

        fetch(`../../backend/searchfetch.php?query=${encodeURIComponent(query)}&month=${encodeURIComponent(month)}&year=${encodeURIComponent(year)}&track=${encodeURIComponent(track)}&record_type=record`)
            .then(response => response.json())
            .then(data => {
                populateTable(data);
                handleAfterFetch();
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                tableBody.innerHTML = '<div class="col-12 text-center">Error fetching data. Please try again later.</div>';
            });
    };

    // Function to populate the table
    const populateTable = (data) => {
        const tableBody = document.getElementById('abstractTiles');
        let rows = '';

        const isAdmin = window.location.href.includes('admin');
        if (data.length === 0) {
            if (isAdmin) {
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center">No Abstract Records Found.</td></tr>';
            } else {
                tableBody.innerHTML = '<div class="col-12 text-center">No Abstract Records Found.</div>';
            }
            return;
        }

        data.forEach(record => {
            const month = new Intl.DateTimeFormat('en', { month: 'long' }).format(new Date(2024, record.record_month - 1));
            const query = queryInput.value.trim();
            
            if (window.location.href.includes('admin')) {
                rows += `
                    <tr onclick="if (!event.target.closest('a')) { window.location.href='abstractView.php?abstractId=${record.record_id}'; }" style="cursor: pointer;">
                        <td>${highlightText(record.record_title, query)}</td>
                        <td>${month} ${record.record_year}</td>
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
                                        <small>${record.record_trackstrand}</small>
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

        tableBody.innerHTML = rows;
        
    };

    function handleAfterFetch() {
        console.log("handleAfterFetch function called");

        var url = window.location.href;
        console.log("Current URL: ", url);

    
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

    // Function to highlight search query in table
    const highlightText = (text, query) => {
        if (!query) return text;
        const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp(`(${escapedQuery})`, 'gi');
        return text.replace(regex, '<strong>$1</strong>');
    };

    // Event listeners
    const handleChange = () => fetchData();
    form.addEventListener('submit', event => {
        event.preventDefault();
        fetchData();
    });

    monthFilter.addEventListener('change', handleChange);
    yearFilter.addEventListener('change', handleChange);
    trackFilter.addEventListener('change', handleChange);
    queryInput.addEventListener('input', handleChange);

    // Fetch data on page load
    fetchData();
});