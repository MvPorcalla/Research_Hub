// Function to handle profile update
async function updateProfile() {
    // Get form data
    const formData = new FormData(document.querySelector('#editProfileForm'));

    // SweetAlert confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to update your profile?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, update it!'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const response = await fetch('../../backend/update_profile.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const result = await response.json();
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
                    Swal.fire({
                        title: 'Error!',
                        text: result.message || 'Failed to update profile.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while updating your profile.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.error('Error updating profile:', error);
            }
        }
    });
}

// Function to handle password update
async function updatePassword() {
    // Get form data
    const formData = new FormData(document.querySelector('#editPasswordForm'));

    // SweetAlert confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to update your password?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, update it!'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const response = await fetch('../../backend/update_password.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const result = await response.json();
                if (result.status === 'success') {
                    Swal.fire({
                        title: 'Updated!',
                        text: 'Your password has been updated.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Close modal and optionally reset form
                        let modal = bootstrap.Modal.getInstance(document.getElementById('editPassModal'));
                        modal.hide();
                        document.querySelector('#editPasswordForm').reset();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: result.message || 'Failed to update password.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while updating your password.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.error('Error updating password:', error);
            }
        }
    });
}

// Add event listeners for both forms
document.addEventListener('DOMContentLoaded', function() {
    // Event listener for profile form submission
    document.querySelector('#editProfileForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        updateProfile(); // Call the function to handle the update
    });

    // Event listener for password form submission
    document.querySelector('#editPasswordForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        updatePassword(); // Call the function to handle the update
    });
});
