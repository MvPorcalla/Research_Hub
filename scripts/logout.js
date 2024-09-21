document.getElementById('logoutButton').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default button behavior

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to log out?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Log out',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../../backend/logout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    sessionStorage.clear();
                    // Redirect to index.php if logout is successful
                    window.location.href = '../../index.php';
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Logout failed: ' + (data.message || 'An unknown error occurred.'),
                        icon: 'error',
                        backdrop: `rgba(255, 0, 0 ,0.2)`,
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Logout failed: An unknown error occurred.',
                    icon: 'error',
                    backdrop: `rgba(255, 0, 0 ,0.2)`,
                    confirmButtonText: 'OK'
                });
            });
        }
    });
});
