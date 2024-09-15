document.addEventListener('DOMContentLoaded', async function() {
    // Create a URLSearchParams object to access URL parameters
    const urlParams = new URLSearchParams(window.location.search);

    try {
        let idType, idValue, formId;

        const element = document.getElementById('completeName');
        let userId = null;

        // Check for 'abstractId' in URL parameters
        if (urlParams.has('abstractId')) {
            idType = 'abstractId';
            idValue = urlParams.get('abstractId');
            formId = 'recordForm';

        // Check for 'lrnId' in URL parameters
        } else if (urlParams.has('lrnId')) {
            idType = 'lrnId';
            idValue = urlParams.get('lrnId');
            formId = 'lrnForm';

        // If no URL parameters, but the 'completeName' element exists, set userId
        } else if (element) {
            userId = element.getAttribute('data-user-id');
            idType = 'userId';
            idValue = userId;

        // Exit if neither parameter is present
        } else {
            return;
        }

        // Fetch data from the PHP script based on the ID type and value
        const response = await fetch(`../../backend/fetchOneRecord.php?${idType}=${idValue}`);

        // Check if the response is successful
        if (!response.ok) {
            throw new Error(`Failed to fetch data: ${response.statusText}`);
        }

        // Parse the JSON response
        const data = await response.json();

        // Handle any errors in the data
        if (data.error) {
            console.error(data.error);
            return;
        }

        var url = window.location.href;

        // If not on 'abstractView.php', update the form action with ID type and value
        if (idType != 'userId' && !url.includes('abstractView.php')) {
            const form = document.getElementById(formId);
            form.setAttribute('action', `${form.getAttribute('action')}?${idType}=${idValue}`);
        }

        // Handle data based on the ID type
        if (idType === 'abstractId') {
            // Format month with leading zero
            const month = data.record_month.toString().padStart(2, '0');

            if (document.getElementById('title')) {
                // Populate fields for editing record
                document.getElementById('abstractTitle').textContent = 'Edit Record - LNHS Research Hub';
                document.getElementById('recordSubtitle').textContent = 'Edit Record';
                document.getElementById('title').value = data.record_title;
                document.getElementById('authors').value = data.record_authors;
                document.getElementById('monthYear').value = `${data.record_year}-${month}`;
                document.getElementById('trackStrand').value = data.record_trackstrand;

                document.getElementById('changeFileCheckbox').querySelector('input').hidden = false;
                document.getElementById('changeFileCheckbox').querySelector('label').hidden = false;
                document.getElementById('file').disabled = true;

            } else if (document.getElementById('fileDisplay')) {
                // Display the file if 'fileDisplay' element exists
                document.getElementById('fileDisplay').src = `../${data.record_filedir}`;
            }
        } else if (idType === 'lrnId') {
            // Populate fields for editing LRN
            document.getElementById('lrnTitle').textContent = 'Edit LRN - LNHS Research Hub';
            document.getElementById('lrnSubtitle').textContent = 'Edit Student LRN';
            document.getElementById('lastName').value = data.lrn_lastname;
            document.getElementById('firstName').value = data.lrn_firstname;
            document.getElementById('middleInitial').value = data.lrn_mi;
            document.getElementById('lrn').value = data.lrn_lrnid;

        } else if (idType === 'userId') {
            // Populate fields for user profile
            const mi = (data.user_mi == '') ? ' ' : data.user_mi + '. ';
            document.getElementById('idImage').src = `../${data.user_idpicture_imgdir}`;
            document.getElementById('completeName').textContent = `${data.user_firstname} ${mi}${data.user_lastname}`;
            document.getElementById('userName').textContent = `@${data.user_username}`;
            document.getElementById('emailAdd').textContent = data.user_emailadd;
            document.getElementById('emailField').value = data.user_emailadd;
            document.getElementById('lastName').value = data.user_lastname;
            document.getElementById('firstName').value = data.user_firstname;
            document.getElementById('middleInitial').value = data.user_mi;
            document.getElementById('usernameField').value = data.user_username;
        }
    } catch (error) {
        // Log any errors that occur during the fetch operation
        console.error('Error fetching data:', error);
    }
});
