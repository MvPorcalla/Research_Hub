document.addEventListener('DOMContentLoaded', function() {
    const queryInput = document.querySelector('#query');
    const tableBody = document.querySelector('#records-table tbody');

    function fetchRecords(query = '') {
        console.log('Fetching records with query:', query); // Debugging line
        
        fetch(`../../backend/searchfetch.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                console.log('Data received:', data); // Debugging line                

                let rows = '';

                if (data.length === 0) {
                    rows = '<tr><td colspan="4">No records found.</td></tr>';
                } else {
                    data.forEach(record => {
                        const month = Intl.DateTimeFormat('en', { month: 'long' }).format(new Date(record.record_month));
                        rows += `
                            <tr onclick="window.location.href='abstractView.php?abstractId=${record.record_id}';" style="cursor: pointer;">
                                <td>${highlightText(record.record_title, query)}</td>
                                <td>${highlightText(month + ' ' + record.record_year, query)}</td>
                                <td>${highlightText(record.record_authors, query)}</td>
                                <td>${highlightText(record.record_trackstrand, query)}</td>
                                <td>
                                    <a href="abstract.php?abstractId=${record.record_id}" class="btn btn-primary btn-sm"><i class='fas fa-edit'></i></a>
                                    <a href="../../backend/delete.php?abstractId=${record.record_id}" class="btn btn-danger btn-sm delete-button"><i class='fas fa-trash-alt'></i></a>
                                </td>
                            </tr>
                        `;
                    });
                }

                tableBody.innerHTML = rows;
            })
            .catch(error => {
                console.error('Error fetching records:', error);
            });
    }

    function fetchSuggestions(query) {
        if (query.length < 2) {
            queryInput.placeholder = 'Search...'; // Default placeholder
            return;
        }

        fetch(`searchSuggestion.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    // Combine suggestions into a single string
                    const suggestions = data.map(item => item).join(', ');
                    queryInput.placeholder = `Suggestions: ${suggestions}`; // Update placeholder with suggestions
                } else {
                    queryInput.placeholder = 'No suggestions available'; // Placeholder when no suggestions
                }
            })
            .catch(error => {
                console.error('Error fetching suggestions:', error);
            });
    }

    function highlightText(text, query) {
        if (!query) return text;
        const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp('(' + escapedQuery + ')', 'gi');
        return text.replace(regex, '<strong>$1</strong>');
    }

    fetchRecords('');

    queryInput.addEventListener('input', function() {
        const query = queryInput.value.trim();
        fetchSuggestions(query); // Fetch suggestions based on the current query
        fetchRecords(query); // Fetch records based on the current query
    });

    document.querySelector('#search-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const query = queryInput.value.trim();
        fetchRecords(query); // Fetch records based on the search query when the form is submitted
    });
});
