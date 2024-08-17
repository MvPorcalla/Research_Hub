<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME PAGE - LNHS Research Hub</title>
    <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/mainStyle.css">

    <style>
        .sidebar {
            height: 90vh;
            background-color: #f8f9fa;
            padding-top: 20px;
        }

        .sidebar a {
            text-decoration: none;
            padding: 10px;
            display: block;
            color: #000;
        }

        .sidebar a:hover {
            background-color: #ddd;
            color: #000;
        }
    </style>
</head>

<body>
    <!-- header -->
    <?php include './../user/components/header.php' ?>

    <!-- main content with sidebar -->
    <div class="container-fluid">
        <div class="row">
        
        <!-- sidebar -->
        <?php include './../user/components/sidebar.php' ?>

            <!-- Main content area -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container d-flex align-items-center justify-content-center">
                    <div class="row text-center text-danger">
                        <h1> BMO Always Bounces Back</h1>
                        <hr>
                        <h1 class="text-primary">Home Page for User test run</h1>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const loginStatus = urlParams.get('login');

            if (loginStatus === 'success') {
                Swal.fire({
                    icon: "info",
                    title: "Welcome to Research Hub!"
                });
            }
        });
    </script>
</body>

</html>
