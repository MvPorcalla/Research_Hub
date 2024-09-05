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

// Add event listener for the form submission
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('#editPasswordForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        updatePassword(); // Call the function to handle the update
    });
});