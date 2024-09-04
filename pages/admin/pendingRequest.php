<?php
include_once "..\..\includes\db.php";

if (!isset($_SESSION['user_type'])) {
    header("location: ../../index.php");
    exit;
} elseif ($_SESSION['user_type'] != 'A') {
    header("location: ../../backend/logout.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pending Approval - LNHS Research Hub</title>
        <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../../css/mainStyle.css">

    </head>

    <body>
        <!-- header -->
        <?php include './../admin/components/header.php'; ?>

        <!-- main content with sidebar -->
        <div class="container-fluid">
            <div class="row text-center">
                <!-- sidebar -->
                <?php include './../admin/components/sidebar.php'; ?>

                <!-- Main content area -->
                <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
                    <div class="container">
                        <div class="row">
                            <div class="mt-5 mb-3">
                                <h1 class='admin-subtitle'>Pending Approval</h1>
                            </div>
                            <div id="pendingTiles" class="row">
                                <!-- Data will be dynamically inserted here -->
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
        <script src="..\..\includes\functions.js"></script>
        <script src="../../scripts/fetchRecords.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                handleStatus('action');
            });

            window.onload = function() {
            // Check if the flag is set
            if (sessionStorage.getItem('showAcceptedAlert') === 'true') {
                // Show the alert
                Swal.fire({
                    title: `Request Accepted!`,
                    text: "Random username and password sent accordingly via email.",
                    icon: "success"
                });

                // Clear the flag
                sessionStorage.removeItem('showAcceptedAlert');
            }
            if (sessionStorage.getItem('showDeclinedAlert') === 'true') {
                // Show the alert
                Swal.fire({
                    title: "Access Request Declined",
                    icon: "success"
                });

                // Clear the flag
                sessionStorage.removeItem('showDeclinedAlert');
            }
        };

        </script>
    </body>

</html>
