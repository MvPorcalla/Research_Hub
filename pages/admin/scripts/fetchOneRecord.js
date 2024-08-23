document.addEventListener('DOMContentLoaded', async function() {
    // Get the abstractId from the URL, if it exists
    const urlParams = new URLSearchParams(window.location.search);
    const abstractId = urlParams.get('abstractId');

    // Only fetch data if an abstractId is present in the URL
    if (abstractId) {
        try {
            // Await the fetch call to get the data from the PHP script
            const response = await fetch(`../../backend/fetchOneRecord.php?abstractId=${abstractId}`);

            // Check if the response is ok (status 200-299)
            if (response.ok) {
                const data = await response.json(); // Await and parse the JSON response

                // Check for an error in the data
                if (data.error) {
                    console.error(data.error);
                } else {
                    // Populate form fields with the data
                    const form = document.getElementById('recordForm');
                    let formBackEnd = form.getAttribute('action');
                    formBackEnd += "?abstractId=" + abstractId;
                    form.setAttribute('action', formBackEnd);

                    let month = data.record_month;
                    month = month.toString().padStart(2, '0');

                    document.getElementById('recordSubtitle').textContent = 'Edit Record';
                    document.getElementById('title').value = data.record_title;
                    document.getElementById('authors').value = data.record_authors;
                    document.getElementById('monthYear').value = `${data.record_year}-${month}`;
                    document.getElementById('trackStrand').value = data.record_trackstrand;
                    document.getElementById('file').required = false

                }
            } else {
                console.error('Failed to fetch data:', response.statusText);
            }
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }
});
