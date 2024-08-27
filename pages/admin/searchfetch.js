document.addEventListener('DOMContentLoaded', function() {
    // Select the input field for the search query and the table body
    const queryInput = document.querySelector('#query');
    const tableBody = document.querySelector('#records-table tbody');
    const suggestionsDiv = document.getElementById('suggestions');

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

    // Function to fetch and display suggestions based on the query
    function fetchSuggestions(query) {
        if (query.length < 2) {
            suggestionsDiv.style.display = 'none';
            return;
        }

        fetch(`searchSuggestion.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                suggestionsDiv.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(item => {
                        const div = document.createElement('div');
                        div.innerHTML = highlightMatch(item, query);
                        div.addEventListener('click', () => {
                            queryInput.value = item;
                            suggestionsDiv.style.display = 'none';
                            fetchRecords(item);
                        });
                        suggestionsDiv.appendChild(div);
                    });
                    suggestionsDiv.style.display = 'block';
                } else {
                    suggestionsDiv.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error fetching suggestions:', error);
            });
    }

    // Function to highlight matched text in suggestions
    function highlightMatch(text, query) {
        const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp('(' + escapedQuery + ')', 'gi');
        return text.replace(regex, '<strong>$1</strong>');
    }

    // Fetch and display records when the page loads
    fetchRecords('');

    // Add event listener for real-time search input
    queryInput.addEventListener('input', function() {
        const query = queryInput.value.trim();
        fetchSuggestions(query); // Fetch suggestions based on the current query
        fetchRecords(query); // Fetch records based on the current query
    });

    // Add event listener for form submission
    document.querySelector('#search-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission action

        const query = queryInput.value.trim();
        fetchRecords(query); // Fetch records based on the search query when the form is submitted
    });

    // Hide suggestions when clicking outside the search container
    document.addEventListener('click', function(event) {
        if (!document.querySelector('.search-container').contains(event.target)) {
            suggestionsDiv.style.display = 'none';
        }
    });
});
