<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME PAGE - LNHS Research Hub</title>
    <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/mainStyle.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .btn {
            position: relative;
        }
        .input-group {
            position: relative;
        }
        .form-control {
            padding-right: 50px; /* Adjusted to accommodate the button */
        }
        .btn-search {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <!-- header -->
    <?php include './../admin/components/header.php'; ?>

    <!-- main content with sidebar -->
    <div class="container-fluid">
        <div class="row">
            <!-- sidebar -->

            <!-- Main content area -->
            <main class="col-md-9 ms-sm-auto col-lg-12 px-md-4">
                <div class="container">
                    <div class="row">
                        <div class="my-3">
                            <h1 class="admin_title">Sample Search bar SheeBars</h1>
                        </div>

                        <!-- Search Bar -->
                        <div class="row">
                            <div class="col-md-5 d-flex justify-content-start">
                                <a href="./abstract.php" class="btn btn-secondary px-3">Add</a>
                            </div>

                            <div class="col-md-7">
                                <div class="d-flex justify-content-end">
                                    <form id="search-form" class="d-flex w-100">
                                        <div class="input-group">
                                            <input class="form-control rounded-pill" type="search" id="query" placeholder="Search" aria-label="Search">
                                            <button class="btn btn-primary btn-search" type="button">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Content Table -->
                        <div class="container mt-3 side-container">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped abstracts" id="records-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Title</th>
                                            <th>Month Year</th>
                                            <th>Author</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <!-- Data will be dynamically inserted here -->
                                    </tbody>
                                </table>
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

    <script src="searchfetch.js"></script>
</body>
</html>
