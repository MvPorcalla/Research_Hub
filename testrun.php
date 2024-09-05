<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS for styling and layout -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icon usage -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS for the main styling of the website -->
    <link rel="stylesheet" href="./css/mainStyle.css">
</head>
<body>
                    <!-- Dropdown sample data -->
                    <?php
                        // Sample data for dropdown menu items
                        $notifications = [
                            [
                                'label' => 'New abstract',
                                'count' => 2,
                                'type' => 'abstract',
                                'date' => 'Fri, Sep 6',
                                'url' => '#', // URL for the new abstract notification
                            ],
                            [
                                'label' => 'New comment',
                                'count' => 5,
                                'type' => 'comment',
                                'date' => 'Fri, Sep 6',
                                'url' => '#', // URL for the new comment notification
                            ],
                            [
                                'label' => 'Pending Request',
                                'count' => 3,
                                'type' => 'pending',
                                'date' => 'Fri, Sep 6',
                                'url' => '#', // URL for the pending review notification
                            ],
                            // Add more items as needed
                        ];

                        // Function to determine badge class based on notification type
                        function getBadgeClass($type) {
                            switch ($type) {
                                case 'abstract':
                                    return 'bg-primary';
                                case 'comment':
                                    return 'bg-success';
                                case 'pending':
                                    return 'bg-info';
                                default:
                                    return 'bg-secondary'; // Default badge class
                            }
                        }

                        // Total number of notifications (could be used for the main badge)
                        $totalNotifications = array_sum(array_column($notifications, 'count'));
                    ?>

        <!-- /components/header.php -->
        <header class="header header-bg p-2">
            <div class="container-fluid d-flex align-items-center">
                <div class="d-flex align-items-center w-100">
                    <!-- Logo Section -->
                    <div class="col-md-1 d-flex justify-content-center">
                        <img src="./assets/icons/LNHS-icon.png" alt="icon" class="rounded-circle header-icon">
                    </div>
                    <!-- Title Section -->
                    <div class="col-md-10">
                        <h1 class="header-title mb-0">Ligao National High School</h1>
                        <h2 class="header-title mb-0">Research Hub</h2>
                    </div>


                    <!-- Dropdown Button -->
                    <div class="dropdown notification" id="notification">
                        <a class="dropdown-toggle dropdown-start d-flex align-items-center position-relative" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell "></i>
                            <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle"><?php echo $totalNotifications; ?></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <?php foreach ($notifications as $notification): ?>
                                <li class="">
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="<?php echo htmlspecialchars($notification['url']); ?>">
                                        <div class="d-flex flex-column w-100">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <?php echo htmlspecialchars($notification['label']); ?>
                                                    <div class="text-muted">
                                                        <small><?php echo htmlspecialchars($notification['date']); ?></small>
                                                    </div>
                                                </div>
                                                <span class="badge ms-5 <?php echo htmlspecialchars(getBadgeClass($notification['type'])); ?> rounded-pill">
                                                    <?php echo htmlspecialchars($notification['count']); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>
            </div>
        </header>

        <main>
            <div class="container h-100 d-flex justify-content-center align-items-center">
                <div class="row">
                    <button id="githubBtn" class="btn btn-primary">Look Up GitHub User</button>
                </div>
            </div>
        </main>


    <!-- Bootstrap JS and Popper.js for Bootstrap components functionality -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- SweetAlert2 for beautiful alert popups -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Font Awesome for icon usage -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>


    <script src="./zbutton.js"></script>



</body>
</html>