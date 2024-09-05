var url = window.location.href;

if (url.includes('index.php')) {
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
                    getLikes();
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
            
            setupConfirmationDialog('.delete-button', {
                multiTd: false,
                actionText: "You are about to delete",
                confirmButtonText: "Delete"
            });
        };
    
        function handleAfterFetch() {
    
            var url = window.location.href;
        
            if (url.includes('pages/user/index.php')) {
                getLikes();
        
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
        
                        displayComments(abstractId).then(() => { getLikes(); });
                    });
                    
                    // Event listener for when the modal is hidden
                    commentsModal.addEventListener('hide.bs.modal', function () {
                        console.log('modal hidden');
                        const commentsContainer = document.getElementById('commentsContainer');
                        if (commentsContainer) {
                            commentsContainer.innerHTML = '';
                        }
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
        handleAfterFetch();
    });
 }