async function register() {
    try {
        const formData = new FormData(document.querySelector('#formWithPassword'));
        console.log('formData:' + formData);

        const response = await fetch('backend/register.php', {
            method: 'POST',
            enctype: "multipart/form-data",
            body: formData
        });

        if (!response.ok) throw new Error('Network response was not ok');
        const result = await response.json();

        if (result.status == 'error') {
            Swal.fire({
                title: 'Warning!',
                text: result.message || 'Your registration failed. Please try again.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        } else {
            window.location.href = result.redirect;
        }

    } catch (error) {
        console.error('Error fetching records:', error);
    }
}

document.querySelector('#formWithPassword').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    register(); // Call the function to handle the update
});