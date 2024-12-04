<nav class="col-md-3 col-lg-3 d-md-block sidebar" id="adminSidebar">
    <div class="text-center my-3">
        <h1 class="sidebar-text">Welcome, <strong id="sidebar-username"><?php echo htmlspecialchars($_SESSION['user_username']); ?></strong>!</h1>
    </div>
    <ul class="nav flex-column mx-4">
        <li class="nav-item mb-1">
            <a class="nav-link sidebar-title" href="./index.php">
                <i class="fas fa-book fa-xl me-3"></i> Research Record
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link sidebar-title" href="./listUser.php">
                <i class="fas fa-users fa-xl me-3"></i> User List
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link sidebar-title" href="./listLRN.php">
                <i class="fas fa-id-card fa-xl me-3"></i> LRN & Employee No. Lists
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link sidebar-title" href="./listEmployeeNos.php">
                <i class="fas fa-briefcase fa-xl me-3"></i> Employee Numbers List
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link sidebar-title" href="./forum.php">
                <i class="fas fa-comments fa-xl me-3"></i> Research Hub Forum
            </a>
        </li>
        <li class="nav-item mb-1 position-relative">
            <a class="nav-link sidebar-title" href="./pendingRequest.php">
                <i class="fas fa-hourglass-half fa-xl me-3"></i> Pending Request
            </a>
            <span id="pendingCount" class="badge rounded-pill bg-danger position-absolute" style="top: 6px; left: 93%;"></span>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link sidebar-title" href="./setting.php">
                <i class="fas fa-cogs fa-xl me-3"></i> Account Settings
            </a>
        </li>
    </ul>
</nav>


<script>
    // Get all the links in the sidebar
    const sidebarLinks = document.querySelectorAll('.sidebar a');

    // Get the current page's path (excluding domain)
    const currentPath = window.location.pathname;

    // Loop through each link and add the 'active' class to the one that matches the current page
    sidebarLinks.forEach(link => {
        if (link.href.includes(currentPath)) {
            link.classList.add('active');
        }
    });
</script>