// shows sweet alert depending on paramName and its value
function handleStatus(paramName) {
    const messages = {
        'login': {
            "success": {
                icon: "info",
                title: "Welcome to Research Hub!"
            },
            "failed": {
                icon: "error",
                title: "Incorrect credentials.",
                text: "Please try again."
            },
            "inactive": {
                icon: "error",
                title: "Oops!",
                text: "Account deactivated."
            }
        },
        'registration': {
            "success": {
                icon: "success",
                title: "Registration Complete!",
                text: "Your registration is pending for approval by the admin."
            },
            "wronglrn": {
                icon: "error",
                title: "Wrong LRN.",
                text: "Your LRN does not exist in the database."
            },
            "existing": {
                icon: "error",
                title: "LRN already registered.",
                text: "Your LRN has already been registered to an account."
            },
            "failed": {
                icon: "error",
                title: "Oops!",
                text: "Your registration failed. Please try again."
            }
        },
        'reset': {
            "success": {
                icon: "success",
                title: "Password Reset Link Sent!",
                text: "The link will be sent you shortly. Please check your email."
            },
            "failed": {
                icon: "error",
                title: "Password Reset Failed",
                text: "No account found with that email address."
            }
        },
        'addRecord': {
            "success": {
                icon: "success",
                title: "Record Added!",
                text: "Successfully added a new record to the list."
            },
            "failed": {
                icon: "error",
                title: "Oops!",
                text: "Failed to add new record."
            }
        }
    };

    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get(paramName);

    if (status) {
        const paramMessages = messages[paramName] || {};
        const message = paramMessages[status];
        if (message) {
            Swal.fire(message);
        }

        // Clean up URL
        let url = new URL(window.location.href);
        url.searchParams.delete(paramName);
        window.history.replaceState({}, document.title, url.toString());
    }
}