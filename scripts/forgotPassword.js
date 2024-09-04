const forgotPasswordForm = document.getElementById('forgotPasswordForm');
const forgotPasswordMessage = document.getElementById('forgotPasswordMessage');

const sendEmail = () => {

    const resetButton = document.getElementById('resetButton');

    // Change text to loading spinner icon
    resetButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

    // serviceID - templateID - #form - publicKey
    emailjs.sendForm('service_7cwt5yl', 'template_9ftw1jf', '#forgotPasswordForm', 'Cd2Zq12n93BO-LWlY')
    .then(() => {
        // Reset button text after successful form submission
        resetButton.innerHTML = 'Send Reset Password Link';

        Swal.fire({
            title: "Password Reset Link Sent!",
            text: "Please check your email.",
            icon: "success"
        });

        forgotPasswordForm.reset();

    }, () => {
        Swal.fire({
            title: "Service Error",
            text: "Password reset link not sent.",
            icon: "error"
        });
    });
}

forgotPasswordForm.addEventListener('submit', (e) => {
    e.preventDefault();
    
    const emailField = forgotPasswordForm.querySelector('#email');
    const email = emailField.value;

    fetch('backend/reset_token.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email }),
    })
    .then(response => response.json())
    .then(data => {

        switch (data.user_status) {
            case 'A':
                const userNameField = forgotPasswordForm.querySelector('#user_firstname');
                userNameField.value = data.user_firstname;

                const resetLinkField = forgotPasswordForm.querySelector('#reset_link');
                resetLinkField.value = `http://localhost/research_Hub/resetPassword.php?token=${data.user_reset_token}`;

                sendEmail();
                
                break;
            case 'I':
                console.log('notify user that the account associated with the email is deactivated');
                break;
            case 'V':
                console.log('notify user that the email provided is not connected to any account');
                break;
            default:
                console.log('error');
                break;

        } 
        
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});