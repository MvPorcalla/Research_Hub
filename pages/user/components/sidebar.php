<nav class="col-md-3 col-lg-3 d-md-block sidebar">
    <div class="text-center my-3">
        <h1 class="sidebar-text">Welcome, <strong id="sidebar-username"><?php echo htmlspecialchars($_SESSION['user_username']); ?></strong>!</h1>
    </div>
    <ul class="nav flex-column mx-4">
        <li class="nav-item">
            <a class="nav-link sidebar-title" id="library-link" href="./index.php">
                <i class="fas fa-book fa-xl me-3"></i> Library
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link sidebar-title" id="favorites-link" href="./favorites.php">
                <i class="fas fa-heart fa-xl me-3"></i> Favorites
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link sidebar-title" id="history-link" href="./history.php">
                <i class="fas fa-history fa-xl me-3"></i> History
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link sidebar-title" id="forum-link" href="./forum.php">
                <i class="fas fa-comments fa-xl me-3"></i> Research Hub Forum
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link sidebar-title" id="setting-link" href="./setting.php">
                <i class="fas fa-cogs fa-lg me-3"></i> Account Setting
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