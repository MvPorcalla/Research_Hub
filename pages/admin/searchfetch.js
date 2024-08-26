document.addEventListener('DOMContentLoaded', function() {
    const $queryInput = document.querySelector('#query');
    const $tableBody = document.querySelector('#records-table tbody');

    function fetchRecords(query = '') {
        console.log('Fetching records with query:', query); // Debugging line

        fetch(`searchfetch.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                console.log('Data received:', data); // Debugging line
                $tableBody.innerHTML = ''; // Clear the table body

                if (data.length === 0) {
                    $tableBody.innerHTML = '<tr><td colspan="4">No records found.</td></tr>';
                } else {
                    data.forEach(record => {
                        const row = `
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
                        $tableBody.innerHTML += row;
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching records:', error);
            });
    }

    // Fetch records when the page loads
    fetchRecords('');

    // Handle real-time search input
    $queryInput.addEventListener('input', function() {
        const query = $queryInput.value.trim();
        fetchRecords(query);
    });

    // Handle form submission
    document.querySelector('#search-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get the search query
        const query = $queryInput.value.trim();

        // Fetch records based on the search query
        fetchRecords(query);
    });
});
