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
            },
            "existing": {
                icon: "error",
                title: "Oops!",
                text: "Record already exists."
            }
        },
        'editRecord': {
            "success": {
                icon: "success",
                title: "Record Edited!",
                text: "Successfully edited record."
            },
            "failed": {
                icon: "error",
                title: "Oops!",
                text: "Failed to edit record."
            }
        },
        'deleteAbstract': {
            "success": {
                icon: "success",
                title: "Record Deleted!"
            },
            "failed": {
                icon: "error",
                title: "Oops!",
                text: "Failed to delete record."
            }
        },
        'deleteUser': {
            "success": {
                icon: "success",
                title: "User Deleted!"
            },
            "failed": {
                icon: "error",
                title: "Oops!",
                text: "Failed to delete user."
            }
        },
        'deleteLrn': {
            "success": {
                icon: "success",
                title: "LRN Deleted!"
            },
            "failed": {
                icon: "error",
                title: "Oops!",
                text: "Failed to delete LRN."
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

// =========================================================================

function setupConfirmationDialog(buttonSelector, options) {
    // Get all elements matching the provided selector
    const buttons = document.querySelectorAll(buttonSelector);

    // Add event listener to each button element
    buttons.forEach(button => {
        button.addEventListener('click', function (event) {
            // Prevent the default action
            event.preventDefault();

            // Extract relevant information based on options
            let textContent;
            if (options.multiTd) {
                // Traverse the DOM to get the corresponding <tr> element
                let row = this.closest('tr');
                // Get the text content from specified <td> elements
                let tdElements = row.querySelectorAll('td');
                let contents = Array.from(tdElements).slice(0, options.tdCount).map(td => td.textContent);
                textContent = contents.join(' ');
            } else {
                // Traverse the DOM to get the corresponding single <td> element
                textContent = this.closest('tr').querySelector('td').textContent;
            }

            // Customize SweetAlert text
            let alertText = `${options.actionText} <strong>${textContent}</strong>`;

            // Trigger the SweetAlert
            Swal.fire({
                title: 'Are you sure?',
                html: alertText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: options.confirmButtonText
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, proceed to the link
                    window.location.href = this.href;
                }
            });
        });
    });
}
