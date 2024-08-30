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
            },
            "failed": {
                icon: "error",
                title: "Oops!",
                text: "Your registration failed. Please try again."
            },
            "existing": {
                icon: "error",
                title: "LRN already registered.",
                text: "Your LRN has already been registered to an account."
            },
            "wronglrn": {
                icon: "error",
                title: "Wrong LRN",
                text: "Your LRN does not exist in the database."
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
        if (paramName === 'existingRecords') {
            const parts = status.split("-");
            const existingData = parts[0];
            const totalData = parts[1];
    
            if (existingData == totalData) {
                message = {
                    icon: "info",
                    title: "Records Already Exists",
                    text: `The records within the file already exists in the list.`
                };
            } else {
                message = {
                    icon: "success",
                    title: "Records Imported!",
                    html: `Successfully imported file records to the list.<br><small>There were ${existingData} existing record(s) out of ${totalData} records.</small>`
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
    
    const form = document.getElementById('editForm');
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

function displayCommentTiles(data, commentsContainer, abstractId) {

    data.forEach(dataRow => {

        const timestamp = dataRow.commentTimestamp;

        const timePassed = timeAgo(timestamp);
        const formattedDateTime = formatDateTime(timestamp);

        var url = window.location.href;
        var type = url.includes('admin') ? 'admin' : 'user';

        let buttonHTML;
        let likesHTML = '';
        
        // Change the button HTML based on the context
        if (type === 'admin') {
            buttonHTML = `
                <div class="d-flex flex-row align-items-center">
                    <button class="btn px-0" onclick="window.location.href='../../backend/delete.php?abstract_id=${abstractId}&comment_id=${dataRow.commentId}'">
                        <i class="fas fa-trash mx-2 fa-xs text-body" style="margin-top: -0.16rem;"></i>
                    </button>
                </div>
            `;
            likesHTML = `
                <div class="d-flex flex-row align-items-center">
                    <p><small>Likes: ${dataRow.commentLikes}</small></p>
                </div>
            `;
        } else {
            buttonHTML = `
                <div class="likes-section d-flex flex-row align-items-center">
                    <button class="btn like-button px-0" data-comment-id="${dataRow.commentId}">
                        <i class="far fa-thumbs-up mx-2 fa-xs text-body" style="margin-top: -0.16rem;"></i>
                    </button>
                    <p class="small text-muted mb-0 me-2">${dataRow.commentLikes}</p>
                </div>
            `;
        }

        let tileHTML = `
            <div class="card comment-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="d-flex flex-row align-items-center">
                            <img src="../${dataRow.userIdImage}" alt="avatar" class="img-fluid rounded-circle" style="width: 25px; height: 25px;" />
                            <p class="small mb-0 ms-2">${dataRow.userName}</p>
                        </div>
                        ${buttonHTML}
                    </div>
                    <p class="text-start">${dataRow.commentContent}</p>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex flex-row align-items-center">
                            <p title="${formattedDateTime}" style="cursor: pointer;"><small>${timePassed}</small></p>
                        </div>
                        ${likesHTML}
                    </div>
                </div>
            </div>
        `;
        commentsContainer.innerHTML += tileHTML;
    });

}