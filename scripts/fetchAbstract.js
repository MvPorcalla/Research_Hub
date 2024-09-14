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

        // Send a fetch request to the backend with the provided filters
        fetch(`../../backend/searchfetch.php?query=${encodeURIComponent(query)}&month=${encodeURIComponent(month)}&year=${encodeURIComponent(year)}&track=${encodeURIComponent(track)}&record_type=record`)
            .then(response => response.json()) // Convert the response to JSON
            .then(data => {
                populateTable(data); // Populate the table with the fetched data
                getLikes(); // Fetch and update the likes for each record
            })
            .catch(error => {
                // Handle any errors that occur during the fetch
                console.error('Error fetching data:', error);
                // Display an error message in the table body
                tableBody.innerHTML = '<div class="col-12 text-center">Error fetching data. Please try again later.</div>';
            });
    };

    // Function to populate the table with data
    const populateTable = (data) => {
        const tableBody = document.getElementById('abstractTiles');
        let rows = '';

        const isAdmin = window.location.href.includes('admin'); // Check if the user is on an admin page

        // Check if there is no data
        if (data.length === 0) {
            // Display a message based on whether the user is an admin or not
            if (isAdmin) {
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center">No Abstract Records Found.</td></tr>';
            } else {
                tableBody.innerHTML = '<div class="col-12 text-center">No Abstract Records Found.</div>';
            }
            return; // Exit the function if no data is found
        }

        // Loop through each record in the data array
        data.forEach(record => {
            // Convert the month number to a month name
            const month = new Intl.DateTimeFormat('en', { month: 'long' }).format(new Date(2024, record.record_month - 1));

            const query = queryInput.value.trim();

            // If the user is on an admin page, create table rows with edit and delete buttons
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
            } else { // If the user is not on an admin page, create card elements
                rows += `
                    <div class="col-12 mb-2">
                        <div class="card">
                            <div class="card-body card-bg" onclick="if (!event.target.closest('button')) { window.location.href='abstractView.php?abstractId=${record.record_id}'; }" style="cursor: pointer;">
                                <div class="row text-center">
                                    <div class="col-md-2 d-flex align-items-center justify-content-center border-end">
                                        <canvas id="pdf-canvas-${record.record_id}" class="img-fluid border border-dark rounded" alt="PDF " width="85" height="110"></canvas>                                    
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
                                            <a href="../../uploads/records/${record.record_title}.pdf" download="${record.record_title}.pdf">
                                                <i class="fas fa-download text-success"></i>
                                            </a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        });

        tableBody.innerHTML = rows; // Insert the rows into the table body
        
        // Set up confirmation dialog for delete buttons
        setupConfirmationDialog('.delete-button', {
            multiTd: false, // Specify that this is for a single row deletion
            actionText: "You are about to delete", // Confirmation message text
            confirmButtonText: "Delete" // Confirmation button text
        });

        // Render PDF thumbnails for each canvas element
        if (!isAdmin) {
            data.forEach(record => {
                const canvasId = `pdf-canvas-${record.record_id}`;
                const pdfUrl = `../${record.record_filedir}`;
                renderPDFThumbnail(pdfUrl, canvasId);
            });
        }
    };

    // Function to render a PDF thumbnail in a canvas element
    const renderPDFThumbnail = (pdfUrl, canvasId, scale = 0.14, width = 85, height = 110) => {
        const canvas = document.getElementById(canvasId);
        const context = canvas.getContext('2d');

        pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
            pdf.getPage(1).then(page => {
                const viewport = page.getViewport({ scale });
                canvas.width = width;
                canvas.height = height;

                page.render({
                    canvasContext: context,
                    viewport
                });
            });
        });
    };
        

    // Function to handle actions after data fetch
    function handleAfterFetch() {

        var url = window.location.href;
        
        // Check if the URL includes the user index page
        if (url.includes('pages/user/index.php')) {
            getLikes(); // Call the function to get likes data
            
            const commentsModal = document.getElementById('commentsModal');
            
            if (commentsModal) {
                // Event listener for when the modal is shown
                commentsModal.addEventListener('show.bs.modal', async function (event) {
                    // Existing logic for handling modal events
                    const button = event.relatedTarget;
                    const abstractId = button.getAttribute('data-record-id');
                    const abstractTitle = button.getAttribute('data-record-title');

                    const modalLabel = document.getElementById('commentsModalLabel');
                    modalLabel.innerText = abstractTitle; // Set the modal label to the abstract title

                    const abstractIdField = document.getElementById('record_id');
                    abstractIdField.value = abstractId; // Set the abstract ID in the hidden input field

                    // Display comments and refresh likes after loading comments
                    displayComments(abstractId).then(() => { getLikes(); });
                });
                
                // Event listener for when the modal is hidden
                commentsModal.addEventListener('hide.bs.modal', function () {

                    const commentsContainer = document.getElementById('commentsContainer');
                    if (commentsContainer) {
                        commentsContainer.innerHTML = ''; // Clear the comments container when the modal is hidden
                    }
                });
            }      
        }
    }

    // Function to highlight the search query in the text
    const highlightText = (text, query) => {
        // If there's no query, return the original text
        if (!query) return text;

        // Escape special characters in the query to prevent issues with the regex
        const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');

        // Create a case-insensitive regex to match the query in the text
        const regex = new RegExp(`(${escapedQuery})`, 'gi');

        // Replace matched text with the same text wrapped in <strong> tags for highlighting
        return text.replace(regex, '<strong>$1</strong>');
    };

    form.addEventListener('submit', event => {
        event.preventDefault();
        fetchData(); // Fetch data on form submission
    });

    // Event listener handler function for input changes
    const handleChange = () => fetchData(); // Fetch data when filters or query change

    // Event listeners for filter and input changes
    monthFilter.addEventListener('change', handleChange); // Fetch data on month filter change
    yearFilter.addEventListener('change', handleChange); // Fetch data on year filter change
    trackFilter.addEventListener('change', handleChange); // Fetch data on track filter change
    queryInput.addEventListener('input', handleChange); // Fetch data on query input change

    // Fetch data on initial page load
    fetchData();
    handleAfterFetch();
});
 