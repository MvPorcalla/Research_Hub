document.addEventListener('DOMContentLoaded', () => {
    const monthFilter = document.getElementById('monthFilter');
    const yearFilter = document.getElementById('yearFilter');
    const trackFilter = document.getElementById('trackFilter');

    // Function to populate a select element with options
    function populateSelect(selectElement, items, type = 'text') {
        // Determine the default label for the select element based on the type
        let defaultLabel = 'All';
        if (type === 'month') {
            defaultLabel = 'All Month';
        } else if (type === 'year') {
            defaultLabel = 'All Year';
        } else if (type === 'track') {
            defaultLabel = 'All Strand';
        }

        selectElement.innerHTML = `<option value="">${defaultLabel}</option>`;

        // Iterate over the items array and create option elements
        items.forEach(item => {
            const option = document.createElement('option');

            if (type === 'month') {
                // Format the month name for the option text
                const monthName = new Intl.DateTimeFormat('en', { month: 'long' }).format(new Date(2024, item - 1));
                option.value = item;
                option.textContent = monthName;
            } else {
                option.value = item;
                option.textContent = item;
            }

            // Append the option element to the select element
            selectElement.appendChild(option);
        });
    }

    // Function to fetch filter data and populate select elements
    function populateFilters() {
        fetch('../../backend/fetchFilters.php')
            .then(response => response.json()) // Parse the response as JSON
            .then(data => {
                // Populate each filter select element with the fetched data
                populateSelect(monthFilter, data.months, 'month');
                populateSelect(yearFilter, data.years, 'year');
                populateSelect(trackFilter, data.tracks, 'track');
            })
            .catch(error => console.error('Error fetching filters:', error)); // Log any errors
    }

    // Fetch and populate filters when the page loads
    populateFilters();
});
