document.addEventListener('DOMContentLoaded', function() {

    const queryInput = document.querySelector('#query');
    
    let lrnTableBody, employeeTableBody, studentTableBody, teacherTableBody, guestTableBody, recordType;

    // Check if the 'users-table' element exists to determine which tables to initialize
    if (document.getElementById(`users-table`)) {

        studentTableBody = document.querySelector(`#students-table tbody`);
        teacherTableBody = document.querySelector(`#teachers-table tbody`);
        guestTableBody = document.querySelector(`#guests-table tbody`);

    } else if (document.getElementById(`lrns-table`)) {

        lrnTableBody = document.querySelector(`#lrns-table tbody`);
        recordType = 'lrn';

    } else if (document.getElementById(`employees-table`)) {

        employeeTableBody = document.querySelector(`#employees-table tbody`);
        recordType = 'employee';
    }

    // Object to map record types to their corresponding table bodies
    const tableBodies = {
        student: studentTableBody,
        teacher: teacherTableBody,
        guest: guestTableBody,
        lrn: lrnTableBody,
        employee: employeeTableBody
    };

    // Function to fetch records from the server based on record type and query
    function fetchRecords(recordType, query = '') {
        
        return new Promise((resolve, reject) => {
            // Make a fetch request to the server with the specified record type and query
            fetch(`../../backend/searchfetch.php?record_type=${encodeURIComponent(recordType)}&query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {

                    let rows = '';

                    // If no data is received, display a message indicating no records found
                    if (data.length === 0) {
                        const type = {
                            student: 'Students',
                            guest: 'Guests',
                            teacher: 'Teachers',
                            lrn: 'LRNs',
                            employee: 'DepEd Employee Numbers'
                        }[recordType] || 'Unknown';
                        rows = `<tr><td colspan="5" class="text-center">No ${type} Records Found.</td></tr>`;
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
                                                <a href="../../backend/delete.php?userId=${record.user_id}" class="btn btn-outline-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                            </td>
                                        </tr>
                                    `;
                                });
                                break;
                            case 'teacher':
                                data.forEach(record => {
                                    rows += `
                                        <tr>
                                            <td>${highlightText(record.user_lastname, query)}</td>
                                            <td>${highlightText(record.user_firstname, query)}</td>
                                            <td>${highlightText(record.user_mi, query)}</td>
                                            <td>
                                                <a href="../../backend/delete.php?userId=${record.user_id}" class="btn btn-outline-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
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
                                                <a href="../../backend/delete.php?userId=${record.user_id}" class="btn btn-outline-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                            </td>
                                        </tr>
                                    `;
                                });
                                break;
                            case 'lrn':
                                data.forEach(record => {
                                    const mi = (record.lrn_mi == '') ? '' : `${record.lrn_mi}. `;
                                    rows += `
                                        <tr>
                                            <td>${highlightText(`${record.lrn_firstname} ${mi}${record.lrn_lastname}`, query)}</td>
                                            <td>${highlightText(record.lrn_lrnid, query)}</td>
                                            <td>
                                                <a href="lrn.php?lrnId=${record.lrn_id}" class="btn btn-outline-primary btn-sm"><i class='fas fa-edit'></i></a>
                                                <a href="../../backend/delete.php?lrnId=${record.lrn_id}" class="btn btn-outline-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                            </td>
                                        </tr>
                                    `;
                                });
                                break;
                            case 'employee':
                                data.forEach(record => {
                                    const mi = (record.teacher_mi == '') ? '' : `${record.teacher_mi}. `;
                                    rows += `
                                        <tr>
                                            <td>${highlightText(`${record.teacher_firstname} ${mi}${record.teacher_lastname}`, query)}</td>
                                            <td>${highlightText(record.teacher_depedno, query)}</td>
                                            <td>
                                                <a href="employeeNos.php?teacherId=${record.teacher_id}" class="btn btn-outline-primary btn-sm"><i class='fas fa-edit'></i></a>
                                                <a href="../../backend/delete.php?teacherId=${record.teacher_id}" class="btn btn-outline-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
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
                        case 'employee':
                            options = {
                                multiTd: false,
                                actionText: "You are about to delete the DepEd Employee Number of:",
                                confirmButtonText: "Delete"
                            };
                            break;
                        default:
                            options = {
                                multiTd: true,
                                tdCount: 3, // Number of <td> elements to extract text from
                                actionText: "You are about to deactivate the account of",
                                confirmButtonText: "Delete"
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
        // If there's no query, return the original text
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
        fetchRecords('teacher');
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
            fetchRecords('teacher', query);
            fetchRecords('guest', query);
        } else {
            fetchRecords(recordType, query);
        }
    });

    // Add event listener to handle form submission for search
    document.querySelector('#search-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const query = queryInput.value.trim();
        if (document.getElementById(`users-table`)) {
            fetchRecords('student', query);
            fetchRecords('teacher', query);
            fetchRecords('guest', query);
        } else {
            fetchRecords(recordType, query);
        }
    });
});
