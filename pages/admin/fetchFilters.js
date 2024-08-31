// populate the Filters

const monthFilter = document.getElementById('monthFilter');
const yearFilter = document.getElementById('yearFilter');
const trackFilter = document.getElementById('trackFilter');

const monthNames = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

async function fetchFilters() {
    try {
        const response = await fetch('fetchFilters.php');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        populateFilters(data);
    } catch (error) {
        console.error('Error fetching filters:', error);
    }
}

function populateFilters(data) {
    // Populate month filter
    data.months.forEach(monthNumber => {
        const option = document.createElement('option');
        option.value = monthNumber;
        option.textContent = getMonthName(monthNumber);
        monthFilter.appendChild(option);
    });

    // Populate year filter
    data.years.forEach(year => {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearFilter.appendChild(option);
    });

    // Populate track/strand filter
    data.tracks.forEach(track => {
        const option = document.createElement('option');
        option.value = track;
        option.textContent = track;
        trackFilter.appendChild(option);
    });
}

function getMonthName(monthNumber) {
    return monthNames[monthNumber - 1] || "Unknown";
}

// Fetch filters on page load
fetchFilters();
