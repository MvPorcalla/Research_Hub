<?php
    // Simulated user data
    $user_name = "Shesh";
?>


<nav class="col-md-3 col-lg-3 d-md-block sidebar">
    <div class="text-center my-3">
        <h1 class="sidebar-text">Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
    </div>
    <ul class="nav flex-column text-center mx-4">
        <li class="nav-item">
            <a class="nav-link active" href="./index.php">Library</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./favorites.php">Favorites</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./history.php">History</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./forum.php">Research Hub Forum</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./setting.php">Account Setting</a>
        </li>
        
    </ul>
</nav>