<?php include_once './../admin/includes/session_check.php'; ?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pending Approval - LNHS Research Hub</title>
        <?php include './../admin/includes/links_head-css.php'; ?>
    </head>

    <body>
        <!-- header -->
        <?php include './../admin/components/header.php'; ?>

        <!-- main content with sidebar -->
        <div class="container-fluid">
            <div class="row">
                <!-- sidebar -->
                <?php include './../admin/components/sidebar.php'; ?>

                <!-- Main content area -->
                <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
                    <div class="container">
                        <div class="row">
                            <div class="mt-5 mb-3 text-center">
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

        <?php include './../admin/includes/links_footer-script.php'; ?>

        <script src="../../includes/functions.js"></script>
        <script src="../../scripts/fetchPendingGuests.js"></script>
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
