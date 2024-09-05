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
                title: "Incorrect Credentials",
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
            }
        },
        'token': {
            "invalid": {
                icon: "warning",
                title: "Password Reset Link Invalid",
                text: "The link you have accessed is no longer valid. Please try again."
            }
        },
        'reset': {
            "success": {
                icon: "success",
                title: "Password Reset Success!",
                text: "Please continue with your login."
            },
            "failed": {
                icon: "error",
                title: "Password Reset Failed",
                html: "Something went wrong. Please try again.<hr><small>If problem persists, request for another reset link.</small>"
            },
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
                title: "Record Edited",
                text: "Successfully edited record."
            },
            "failed": {
                icon: "error",
                title: "Oops!",
                text: "Failed to edit record."
            }
        },
        'deleteRecord': {
            "success": {
                icon: "success",
                title: "Record Deleted",
                text: "Successfully deleted record."
            },
            "failed": {
                icon: "error",
                title: "Oops!",
                text: "Failed to delete record."
            }
        },
        'importRecords': {
            "success": {
                icon: "success",
                title: "Content Imported!",
                text: "Successfully imported file contents to the list."
            },
            "failed": {
                icon: "error",
                title: "Import Failed",
                text: "Error importing file. Please try again."
            },
            "error": {
                icon: "error",
                title: "Error",
                text: "Error uploading file. Please try again."
            },
            "invalid": {
                icon: "warning",
                title: "Invalid",
                text: "Invalid file format. Only xls and xlsx files are allowed."
            },
            "missing": {
                icon: "warning",
                title: "Oops!",
                text: "No file uploaded."
            }
        },
        'action': {
            "accepted": {
                icon: "success",
                title: "Guest Accepted!",
                text: "You can now view guest in the list."
            },
            "declined": {
                icon: "success",
                title: "Guest Declined",
                text: "Guest access was declined."
            },
            "failed": {
                icon: "error",
                title: "Oops!",
                text: "Please try again."
            }
        },
        'editInfo': {
            "success": {
                icon: "success",
                title: "Update Successful!",
                text: "Your personal information has been edited."
            },
            "failed": {
                icon: "error",
                title: "Oops!",
                text: "Something went wrong. Please try again."
            }
        },
        'comment': {
            "success": {
                icon: "success",
                title: "Comment Posted!",
            },
            "failed": {
                icon: "error",
                title: "Oops!",
                text: "Something went wrong. Please try again."
            }
        },
        'entry': {
            "success": {
                icon: "success",
                title: "Entry Posted!",
            },
            "failed": {
                icon: "error",
                title: "Oops!",
                text: "Something went wrong. Please try again."
            }
        }
    };

    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get(paramName);

    let message; // Initialize message variable

    if (status) {
        if (paramName === 'exceptions') {
            const parts = status.split("-");
            const existingData = parts[0];
            const notTwelveData = parts[1];
            const totalData = parts[2];
    
            if (existingData == totalData) {
                message = {
                    icon: "info",
                    title: "Records Already Exists",
                    text: `The records within the file already exists in the list.`
                };
            } else if (notTwelveData == totalData) {
                message = {
                    icon: "warning",
                    title: "Records Not Imported!",
                    text: `The records within the file does not follow the 12-digit format of LRNs.`
                };
            } else if (Number(existingData) == 0) {
                message = {
                    icon: "warning",
                    title: "Records Imported!",
                    html: `Successfully imported file records to the list.<hr><small><em>There were <strong>${notTwelveData} non-12-digit LRN(s)</strong> out of <strong>${totalData} records</strong>. Please <strong>fix</strong> format of non-12-digit LRNs and try again.</em></small>`
                };
            } else if (Number(notTwelveData) == 0) {
                message = {
                    icon: "info",
                    title: "Records Imported!",
                    html: `Successfully imported file records to the list.<hr><small><em>There were <strong>${existingData} existing record(s)</strong> out of <strong>${totalData} records</strong>.</em></small>`
                };
            } else if (Number(existingData) + Number(notTwelveData) == Number(totalData)) {
                message = {
                    icon: "info",
                    title: "Records Not Imported!",
                    html: `There were <strong>${existingData} existing record(s)</strong> and <strong>${notTwelveData} non-12-digit LRN(s)</strong> out of <strong>${totalData} records</strong>. Please <strong>fix</strong> format of non-12-digit LRNs and try again.</small>`
                };
            } else {
                message = {
                    icon: "info",
                    title: "Records Imported!",
                    html: `<strong>Successfully imported file records to the list.</strong><hr><small>There were <strong>${existingData} existing record(s)</strong> and <strong>${notTwelveData} non-12-digit LRN(s)</strong> out of <strong>${totalData} records</strong>. Please <strong>fix</strong> format of non-12-digit LRNs and try again.</small>`
                };
            }
        } else {
            const paramMessages = messages[paramName] || {};
            message = paramMessages[status];
        }
        
        if (message) {
            Swal.fire(message);
        }
    
        clearUrlParam(paramName);
    }
    
}

// =========================================================================

function clearUrlParam(paramName) {
    // Clean up URL
    let url = new URL(window.location.href);
    url.searchParams.delete(paramName);
    window.history.replaceState({}, document.title, url.toString());
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
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
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

// =========================================================================

// Define the timeAgo function
function timeAgo(timestamp) {
    const now = new Date();
    const then = new Date(timestamp);
    const diff = now - then; // Difference in milliseconds

    const seconds = Math.floor(diff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const weeks = Math.floor(days / 7);
    const months = Math.floor(days / 30);
    const years = Math.floor(days / 365);

    if (years > 0) return `${years} year${years > 1 ? 's' : ''} ago`;
    if (months > 0) return `${months} month${months > 1 ? 's' : ''} ago`;
    if (weeks > 0) return `${weeks} week${weeks > 1 ? 's' : ''} ago`;
    if (days > 0) return `${days} day${days > 1 ? 's' : ''} ago`;
    if (hours > 0) return `${hours} hour${hours > 1 ? 's' : ''} ago`;
    if (minutes > 0) return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
    return 'Just now';
}

// =========================================================================

function formatDateTime(timestamp) {
    const date = new Date(timestamp);
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true // Use 12-hour clock (AM/PM)
    };
    return date.toLocaleDateString('en-US', options);
}

// =========================================================================

function confirmPassword() {
    
    const form = document.getElementById('formWithPassword');
    form.addEventListener('submit', function (e) {

        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (password !== confirmPassword) {
            e.preventDefault(); // Prevent form submission
            Swal.fire({
                icon: "error",
                title: "Passwords do not match.",
                text: "Please try again."
            });
        }
    });
}

// =========================================================================

function getLikes() {
    let userIdElement = document.getElementById('abstractTiles') || document.getElementById('favoriteTiles') || document.getElementById('commentsContainer') || document.getElementById('entriesContainer');
    const userId = userIdElement ? userIdElement.getAttribute('data-user-id') : null;
    const buttons = document.querySelectorAll('.like-button');
    
    const requests = Array.from(buttons).map(button => {
        const abstractId = button.getAttribute('data-record-id');
        const entryId = button.getAttribute('data-entry-id');
        const commentId = button.getAttribute('data-comment-id');

        if (abstractId) {
            return fetch(`../../backend/get_like_status.php?record_type=record&recordId=${abstractId}&userId=${userId}`)
                .then(response => response.json())
                .then(data => {
                    
                    if (data.like_status === 'A') {
                        button.classList.add('btn-danger');
                        button.classList.remove('btn-outline-danger');
                    } else {
                        button.classList.add('btn-outline-danger');
                        button.classList.remove('btn-danger');
                    }
                })
                .catch(error => {
                    console.error('Error fetching like status:', error);
                });

        } else if (entryId) {
                    
            return fetch(`../../backend/get_like_status.php?record_type=entry&recordId=${entryId}&userId=${userId}`)
                .then(response => response.json())
                .then(data => {

                    const icon = button.querySelector('svg');

                    if (data.like_status == 'A') {
                        icon.classList.add('liked');
                    } else {
                        icon.classList.remove('liked');
                    }
                })
                .catch(error => {
                    console.error('Error fetching like status:', error);
                });

        } else if (commentId) {
            return fetch(`../../backend/get_like_status.php?record_type=comment&recordId=${commentId}&userId=${userId}`)
                .then(response => response.json())
                .then(data => {
                    
                    const icon = button.querySelector('svg');

                    if (data.like_status == 'A') {
                        icon.classList.add('liked');
                    } else {
                        icon.classList.remove('liked');
                    }
                })
                .catch(error => {
                    console.error('Error fetching like status:', error);
                });
        }
    });

    // Ensure all requests are completed
    Promise.all(requests).then(() => {
        console.log('All like statuses updated');
    });
}