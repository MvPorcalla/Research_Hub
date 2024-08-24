document.addEventListener('DOMContentLoaded', async function() {
    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);

    try {
        // Determine the type and value of the parameter
        let idType, idValue, formId;

        if (urlParams.has('abstractId')) {
            idType = 'abstractId';
            idValue = urlParams.get('abstractId');
            formId = 'recordForm';
        } else if (urlParams.has('lrnId')) {
            idType = 'lrnId';
            idValue = urlParams.get('lrnId');
            formId = 'lrnForm';
        } else {
            return; // Exit if neither parameter is present
        }

        // Fetch data from the PHP script
        const response = await fetch(`../../backend/fetchOneRecord.php?${idType}=${idValue}`);

        if (!response.ok) {
            throw new Error(`Failed to fetch data: ${response.statusText}`);
        }

        const data = await response.json(); // Parse JSON response

        if (data.error) {
            console.error(data.error); // Handle error in data
            return;
        }

        // Populate form fields
        const form = document.getElementById(formId);
        form.setAttribute('action', `${form.getAttribute('action')}?${idType}=${idValue}`);

        if (idType === 'abstractId') {
            const month = data.record_month.toString().padStart(2, '0');

            document.getElementById('recordSubtitle').textContent = 'Edit Record';
            document.getElementById('title').value = data.record_title;
            document.getElementById('authors').value = data.record_authors;
            document.getElementById('monthYear').value = `${data.record_year}-${month}`;
            document.getElementById('trackStrand').value = data.record_trackstrand;
            document.getElementById('file').required = false;

        } else if (idType === 'lrnId') {
            document.getElementById('lrnSubtitle').textContent = 'Edit Student LRN';
            document.getElementById('fullName').value = data.lrn_student;
            document.getElementById('lrn').value = data.lrn_lrnid;
        }

    } catch (error) {
        console.error('Error fetching data:', error);
    }
});
