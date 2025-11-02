<nav class="admin-nav">
    <div class="admin-brand">
        <h2>SKIBIDI MADNESS</h2>
        <span>Admin Panel</span>
    </div>
    <ul class="admin-menu">
        <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">Dashboard</a></li>
        <li><a href="heroes.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'heroes.php' ? 'active' : ''; ?>">Heroes</a></li>
        <li><a href="episodes.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'episodes.php' ? 'active' : ''; ?>">Episodes</a></li>
        <li><a href="blog.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'blog.php' ? 'active' : ''; ?>">Blog</a></li>
        <li><a href="content.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'content.php' ? 'active' : ''; ?>">Content</a></li>
        <li><a href="../index.php" target="_blank">View Site</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>
