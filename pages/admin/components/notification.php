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

<!-- Dropdown Notification Button -->
<div class="dropdown notification" id="notification">
    <a class="dropdown-toggle dropdown-start d-flex align-items-center position-relative" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-bell fs-5"></i>
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