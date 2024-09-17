// Function to handle profile update
async function updateProfile() {
    // Get form data from the profile edit form
    const formData = new FormData(document.querySelector('#editProfileForm'));

    // Show SweetAlert confirmation dialog before proceeding
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to update your profile?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Update'
    }).then(async (result) => {
        // If the user confirms the update
        if (result.isConfirmed) {
            try {
                // Send the form data to the backend using fetch
                const response = await fetch('../../backend/update_profile.php', {
                    method: 'POST',
                    body: formData
                });

                // Throw an error if the response is not OK
                if (!response.ok) throw new Error('Network response was not ok');

                // Parse the JSON response
                const result = await response.json();

                // If the update is successful, show a success alert and reload the page
                if (result.status === 'success') {
                    Swal.fire({
                        title: 'Updated!',
                        text: 'Your profile has been updated.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Reload the page after closing the SweetAlert
                        window.location.reload();
                    });
                } else {
                    // Show a warning alert if the update fails
                    Swal.fire({
                        title: 'Warning!',
                        text: result.message || 'Failed to update profile.',
                        icon: 'warning',
                        backdrop: `rgba(255, 255, 0 ,0.1)`,
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                // Show a warning alert if an error occurs during the update
                Swal.fire({
                    title: 'Warning!',
                    text: 'An error occurred while updating your profile.',
                    icon: 'warning',
                    backdrop: `rgba(255, 255, 0 ,0.1)`,
                    confirmButtonText: 'OK'
                });
            }
        }
    });
}

// Function to handle password update
async function updatePassword() {
    const editPasswordForm = document.getElementById('editPasswordForm');
    // Get form data from the password edit form
    const formData = new FormData(editPasswordForm);

    // Show SweetAlert confirmation dialog before proceeding
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to update your password?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Update'
    }).then(async (result) => {
        // If the user confirms the update
        if (result.isConfirmed) {
            editPasswordForm.reset();
            
            try {
                // Send the form data to the backend using fetch
                const response = await fetch('../../backend/update_password.php', {
                    method: 'POST',
                    body: formData
                });

                // Throw an error if the response is not OK
                if (!response.ok) throw new Error('Network response was not ok');

                // Parse the JSON response
                const result = await response.json();

                // If the update is successful, show a success alert and close the modal
                if (result.status === 'success') {
                    Swal.fire({
                        title: 'Updated!',
                        text: 'Your password has been updated.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Close the password modal and reset the form
                        let modal = bootstrap.Modal.getInstance(document.getElementById('editPassModal'));
                        modal.hide();
                        document.querySelector('#editPasswordForm').reset();
                    });
                } else {
                    // Show a warning alert if the update fails
                    Swal.fire({
                        title: 'Warning!',
                        text: result.message || 'Failed to update password.',
                        icon: 'warning',
                        backdrop: `rgba(255, 255, 0 ,0.1)`,
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                // Show a warning alert if an error occurs during the update
                Swal.fire({
                    title: 'Warning!',
                    text: 'An error occurred while updating your password.',
                    icon: 'warning',
                    backdrop: `rgba(255, 255, 0 ,0.1)`,
                    confirmButtonText: 'OK'
                });
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {

    document.querySelector('#editProfileForm').addEventListener('submit', function(event) {
        event.preventDefault();
        updateProfile(); // Call the function to handle the profile update
    });

    document.querySelector('#editPasswordForm').addEventListener('submit', function(event) {
        event.preventDefault();
        updatePassword(); // Call the function to handle the password update
    });
});
