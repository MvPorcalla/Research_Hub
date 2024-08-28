document.addEventListener('DOMContentLoaded', async function() {
    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);

    try {
        // Determine the type and value of the parameter
        let idType, idValue, formId;

        const element = document.getElementById('completeName');
        let userId = null;

        if (urlParams.has('abstractId')) {

            idType = 'abstractId';
            idValue = urlParams.get('abstractId');
            formId = 'recordForm';

        } else if (urlParams.has('lrnId')) {

            idType = 'lrnId';
            idValue = urlParams.get('lrnId');
            formId = 'lrnForm';

        } else if (element) {

            userId = element.getAttribute('data-user-id');
            
            idType = 'userId';
            idValue = userId;

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

        var url = window.location.href;

        if (idType != 'userId' && !url.includes('abstractView.php')) {
            
            const form = document.getElementById(formId);
            form.setAttribute('action', `${form.getAttribute('action')}?${idType}=${idValue}`);
        }

        if (idType === 'abstractId') {
            const month = data.record_month.toString().padStart(2, '0');

            if (document.getElementById('title')) {
                document.getElementById('abstractTitle').textContent = 'Edit Record - LNHS Research Hub';
                document.getElementById('recordSubtitle').textContent = 'Edit Record';
                document.getElementById('title').value = data.record_title;
                document.getElementById('authors').value = data.record_authors;
                document.getElementById('monthYear').value = `${data.record_year}-${month}`;
                document.getElementById('trackStrand').value = data.record_trackstrand;
                document.getElementById('file').required = false;
            } else if (document.getElementById('fileDisplay')) {
                document.getElementById('fileDisplay').src = `../${data.record_filedir}`;
            }
        } 
        else if (idType === 'lrnId') {
            document.getElementById('lrnTitle').textContent = 'Edit LRN - LNHS Research Hub';
            document.getElementById('lrnSubtitle').textContent = 'Edit Student LRN';
            document.getElementById('fullName').value = data.lrn_student;
            document.getElementById('lrn').value = data.lrn_lrnid;
        } 
        else if (idType === 'userId') {
            const mi = (data.user_mi == '') ? ' ' : data.user_mi + '. ';

            document.getElementById('idImage').src = `../${data.user_idpicture_imgdir}`;
            document.getElementById('completeName').textContent = `${data.user_firstname} ${mi}${data.user_lastname}`;
            document.getElementById('userName').textContent = `@${data.user_username}`;
            document.getElementById('emailAdd').textContent = data.user_emailadd;
            document.getElementById('lastName').value = data.user_lastname;
            document.getElementById('firstName').value = data.user_firstname;
            document.getElementById('middleInitial').value = data.user_mi;
            document.getElementById('usernameField').value = data.user_username;
        }

    } catch (error) {
        console.error('Error fetching data:', error);
    }
});
