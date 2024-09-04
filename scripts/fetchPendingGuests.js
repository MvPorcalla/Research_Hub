var url = window.location.href;

if (url.includes('pendingRequest.php')) {
    document.addEventListener('DOMContentLoaded', () => {
    
        const fetchPendingGuests = async () => {
            try {
    
                if (document.getElementById('pendingTiles')) {
    
                    const pendingTiles = document.getElementById('pendingTiles');
    
                    const response = await fetch(`../../backend/fetchRecords.php?fetch=pending`);
                    if (!response.ok) throw new Error('Network response was not ok');
    
                    const data = await response.json();
                    pendingTiles.innerHTML = '';
    
                    data.forEach(dataRow => {
                        let tileHTML = `
                            <div class="col-md-6 mb-4">
                                <div class="card border-dark rounded-4 h-100">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-center flex-grow-1">${dataRow.fname} ${dataRow.mi}. ${dataRow.lname}</h5>
                                        <p class="card-text text-center">${dataRow.email}</p>
                                        <p class="card-text text-center">${dataRow.school}</p>
                                        
                                        <div class="border border-secondary rounded p-2 mb-3">
                                            <p class="card-text text-center fw-bold mb-1">Reason</p>
                                            <p class="card-text text-center">${dataRow.reason}</p>
                                        </div>
                                        <div class="d-flex justify-content-center mt-auto">
                                            <form id="pendingForm_${dataRow.id}" method="POST">
                                                <input type="text" name="website_name" id="website_name" hidden value="Research Hub">
                                                <input type="text" name="website_link" id="website_link" hidden value="http://localhost/research_Hub/">
                                                <input type="text" name="user_name" id="user_name" hidden>
                                                <input type="text" name="user_email" id="user_email" hidden>
                                                <input type="text" name="temp_username" id="temp_username" hidden>
                                                <input type="text" name="temp_password" id="temp_password" hidden>
                                                <a id="accept_${dataRow.id}" class="btn btn-primary btn-sm me-2 accept pending">Accept</a>
                                                <a id="decline_${dataRow.id}" class="btn btn-danger btn-sm decline pending">Decline</a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        pendingTiles.innerHTML += tileHTML;
                    });
                }
            } catch (error) {
                console.error('Error fetching records:', error);
            }
        };
    
        fetchPendingGuests().then(() => {
            if (url.includes('pages/admin/pendingRequest.php')) {
                const sendEmail = (e, linkId, pendingFormId) => {
                    e.preventDefault();
                
                    const actionButton = document.getElementById(linkId);
                
                    // Change text to loading spinner icon
                    actionButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    
                    // serviceID - templateID - #form - publicKey
                    emailjs.sendForm('service_7cwt5yl', 'template_tnti15c', `#${pendingFormId}`, 'Cd2Zq12n93BO-LWlY')
                    .then(() => {
                        // Set a flag in sessionStorage
                        sessionStorage.setItem('showAcceptedAlert', 'true');
                        
                        location.reload();
                    }, () => {
                        Swal.fire({
                            title: "Service Error",
                            text: "User accepted with no username and password set via email.",
                            icon: "error"
                        });
                    });
                }
                
                // Select all anchor elements with the class 'accept'
                const links = document.querySelectorAll('.pending');
                
                // Iterate through the NodeList and add event listeners or perform other actions
                links.forEach(link => {
                    link.addEventListener('click', function(event) {
                        event.preventDefault(); // Prevent the default link action
                        
                        // get form
                        const pendingForm = this.closest('form');
                        const pendingFormId = pendingForm.id;
                        // pendingForm.submit();
    
                        const linkId = this.id;
                        const action_id = linkId.split('_');
                        const action = action_id[0];
                        const userId = action_id[1];
                
                        fetch(`../../backend/pending_actions.php`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ action, userId})
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (action == 'accept') {
    
                                console.log('got data');
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
                    
                                sendEmail(event, linkId, pendingFormId);
                            } else {
                                // Set a flag in sessionStorage
                                sessionStorage.setItem('showDeclinedAlert', 'true');
    
                                location.reload();
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                    });
                });
                
            }
        })
    });
}