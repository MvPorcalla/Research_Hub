document.addEventListener('DOMContentLoaded', () => {
    const monthFilter = document.getElementById('monthFilter');
    const yearFilter = document.getElementById('yearFilter');
    const trackFilter = document.getElementById('trackFilter');

    // Function to populate select elements
    function populateSelect(selectElement, items, type = 'text') {
        // Determine the default label based on the type
        let defaultLabel = 'All';
        if (type === 'month') {
            defaultLabel = 'All Month';
        } else if (type === 'year') {
            defaultLabel = 'All Year';
        } else if (type === 'track') {
            defaultLabel = 'All Strand';
        }

        selectElement.innerHTML = `<option value="">${defaultLabel}</option>`;

        items.forEach(item => {
            const option = document.createElement('option');

            if (type === 'month') {
                const monthName = new Intl.DateTimeFormat('en', { month: 'long' }).format(new Date(2024, item - 1));
                option.value = item;
                option.textContent = monthName;
            } else {
                option.value = item;
                option.textContent = item;
            }

            selectElement.appendChild(option);
        });
    }

    // Fetch and populate filters
    function populateFilters() {
        fetch('../../backend/fetchFilters.php')
            .then(response => response.json())
            .then(data => {
                populateSelect(monthFilter, data.months, 'month');
                populateSelect(yearFilter, data.years, 'year');
                populateSelect(trackFilter, data.tracks, 'track');
            })
            .catch(error => console.error('Error fetching filters:', error));
    }

    // Fetch filters on page load
    populateFilters();
});
