<?php
require_once 'config/config.php';
require_once 'core/Database.php';
require_once 'core/Model.php';
require_once 'models/BlogPost.php';

$blogModel = new BlogPost();
$posts = $blogModel->findPublished();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Skibidi Madness</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght=400;700;900&family=Rajdhani:wght=300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <a href="index.php">
                    <span class="brand-text">SKIBIDI</span>
                    <span class="brand-subtitle">MADNESS</span>
                </a>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php#home">Home</a></li>
                <li><a href="index.php#about">About</a></li>
                <li><a href="index.php#episodes">Episodes</a></li>
                <li><a href="index.php#heroes">Heroes</a></li>
                <li><a href="blog.php" class="active">Blog</a></li>
            </ul>
        </div>
    </nav>

    <section class="blog-page">
        <div class="container">
            <div class="page-header">
                <h1>Blog & News</h1>
                <p>Latest updates from the Skibidi Madness universe</p>
            </div>

            <?php if (count($posts) > 0): ?>
            <div class="blog-grid">
                <?php foreach ($posts as $post): ?>
                <article class="blog-card">
                    <div class="blog-image">
                        <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span class="blog-author"><?php echo htmlspecialchars($post['author']); ?></span>
                            <span class="blog-date"><?php echo date('M j, Y', strtotime($post['publish_date'])); ?></span>
                        </div>
                        <h2 class="blog-title"><?php echo htmlspecialchars($post['title']); ?></h2>
                        <p class="blog-excerpt"><?php echo htmlspecialchars($post['excerpt']); ?></p>
                        <div class="blog-content-preview">
                            <?php echo nl2br(htmlspecialchars(substr($post['content'], 0, 200))); ?>...
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="no-posts">
                <p>No blog posts yet. Check back soon for updates!</p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> FireStormX Studios. All rights reserved.</p>
                <p><a href="index.php">Back to Home</a></p>
            </div>
        </div>
    </footer>
</body>
</html>
