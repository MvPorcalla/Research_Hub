<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Confirmation</title>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        /* Ensure the body takes up the full height of the viewport */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #e8dfec; /* Optional: change background color */
        }

        /* Center the button */
        #logoutButton {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            background-color: #3085d6;
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        #logoutButton:hover {
            background-color: #2874a6; /* Change color on hover */
        }

        .move-button {
            position: absolute;
            transition: transform 0.2s ease;
        }
    </style>
</head>
<body>
    <!-- Your UI -->
    <button id="logoutButton">Logout</button>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('logoutButton').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default button action

            Swal.fire({
                title: 'Are you sure? 😤',
                text: "Do you really want to log out?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, log out!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Are you really sure? 😢',
                        text: "You will be logged out from the session.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: "Yes, I'm sure!",
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Would you reconsider your action? 🤨',
                                text: "Do you definitely want to log out?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'No, log me out!',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        title: 'Really?! 😢',
                                        text: "Are you sure you want to log out?",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Yes Really!',
                                        cancelButtonText: 'Cancel'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            Swal.fire({
                                                title: 'Maybe, stay a little longer? 😘',
                                                text: "Do you really want to log out?",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'No, Please log out!',
                                                cancelButtonText: 'Cancel'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    Swal.fire({
                                                        title: 'Please! 🥺',
                                                        text: "Are you absolutely sure you want to log out?",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Yes, log out!',
                                                        cancelButtonText: 'Cancel'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            Swal.fire({
                                                                title: 'Ok you win!😡',
                                                                text: 'Press "OK" to logout, IF YOU CAN!!!',
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#3085d6',
                                                                cancelButtonColor: '#d33',
                                                                confirmButtonText: 'ok!',
                                                                customClass: {
                                                                    confirmButton: 'move-button'
                                                                },
                                                                didOpen: () => {
                                                                    const confirmButton = Swal.getConfirmButton();
                                                                    const moveButton = (event) => {
                                                                        const rect = confirmButton.getBoundingClientRect();
                                                                        const mouseX = event.clientX;
                                                                        const mouseY = event.clientY;

                                                                        const offsetX = mouseX - (rect.left + rect.width / 2);
                                                                        const offsetY = mouseY - (rect.top + rect.height / 2);

                                                                        const distance = Math.sqrt(offsetX * offsetX + offsetY * offsetY);
                                                                        const maxDistance = 150; // Increase maximum distance

                                                                        if (distance < maxDistance) {
                                                                            const angle = Math.atan2(offsetY, offsetX);
                                                                            const moveX = Math.cos(angle) * (maxDistance - distance);
                                                                            const moveY = Math.sin(angle) * (maxDistance - distance);

                                                                            confirmButton.style.transform = `translate(${moveX}px, ${moveY}px)`;
                                                                        } else {
                                                                            confirmButton.style.transform = 'translate(0, 0)';
                                                                        }
                                                                    };

                                                                    document.addEventListener('mousemove', moveButton);

                                                                    Swal.getCancelButton().addEventListener('click', () => {
                                                                        document.removeEventListener('mousemove', moveButton);
                                                                    });
                                                                }
                                                            }).then((result) => {
                                                                console.log("Heh! you thought, fckin' slave!!!");
                                                                if (result.isConfirmed) {                                                                    Swal.fire({
                                                                        title: "No you won't!!! 😈",
                                                                        text: 'You are stuck with me now! Nyahahaahha!',
                                                                        icon: 'error',
                                                                        confirmButtonColor: '#3085d6',
                                                                        confirmButtonText: 'Go back slave!'
                                                                    }).then(() => {
                                                                        // Handle logout logic here
                                                                        console.log('Go Back!!!');
                                                                    });
                                                                }
                                                            });
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
