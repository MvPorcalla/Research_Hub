// Function to show SweetAlert based on the paramName and its status
function handleStatus(paramName) {
    // Define different messages based on action and status
    const messages = {
        'login': {
            "success": {
                icon: "info",
                title: "Welcome to Research Hub!",
            },
            "failed": {
                icon: "error",
                title: "Incorrect Credentials",
                text: "Please try again.",
                backdrop: `rgba(255, 0, 0 ,0.2)`,
            },
            "inactive": {
                icon: "error",
                title: "Oops!",
                text: "Account deactivated.",
                backdrop: `rgba(255, 0, 0 ,0.2)`,
            },
            "registered": {
                icon: "info",
                title: "Registration Complete!",
                text: "Please log in with your credentials."
            },
        },
        'token': {
            "invalid": {
                icon: "warning",
                title: "Password Reset Link Invalid",
                text: "The link you have accessed is no longer valid. Please try again.",
                backdrop: `rgba(255, 255, 0 ,0.1)`,
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
                html: "Something went wrong. Please try again.<hr><small>If problem persists, request for another reset link.</small>",
                backdrop: `rgba(255, 0, 0 ,0.2)`,
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
                text: "Failed to add new record.",
                backdrop: `rgba(255, 0, 0 ,0.2)`,
            },
            "existing": {
                icon: "error",
                title: "Oops!",
                text: "Record already exists.",
                backdrop: `rgba(255, 0, 0 ,0.2)`,
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
                text: "Failed to edit record.",
                backdrop: `rgba(255, 0, 0 ,0.2)`,
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
                text: "Failed to delete record.",
                backdrop: `rgba(255, 0, 0 ,0.2)`,
            }
        },
        'importRecords': {
            "success": {
                icon: "success",
                title: "Content Imported!",
                text: "Successfully imported file contents to the list."
            },
            "error": {
                icon: "error",
                title: "Error",
                text: "Error uploading file. Please try again.",
                backdrop: `rgba(255, 0, 0 ,0.2)`,
            },
            "invalid": {
                icon: "warning",
                title: "Invalid",
                text: "Invalid file format. Only xls and xlsx files are allowed.",
                backdrop: `rgba(255, 255, 0 ,0.1)`,
            },
            "missing": {
                icon: "warning",
                title: "Oops!",
                text: "No file uploaded.",
                backdrop: `rgba(255, 255, 0 ,0.1)`,
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
                text: "Something went wrong. Please try again.",
                backdrop: `rgba(255, 0, 0 ,0.2)`,
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
                text: "Something went wrong. Please try again.",
                backdrop: `rgba(255, 0, 0 ,0.2)`,
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
                text: "Something went wrong. Please try again.",
                backdrop: `rgba(255, 0, 0 ,0.2)`,
            }
        }
    };

    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get(paramName);

    let message;

    if (status) {
        // Handle 'exceptions' status separately for specific import scenarios
        if (paramName === 'exceptions') {
            // Split status into parts for detailed error handling
            const parts = status.split("-");
            const existingData = parts[0];
            const notTwelveData = parts[1];
            const totalData = parts[2];

            // Determine appropriate message based on the parts
            if (existingData == totalData) {
                message = {
                    icon: "info",
                    title: "Records Already Exists",
                    text: `The records within the file already exist in the list.`
                };
            } else if (notTwelveData == totalData) {
                message = {
                    icon: "warning",
                    title: "Records Not Imported!",
                    text: `The records within the file do not follow the 12-digit format of LRNs.`
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
            // Retrieve the message for the specified status and paramName
            const paramMessages = messages[paramName] || {};
            message = paramMessages[status];
        }

        // Display the message if it exists
        if (message) {
            Swal.fire(message);
        }

        // Clear the URL parameter to prevent repeated messages
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

// Function to setup a confirmation dialog
function setupConfirmationDialog(buttonSelector, options) {
    // Get all elements matching the provided selector
    const buttons = document.querySelectorAll(buttonSelector);

    buttons.forEach(button => {
        button.addEventListener('click', function (event) {

            event.preventDefault();

            let textContent;

            if (options.multiTd) {
                // If options.multiTd is true, get text from multiple <td> elements

                let row = this.closest('tr');

                // Get the text content from the specified number of <td> elements
                let tdElements = row.querySelectorAll('td');
                let contents = Array.from(tdElements).slice(0, options.tdCount).map(td => td.textContent);

                if (options.tdCount == 3) {
                    contents = contents.slice(1).concat(contents[0]);
                    contents[1] = contents[1] + '.';
                }
                
                // Join the text content with a space
                textContent = contents.join(' ');
            } else {
                // If options.multiTd is false, get text from a single <td> element

                // Get the first <td> element
                textContent = this.closest('tr').querySelector('td').textContent;
            }

            // Customize SweetAlert text with the extracted text content
            let alertText = `${options.actionText} <strong>${textContent}</strong>`;

            // Trigger the SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                html: alertText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: options.confirmButtonText // Custom confirm button text
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user confirms, redirect to the href of the clicked button
                    window.location.href = this.href;
                }
            });
        });
    });
}

// =========================================================================

// Function to calculate the time passed based on given timestamp
function timeAgo(timestamp) {
    // Get the current date and time
    const now = new Date();

    // Convert the timestamp to a Date object
    const then = new Date(timestamp);

    // Calculate the difference in milliseconds
    const diff = now - then;

    // Convert the difference into various time units
    const seconds = Math.floor(diff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const weeks = Math.floor(days / 7);
    const months = Math.floor(days / 30);
    const years = Math.floor(days / 365);

    // Return a human-readable time difference
    if (years > 0) return `${years} year${years > 1 ? 's' : ''} ago`;
    if (months > 0) return `${months} month${months > 1 ? 's' : ''} ago`;
    if (weeks > 0) return `${weeks} week${weeks > 1 ? 's' : ''} ago`;
    if (days > 0) return `${days} day${days > 1 ? 's' : ''} ago`;
    if (hours > 0) return `${hours} hour${hours > 1 ? 's' : ''} ago`;
    if (minutes > 0) return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
    return 'Just now'; // Default message for recent timestamps
}

// =========================================================================

// Function to format the given timestamp
function formatDateTime(timestamp) {
    // Convert the timestamp to a Date object
    const date = new Date(timestamp);

    // Define options for formatting the date and time
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    };

    // Return the formatted date and time string
    return date.toLocaleDateString('en-US', options);
}

// =========================================================================

// Function confirm password
function confirmPassword(formId) {

    const form = document.getElementById(formId);

    form.addEventListener('submit', function (e) {

        const password = form.querySelector('#password').value;
        const confirmPassword = form.querySelector('#confirmPassword').value;

        // Check if the password and confirm password fields match
        if (password !== confirmPassword) {
            e.preventDefault();

            // Display an error message using SweetAlert
            Swal.fire({
                icon: "error",
                title: "Passwords do not match.",
                text: "Please try again."
            });
        }
    });
}

// =========================================================================

function handleInputSubmit(formId, inputId, errorId) {
    const commentForm = document.getElementById(formId);
    
    // Ensure the event listener is attached only once
    commentForm.addEventListener('submit', async function(event) {
        
        // Get the forbidden words array from the globally defined function
        const forbiddenWords = getForbiddenWords();
        const inputText = document.getElementById(inputId).value.toLowerCase();
    
        // Check if the input contains any forbidden words
        for (let i = 0; i < forbiddenWords.length; i++) {
            if (inputText.includes(forbiddenWords[i])) {
                // Prevent form submission and show an error message
                event.preventDefault();
                document.getElementById(errorId).textContent = `Your input contains a forbidden word (${forbiddenWords[i]}). Please remove them and try again.`;
                return;  // Stop further execution if forbidden words are found
            }
        }

        // Clear error message if no forbidden words are found
        document.getElementById(errorId).textContent = "";

        if (formId != 'askQuestionForm') {
            event.preventDefault();

            // Proceed to post the comment if there are no forbidden words
            try {
                const formData = new FormData(commentForm);
                
                // Send the form data to the backend using fetch
                const response = await fetch('../../backend/comment.php', {
                    method: 'POST',
                    body: formData
                });

                // Throw an error if the response is not OK
                if (!response.ok) throw new Error('Network response was not ok');

                // Parse the JSON response
                const result = await response.json();

                // If the update is successful, show a success alert and reload the page
                if (result.status === 'success') {
                    commentForm.reset();

                    const { record_id, entry_id, user_id, user_username, user_idpicture_imgdir, user_lastname, user_firstname, user_mi, comment_id, comment_content, comment_timestamp } = result.data;
                    
                    const commentsContainer = document.getElementById('commentsContainer');
                    const commentSection = document.getElementById(`comment-section-${entry_id}`);
                    const commentsElement = document.getElementById(`comments-${entry_id}`);

                    const noComments = (commentsContainer) ? commentsContainer.querySelector('.no-comments') : commentSection.querySelector('.no-comments');
                    if (noComments) {
                        noComments.remove();
                        if (commentSection) {
                            commentSection.innerHTML = `
                                <div id="comments-${entry_id}" class="card-body">
                                    <!-- Data will be dynamically inserted here -->
                                </div>
                            `;
                        }
                    }

                    // Build the user's full name
                    const mi = (user_mi == '') ? '' : `${user_mi}. `;
                    const fullName = `${user_firstname} ${mi}${user_lastname}`;
                    
                    const timestamp = comment_timestamp;
                    const timePassed = timeAgo(timestamp); // Calculate the time passed since the entry was posted
                    const formattedDateTime = formatDateTime(timestamp); // Format the timestamp for display

                    let tileHTML = '';

                    if (commentsContainer) {
                        // Construct the HTML for each comment card
                        tileHTML = `
                            <div class="card comment-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <div class="d-flex flex-row align-items-center">
                                            <img title="${fullName}" src="../${user_idpicture_imgdir}" alt="${user_username}" class="img-fluid rounded-circle" style="width: 25px; height: 25px;" />
                                            <p title="${fullName}" class="small mb-0 ms-2">${user_username}</p>
                                        </div>
                                        <div class="d-flex flex-row align-items-center">
                                            <button class="btn px-0" onclick="window.location.href='../../backend/delete.php?abstract_id=${record_id}&comment_id=${comment_id}'">
                                                <i class="fas fa-trash mx-2 fa-xs text-body" style="margin-top: -0.16rem;"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-start">${comment_content}</p>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row align-items-center">
                                            <p title="${formattedDateTime}" style="cursor: pointer;"><small>${timePassed}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        // Append the constructed HTML to the comments container
                        commentsContainer.insertAdjacentHTML("afterbegin", tileHTML);

                    } else if (commentsElement) {
                        tileHTML = `
                            <div class="row">
                                <div class="comment d-flex col-md-10">
                                    <img src="../${user_idpicture_imgdir}" alt="${user_username}" class="img-fluid rounded-circle me-3" style="width: 30px; height: 30px;">
                                    <p><strong>${user_username}:</strong> ${comment_content}</p>
                                    <hr>
                                </div>
                                <div class="col-md-2">
                                    <p title="${formattedDateTime}" style="cursor: pointer;"><small>${timePassed}</small></p>
                                </div>
                            </div>
                        `;
                        // Append the comment HTML to the comments element
                        commentsElement.insertAdjacentHTML("afterbegin", tileHTML);
                    }
                } else {
                    // Show a warning alert if the update fails
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        backdrop: `rgba(255, 0, 0 ,0.2)`,
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                // Handle any errors that occur during the fetch operation
                console.error('Error:', error);
            }
        }
    });
}

// =========================================================================

function characterCounter(inputId, counterId) {
        
    const inputField = document.getElementById(inputId);
    const charCounter = document.getElementById(counterId);
    const maxLength = inputField.getAttribute('maxlength');

    charCounter.textContent = `0/${maxLength}`;

    inputField.addEventListener('input', function() {
        const currentLength = inputField.value.length;
        charCounter.textContent = `${currentLength}/${maxLength}`;
    });
}
