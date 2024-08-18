<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Record - LNHS Research Hub</title>
    <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/mainStyle.css">
    <style>
        .admin-card {
            border-radius: 20px;
            border:1px solid #000;
        }
    </style>
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
                            <h1 class='admin-subtitle'>Add Student LRN</h1>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="card admin-card bg-transparent">
                                    
                                    <div class="card-body mx-5 text-start">
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            
                                            <!-- First name -->
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="firstName" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                                                </div>
                                            </div>

                                            <!-- Last name -->
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="firstName" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                                                </div>
                                            </div>

                                            <!-- Middle initial -->
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="firstName" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                                                </div>
                                            </div>
                                            
                                            <!-- LRN / Student Number -->
                                            <div class="mb-3">
                                                <label for="lrn" class="form-label">LRN / Student Number</label>
                                                <input type="text" class="form-control" id="lrn" name="lrn" maxlength="12" required>
                                            </div>

                                           
                                            <!-- Submit Button -->
                                            <div class="d-grid my-3">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                                                                
                                        </form>
                                    </div>
                                </div>
                            </div>
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
