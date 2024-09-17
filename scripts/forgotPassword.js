const forgotPasswordForm = document.getElementById('forgotPasswordForm');
const forgotPasswordMessage = document.getElementById('forgotPasswordMessage');

// Function to send the password reset email using emailjs
const sendEmail = () => {

    const resetButton = document.getElementById('resetButton');
    resetButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

    // Send the form data using emailjs (serviceID, templateID, form selector, publicKey)
    emailjs.sendForm('service_7cwt5yl', 'template_9ftw1jf', '#forgotPasswordForm', 'Cd2Zq12n93BO-LWlY')
    .then(() => {
        resetButton.innerHTML = 'Send Reset Password Link';

        Swal.fire({
            title: "Password Reset Link Sent!",
            text: "Please check your email.",
            icon: "success"
        });

        // Reset the form fields after sending the email
        forgotPasswordForm.reset();

    }, () => {
        Swal.fire({
            title: "Service Error",
            text: "Password reset link not sent.",
            icon: "error"
        });
    });
}

// Add an event listener to handle form submission
forgotPasswordForm.addEventListener('submit', (e) => {
    // Prevent the default form submission behavior
    e.preventDefault();

    const emailField = forgotPasswordForm.querySelector('#email');
    const email = emailField.value;

    // Send the email to the backend to generate a reset token
    fetch('backend/reset_token.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email }), // Send the email as JSON in the request body
    })
    .then(response => response.json()) // Parse the response as JSON
    .then(data => {

        // Handle different user status responses from the backend
        switch (data.user_status) {
            case 'A': // Active account

                const userNameField = forgotPasswordForm.querySelector('#user_firstname');
                userNameField.value = data.user_firstname;

                const resetLinkField = forgotPasswordForm.querySelector('#reset_link');
                resetLinkField.value = `http://localhost/research_Hub/resetPassword.php?token=${data.user_reset_token}`;

                // Send the email with the reset link
                sendEmail();

                break;
            case 'I': // Inactive account
                Swal.fire({
                    title: "Oops!",
                    text: "The account associated with the email address provided is deactivated.",
                    icon: "info"
                });
                break;
            case 'V': // Invalid account (email not connected to any account)
                Swal.fire({
                    title: "Oops!",
                    text: "The email address provided is not connected to any account.",
                    icon: "info"
                });
                break;
            default: // Handle any other errors
                console.log('Error');
                break;
        } 

    })
    .catch((error) => {
        // Log any errors that occur during the fetch operation
        console.error('Error:', error);
    });
});
