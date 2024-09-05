<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <!-- Boxicons CDN for icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
            margin: 0; /* Remove default margin */
            background: #e8dfec;
        }
        .card-mastercard {
            background: linear-gradient(135deg, #eb001b, #f79c00);
            color: #fff;
            border-radius: 12px;
            padding: 20px;
            min-width: 600px; /* Adjusted for better responsiveness */
            max-width: 600px; /* Added for better responsiveness */
            min-height: 400px;
            margin: auto;
            position: relative;
            text-align: center; /* Centered text */
        }

        .card-mastercard .logo {
            width: 70px;
            margin-bottom: 10px;
        }

        .card-mastercard .chip {
            background: #fff;
            border-radius: 50%;
            width: 50px;
            height: 30px;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .card-mastercard .chip:before {
            content: '';
            display: block;
            width: 20px;
            height: 20px;
            background: #d1d1d1;
            border-radius: 50%;
            margin: 5px auto;
        }

        .card-mastercard .number {
            font-size: 24px;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .card-mastercard .name,
        .card-mastercard .expiry {
            font-size: 14px;
        }

        .card-mastercard .name {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<?php 
    // Save the hash in a variable
    $password = '123';
    $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);
?>

<div class="row my-5 d-flex justify-content-center align-items-center">
    <div class="col-md-12">
        <div class="card card-mastercard">
            <div class="row">
                <div class="col-md-2 d-flex justify-content-center">
                    <div class="logo">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="70" height="70">
                            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.53 2.29 6.5 5.44 7.56.4.08.55-.17.55-.37v-1.57c-2.21.48-2.67-1.07-2.67-1.07-.36-.92-.88-1.17-.88-1.17-.72-.49.05-.48.05-.48.8.06 1.23.82 1.23.82.72 1.23 1.88.87 2.33.67.07-.52.28-.87.5-1.07-1.76-.2-3.61-.88-3.61-3.94 0-.87.31-1.58.82-2.14-.08-.2-.35-1.03.08-2.14 0 0 .67-.22 2.2.84.64-.18 1.33-.27 2.01-.27s1.37.09 2.01.27c1.53-1.06 2.2-.84 2.2-.84.43 1.11.16 1.94.08 2.14.51.56.82 1.27.82 2.14 0 3.06-1.85 3.74-3.62 3.94.29.25.56.74.56 1.49v2.21c0 .2.15.46.55.37C13.71 14.5 16 11.53 16 8c0-4.42-3.58-8-8-8z"/>
                        </svg>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="number">MasterKey Card</div>
                </div>
                <div class="col-md-2 d-flex justify-content-center">
                    <div class="chip"></div>
                </div>
            </div>
            <h1 class="number" data-value="1234 5678 9012 3456">1234 5678 9012 3456</h1>
            <div class="name">PASSWORD: <?php echo $password; ?></div>
            <input type="text" id="hashedPassword" class="form-control mb-3" value="<?php echo $hashedPassword; ?>" readonly>
            <div>
                <button class="btn btn-outline-light w-100" onclick="copyToClipboard()">
                    <i class='bx bx-copy'></i> Copy Hash
                </button>
            </div>
            <div class="name mt-4">Date and Time:</div>
            <div class="expiry" id="dateTime" class="date-time"></div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard() {
        // Select the input element
        var copyText = document.getElementById("hashedPassword");

        // Copy the text inside the input to the clipboard using modern API
        navigator.clipboard.writeText(copyText.value).then(function() {
            // Show SweetAlert message
            Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: 'The hashed password has been copied to the clipboard.',
                showConfirmButton: false,
                timer: 1000
            });
        }).catch(function(error) {
            console.error('Error copying to clipboard: ', error);
        });
    }
    
    const numbers = "0123456789";

    document.querySelector("h1").onmouseover = event => {
        let iterations = 0;
        let interval = setInterval(() => {
            event.target.innerText = event.target.innerText.split("")
                .map((char, index) => {
                    if (index < iterations) {
                        return event.target.dataset.value[index];
                    }
                    return numbers[Math.floor(Math.random() * 10)];
                })
                .join("");

            if (iterations >= event.target.dataset.value.length) {
                clearInterval(interval);
            }

            iterations += 1;
        }, 150);
    }

    function updateDateTime() {
        const now = new Date();
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            weekday: 'long'
        };
        const formattedDateTime = now.toLocaleDateString('en-US', options);
        document.getElementById('dateTime').innerText = formattedDateTime;
    }

    // Update the date and time immediately on page load
    updateDateTime();

    // Optionally, update the date and time every second
    setInterval(updateDateTime, 1000);
</script>

</body>
</html>
