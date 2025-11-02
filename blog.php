<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database/Database.php';
require_once __DIR__ . '/database/models/BlogPost.php';

$blogModel = new BlogPost();
$posts = $blogModel->getPublished('created_at DESC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Skibidi Madness</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <span class="logo-main">SKIBIDI</span>
                <span class="logo-sub">MADNESS</span>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php#home">Home</a></li>
                <li><a href="index.php#about">About</a></li>
                <li><a href="index.php#videos">Episodes</a></li>
                <li><a href="index.php#heroes">Heroes</a></li>
                <li><a href="blog.php" class="active">Blog</a></li>
                <li><a href="index.php#channel">Channel</a></li>
            </ul>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Blog Header -->
    <section class="blog-header-section">
        <div class="container">
            <h1 class="section-title">Blog & News</h1>
            <p class="section-subtitle">
                Latest updates, behind-the-scenes content, and announcements
            </p>
        </div>
    </section>

    <!-- Blog Posts -->
    <section class="blog-main-section">
        <div class="container">
            <?php if (empty($posts)): ?>
            <div class="no-posts-message">
                <p>No blog posts available yet. Check back soon for updates!</p>
            </div>
            <?php else: ?>
            <div class="blog-grid">
                <?php foreach ($posts as $post): ?>
                <div class="blog-card">
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" 
                         alt="<?php echo htmlspecialchars($post['title']); ?>" 
                         class="blog-card-image" 
                         onerror="this.src='res/img/all-together.png'">
                    <div class="blog-card-content">
                        <h3 class="blog-card-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                        <div class="blog-card-meta">
                            <?php echo htmlspecialchars($post['author']); ?> • 
                            <?php echo date('M d, Y', strtotime($post['created_at'])); ?>
                        </div>
                        <p class="blog-card-excerpt">
                            <?php echo htmlspecialchars($post['excerpt'] ?: substr(strip_tags($post['content']), 0, 150) . '...'); ?>
                        </p>
                        <a href="blog-post.php?slug=<?php echo urlencode($post['slug']); ?>" class="blog-card-link">Read More →</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <h3>SKIBIDI MADNESS</h3>
                    <p>Where Chaos Meets Destiny</p>
                </div>
                <div class="footer-links">
                    <div class="footer-column">
                        <h4>Community</h4>
                        <ul>
                            <li><a href="https://www.youtube.com/@FirestomX-Tri" target="_blank">YouTube</a></li>
                            <li><a href="https://www.youtube.com/@DaFuqBoom" target="_blank">Original Series</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h4>Resources</h4>
                        <ul>
                            <li><a href="index.php#about">About</a></li>
                            <li><a href="index.php#heroes">Heroes</a></li>
                            <li><a href="blog.php">Blog</a></li>
                            <li><a href="index.php#videos">Episodes</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 FireStormX Studios. All rights reserved.</p>
                <p class="footer-disclaimer">
                    Skibidi Madness is a fan-created series inspired by the Skibidi Toilet universe. 
                    Not affiliated with original creators. All trademarks belong to their respective owners.
                </p>
            </div>
        </div>
    </footer>

    <script src="scripts/main.js"></script>
</body>
</html>
