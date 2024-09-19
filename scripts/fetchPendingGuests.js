var url = window.location.href;

if (url.includes('pendingRequest.php')) {
    document.addEventListener('DOMContentLoaded', () => {
    
        // Function to fetch and display pending guest records
        const fetchPendingGuests = async () => {
            try {
                // Check if the element for pending tiles exists in the DOM
                if (document.getElementById('pendingTiles')) {
                    
                    const pendingTiles = document.getElementById('pendingTiles'); // Get the container element for pending guests
                    pendingTiles.innerHTML = '';
                    
                    // Fetch pending guest records from the backend
                    const response = await fetch(`../../backend/fetchRecords.php?fetch=pending`);

                    // Handle any network errors
                    if (!response.ok) throw new Error('Network response was not ok');
                    
                    const data = await response.json(); // Parse the JSON response
                    
                    // Iterate over each record and generate HTML for each pending guest
                    data.forEach(dataRow => {
                        let tileHTML = `
                            <div class="col-md-6 mb-4">
                                <div class="card border-dark rounded-4 h-100">
                                    <div class="card-body d-flex flex-column mx-2">
                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <img src="../${dataRow.userIdImage}" alt="image" class="rounded-circle me-3" style="width: 90px; height: 90px;">
                                            </div>

                                            <div class="col-md-9 text-start">
                                                <h4 class="card-title fw-bold flex-grow-1">${dataRow.fname} ${dataRow.mi}. ${dataRow.lname}</h4>
                                                <h5 class="card-text">${dataRow.email}</h5>
                                                <p class="card-text">${dataRow.school}</p>
                                            </div>
                                        </div>

                                        <div class="row text-start mt-3">
                                            <div class="col-md-12">
                                                <h5 class="fw-bold mb-1">Reason</h5>
                                                <div class="border border-secondary rounded p-2 mb-3 overflow-auto" style="background: #e5e7eb; height: 140px;">
                                                    <p class="card-text mb-0">${dataRow.reason}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="d-flex justify-content-end mt-auto">
                                                <form id="pendingForm_${dataRow.id}" method="POST">
                                                    <!-- Hidden input fields to store guest information for form submission -->
                                                    <input type="text" name="website_name" id="website_name" hidden value="Research Hub">
                                                    <input type="text" name="website_link" id="website_link" hidden value="http://localhost/research_Hub/">
                                                    <input type="text" name="user_name" id="user_name" hidden>
                                                    <input type="text" name="user_email" id="user_email" hidden>
                                                    <input type="text" name="temp_username" id="temp_username" hidden>
                                                    <input type="text" name="temp_password" id="temp_password" hidden>

                                                    <!-- Buttons for accepting or declining pending guests -->
                                                    <a id="accept_${dataRow.id}" class="btn btn-primary btn-sm me-2 accept pending">Accept</a>
                                                    <a id="decline_${dataRow.id}" class="btn btn-danger btn-sm decline pending">Decline</a>
                                                </form>
                                            </div>
                                        </div>

                                        
                                    </div>
                                </div>
                            </div>
                        `;
                        // Append the generated HTML to the container element
                        pendingTiles.innerHTML += tileHTML;
                    });
                }
            } catch (error) {
                console.error('Error fetching records:', error); // Log any errors that occur during the fetch operation
            }
        };
    
        // Fetch pending guests and then perform the following operations
        fetchPendingGuests().then(() => {
            
            // Function to send an email using emailjs
            const sendEmail = (e, linkId, pendingFormId) => {
                e.preventDefault();
                
                const actionButton = document.getElementById(linkId);
                actionButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                
                // Send the form data via email using emailjs
                // serviceID - templateID - #form - publicKey
                emailjs.sendForm('service_7cwt5yl', 'template_tnti15c', `#${pendingFormId}`, 'Cd2Zq12n93BO-LWlY')
                .then(() => {
                    // Set a flag in sessionStorage to show an alert after reload
                    sessionStorage.setItem('showAcceptedAlert', 'true');
                    
                    location.reload(); // Reload the page after successful email sending
                }, () => {
                    // Show an error alert if email sending fails
                    Swal.fire({
                        title: "Service Error",
                        text: "User accepted with no username and password set via email.",
                        icon: "error"
                    });
                });
            }
            
            const links = document.querySelectorAll('.pending');
            
            // Iterate through the NodeList and add event listeners to each link
            links.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    
                    const pendingForm = this.closest('form');
                    const pendingFormId = pendingForm.id;
                    
                    const linkId = this.id;
                    const action_id = linkId.split('_'); // Split the link ID to get the action and user ID
                    const action = action_id[0]; // The action to perform (accept or decline)
                    const userId = action_id[1]; // The user ID associated with the action
                    
                    // Send a POST request to the backend to handle the action
                    fetch(`../../backend/pending_actions.php`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ action, userId }) // Send the action and user ID as JSON
                    })
                    .then(response => response.json()) // Parse the JSON response
                    .then(data => {
                        if (action == 'accept') { // If the action is 'accept'
                            
                            console.log('got data');
                            
                            // Populate form fields with data from the server
                            const name = pendingForm.querySelector('#user_name');
                            name.value = data.firstName;
                            console.log(`First Name: ${data.firstName}`);
                            
                            const email = pendingForm.querySelector('#user_email');
                            email.value = data.userEmail;
                            console.log(`Email: ${data.userEmail}`);
                            
                            const userName = pendingForm.querySelector('#temp_username');
                            userName.value = data.userName;
                            console.log(`Username: ${data.userName}`);
                            
                            const password = pendingForm.querySelector('#temp_password');
                            password.value = data.password;
                            console.log(`Password: ${data.password}`);
                            
                            // Send the email with the populated form data
                            sendEmail(event, linkId, pendingFormId);

                        } else { // If the action is 'decline'
                            // Set a flag in sessionStorage to show an alert after reload
                            sessionStorage.setItem('showDeclinedAlert', 'true');
                            
                            location.reload(); // Reload the page after the decline action
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error); // Log any errors that occur during the fetch operation
                    });
                });
            });
        });
    });
}