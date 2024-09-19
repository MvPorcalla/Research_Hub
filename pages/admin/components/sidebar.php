<nav class="col-md-3 col-lg-3 d-md-block sidebar" id="adminSidebar">
    <div class="text-center my-3">
        <h1 class="sidebar-text">Welcome, <strong id="sidebar-username"><?php echo htmlspecialchars($_SESSION['user_username']); ?></strong>!</h1>
    </div>
    <ul class="nav flex-column mx-4 text-center">
        <li class="nav-item mb-1">
            <a class="nav-link active" href="./index.php">Research Record</a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link" href="./listUser.php">User List</a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link" href="./listLRN.php">LRN List</a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link" href="./forum.php">Research Hub Forum </a>
        </li>
        <li class="nav-item mb-1 position-relative">
            <a class="nav-link" href="./pendingRequest.php">Pending Request</a>
            <span id="pendingCount" class="badge rounded-pill bg-danger position-absolute" style="top: 6px; left: 93%;"></span>
        </li>

        <li class="nav-item mb-1">
            <a class="nav-link" href="./setting.php">Account Settings</a>
        </li>
    </ul>
</nav>
