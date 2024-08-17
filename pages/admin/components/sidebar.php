<?php
    // Simulated user data
    $user_name = "admin melvs";
?>


<nav class="col-md-3 col-lg-3 d-md-block sidebar">
    <div class="text-center my-3">
        <h1 class="sidebar-text">Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
    </div>
    <ul class="nav flex-column mx-4">
        <li class="nav-item mb-1">
            <a class="nav-link active" href="./index.php">Research Record</a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link" href="#">User List</a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link" href="#">LRN List</a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link" href="#">Pending Request</a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link" href="#">Settings</a>
        </li>
    </ul>
</nav>