document.addEventListener('DOMContentLoaded', function() {
    // Select the input field for the search query and the table body
    const queryInput = document.querySelector('#query');
    const tableBody = document.querySelector('#records-table tbody');

    // Function to fetch and display records based on the search query
    function fetchRecords(query = '') {
        console.log('Fetching records with query:', query); // Debugging line
        

        // Send a request to the server to fetch records
        fetch(`searchfetch.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json()) // Parse the JSON response
            .then(data => {
                console.log('Data received:', data); // Debugging line                

                // Initialize an empty string to hold the table rows
                let rows = '';

                // Check if any records were returned
                if (data.length === 0) {
                    // If no records, display a "No records found" message
                    rows = '<tr><td colspan="4">No records found.</td></tr>';
                } else {
                    // If records are found, create table rows for each record
                    data.forEach(record => {
                        rows += `
                            <tr>
                                <td>${record.record_title}</td>
                                <td>${record.record_month} ${record.record_year}</td>
                                <td>${record.record_authors}</td>
                                <td>
                                    <a href="edit.php?id=${record.record_id}" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="copy.php?id=${record.record_id}" class="btn btn-info btn-sm">Copy</a>
                                </td>
                            </tr>
                        `;
                    });
                }

                // Update the table body with the generated rows
                tableBody.innerHTML = rows;
            })
            .catch(error => {
                // Log any errors that occur during the fetch
                console.error('Error fetching records:', error);
            });
    }

    // Fetch and display records when the page loads
    fetchRecords('');

    // Add event listener for real-time search input
    queryInput.addEventListener('input', function() {
        const query = queryInput.value.trim(); // Get and trim the input value
        fetchRecords(query); // Fetch records based on the current query
    });

    // Add event listener for form submission
    document.querySelector('#search-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission action

        // Get the search query from the input field
        const query = queryInput.value.trim();

        // Fetch records based on the search query when the form is submitted
        fetchRecords(query);
    });
});
