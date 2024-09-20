// Async function to handle user registration
async function register() {
    try {
        // Create a FormData object with the form data from the form with the ID 'formWithPassword'
        const formData = new FormData(document.getElementById('registrationForm'));

        // Send a POST request to 'backend/register.php' with the form data
        const response = await fetch('backend/register.php', {
            method: 'POST',
            enctype: "multipart/form-data",
            body: formData
        });

        // Check if the response is not ok, and throw an error if so
        if (!response.ok) throw new Error('Network response was not ok');

        // Parse the response as JSON
        const result = await response.json();

        // Check if the result indicates an error
        if (result.status == 'error') {
            Swal.fire({
                title: 'Warning!',
                html: result.message || 'Your registration failed. Please try again.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        } else {
            // Redirect according to role
            if (result.role == 'G') {

                sessionStorage.setItem('showPendingAlert', 'true');
                window.location.href = "index.php";

            } else {
                window.location.href = "login.php?login=registered";
            }
        }

    } catch (error) {
        // Log any errors that occur during the fetch operation
        console.error('Error fetching records:', error);
    }
}

// Add an event listener to the form submission event
document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission behavior
    register(); // Call the register function to handle the registration process
});
