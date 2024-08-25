<nav id="adminSidebar" class="col-md-3 col-lg-3 d-md-block sidebar sticky-top">
    <div class="text-center my-3">
        <h1 class="sidebar-text">Welcome, <?php echo htmlspecialchars($_SESSION['user_username']); ?>!</h1>
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
            <a class="nav-link" href="./pendingRequest.php">Pending Request</a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link" href="./setting.php">Settings</a>
        </li>
    </ul>
</nav>