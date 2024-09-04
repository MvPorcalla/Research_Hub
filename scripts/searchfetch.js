// Wait for the DOM content to be fully loaded before executing the script
document.addEventListener('DOMContentLoaded', function() {
    // Select the input field where the search query is entered
    const queryInput = document.querySelector('#query');
    
    // Initialize variables for table bodies and record type
    let lrnTableBody, studentTableBody, guestTableBody, recordType;

    // Check if the 'users-table' element exists to determine which tables to initialize
    if (document.getElementById(`users-table`)) {
        // Select table bodies for student and guest tables
        studentTableBody = document.querySelector(`#students-table tbody`);
        guestTableBody = document.querySelector(`#guests-table tbody`);
    } else if (document.getElementById(`lrns-table`)) {
        // Select table body for LRN table and set record type to 'lrn'
        lrnTableBody = document.querySelector(`#lrns-table tbody`);
        recordType = 'lrn';
    }

    // Object to map record types to their corresponding table bodies
    const tableBodies = {
        student: studentTableBody,
        guest: guestTableBody,
        lrn: lrnTableBody
    };

    // Function to fetch records from the server based on record type and query
    function fetchRecords(recordType, query = '') {
        console.log('Fetching records with query:', query); // Debugging line
        
        return new Promise((resolve, reject) => {
            // Make a fetch request to the server with the specified record type and query
            fetch(`../../backend/searchfetch.php?record_type=${encodeURIComponent(recordType)}&query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Data received:', data); // Debugging line

                    let rows = '';

                    // If no data is received, display a message indicating no records found
                    if (data.length === 0) {
                        rows = '<tr><td colspan="5" class="text-center">No Abstract Records Found.</td></tr>';
                    } else {
                        // Generate table rows based on the record type
                        switch (recordType) {
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
    
                    // Update the table body with the generated rows
                    tableBodies[recordType].innerHTML = rows;

                    // Set up confirmation dialog options based on record type
                    let options = '';
                    switch (recordType) {
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

    // Function to highlight matching text in the table cells
    function highlightText(text, query) {
        if (!query) return text;
        // Escape special characters in the query to use in regex
        const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        // Create a regex to match the query text, case-insensitively
        const regex = new RegExp('(' + escapedQuery + ')', 'gi');
        // Replace matched text with highlighted version
        return text.replace(regex, '<strong>$1</strong>');
    }

    // Fetch records for students and guests if the 'users-table' element is present
    if (document.getElementById(`users-table`)) {
        fetchRecords('student');
        fetchRecords('guest');
    } else {
        // Fetch records for LRN if the 'lrns-table' element is present
        fetchRecords(recordType);
    }

    // Add event listener to handle input changes in the search query field
    queryInput.addEventListener('input', function() {
        const query = queryInput.value.trim();
        if (document.getElementById(`users-table`)) {
            fetchRecords('student', query);
            fetchRecords('guest', query);
        } else {
            fetchRecords(recordType, query);
        }
    });

    // Add event listener to handle form submission for search
    document.querySelector('#search-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        const query = queryInput.value.trim();
        if (document.getElementById(`users-table`)) {
            fetchRecords('student', query);
            fetchRecords('guest', query);
        } else {
            fetchRecords(recordType, query);
        }
    });
});
