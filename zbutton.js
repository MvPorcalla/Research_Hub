document.getElementById('githubBtn').addEventListener('click', function() {
    // Use a default username for demonstration
    const defaultUsername = 'MvPorcalla'; // Replace with valid GitHub username
    const githubUrl = `https://api.github.com/users/${defaultUsername}`;

    let timerInterval;
    
    Swal.fire({
        title: 'Loading...',
        html: 'Fetching GitHub user data...',
        backdrop: `rgba(0,0,123,0.4) left top no-repeat`,
        timer: 2000, // Timer duration in milliseconds
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
            const timer = Swal.getPopup().querySelector('b');
            timerInterval = setInterval(() => {
                timer.textContent = `${Swal.getTimerLeft()} milliseconds`;
            }, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
    }).then(async () => {
        try {
            const response = await fetch(githubUrl);
            if (!response.ok) {
                // Check for JSON response and handle accordingly
                const errorData = await response.json();
                return Swal.fire({
                    title: 'Error!',
                    text: `Failed to fetch user data: ${errorData.message || 'Unknown error'}`,
                    icon: 'error',
                    backdrop: `rgba(255,0,0,0.5) left top no-repeat`,
                    timer: 5000
                });
            }
            const userData = await response.json();
            Swal.fire({
                title: `${userData.login}'s Avatar`,
                imageUrl: userData.avatar_url,
                imageAlt: `${userData.login}'s Avatar`,
                html: `<p><a href="https://github.com/${userData.login}" target="_blank">View Profile</a></p>`,
                backdrop: `rgba(0,0,123,0.4) left top no-repeat`,
                confirmButtonText: 'Close',
                timer: 15000
            });
        } catch (error) {
            Swal.fire({
                title: 'Error!',
                text: `Request failed: ${error.message || 'Unknown error'}`,
                icon: 'error',
                backdrop: `rgba(255,0,0,0.5) left top no-repeat`,
                timer: 5000
            });
        }
    });
});