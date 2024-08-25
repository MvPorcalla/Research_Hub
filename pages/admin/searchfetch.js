$(document).ready(function() {
    const $queryInput = $('#query');
    const $tableBody = $('#records-table tbody');

    function fetchRecords(query = '') {
        console.log('Fetching records with query:', query); // Debugging line

        $.ajax({
            url: 'searchfetch.php',
            type: 'GET',
            data: { query: query },
            dataType: 'json',
            success: function(data) {
                console.log('Data received:', data); // Debugging line
                $tableBody.empty(); // Clear the table body

                if (data.length === 0) {
                    $tableBody.append('<tr><td colspan="4">No records found.</td></tr>');
                } else {
                    data.forEach(record => {
                        const row = `
                            <tr>
                                <td>${record.record_title}</td>
                                <td>${record.record_month} ${record.record_year}</td>
                                <td>${record.record_authors}</td>
                                <td>
                                    <a href="edit.php?id=${record.record_id}" class="btn btn-warning btn-sm">Nice</a>
                                    <a href="copy.php?id=${record.record_id}" class="btn btn-info btn-sm">Shit</a>
                                </td>
                            </tr>
                        `;
                        $tableBody.append(row);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching records:', error);
            }
        });
    }

    // Fetch records initially
    fetchRecords();

    // Real-time search
    $queryInput.on('input', function() {
        const query = $queryInput.val();
        fetchRecords(query);
    });
});