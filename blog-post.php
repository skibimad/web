<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database/Database.php';
require_once __DIR__ . '/database/models/BlogPost.php';

$blogModel = new BlogPost();

// Get post by slug or ID
$slug = $_GET['slug'] ?? '';
$id = $_GET['id'] ?? 0;

if ($slug) {
    $post = $blogModel->findBySlug($slug);
} elseif ($id) {
    $post = $blogModel->findById($id);
} else {
    header('Location: blog.php');
    exit();
}

if (!$post || !$post['published']) {
    header('Location: blog.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - Skibidi Madness</title>
    <meta name="description" content="<?php echo htmlspecialchars($post['excerpt'] ?: substr(strip_tags($post['content']), 0, 155)); ?>">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .blog-post-container {
            max-width: 900px;
            margin: 80px auto 60px;
            padding: 0 20px;
        }
        
        .blog-post-header {
            margin-bottom: 40px;
        }
        
        .blog-post-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.5em;
            color: #ff3366;
            margin-bottom: 20px;
        }
        
        .blog-post-meta {
            color: #00ffcc;
            font-size: 1.1em;
            margin-bottom: 30px;
        }
        
        .blog-post-image {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 40px;
        }
        
        .blog-post-content {
            font-size: 1.2em;
            line-height: 1.8;
            color: #fff;
        }
        
        .blog-post-content p {
            margin-bottom: 20px;
        }
        
        .blog-post-content h2 {
            color: #ff3366;
            font-family: 'Orbitron', sans-serif;
            margin: 40px 0 20px;
        }
        
        .blog-post-content h3 {
            color: #00ffcc;
            font-family: 'Orbitron', sans-serif;
            margin: 30px 0 15px;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 30px;
            color: #00ffcc;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .back-link:hover {
            color: #fff;
        }
    </style>
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
                <li><a href="blog.php">Blog</a></li>
                <li><a href="index.php#channel">Channel</a></li>
            </ul>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Blog Post -->
    <div class="blog-post-container">
        <a href="blog.php" class="back-link">← Back to Blog</a>
        
        <article class="blog-post-header">
            <h1 class="blog-post-title"><?php echo htmlspecialchars($post['title']); ?></h1>
            <div class="blog-post-meta">
                By <?php echo htmlspecialchars($post['author']); ?> • 
                <?php echo date('F d, Y', strtotime($post['created_at'])); ?>
            </div>
        </article>
        
        <?php if ($post['image']): ?>
        <img src="<?php echo htmlspecialchars($post['image']); ?>" 
             alt="<?php echo htmlspecialchars($post['title']); ?>" 
             class="blog-post-image"
             onerror="this.src='res/img/all-together.png'">
        <?php endif; ?>
        
        <div class="blog-post-content">
            <?php echo nl2br(htmlspecialchars($post['content'])); ?>
        </div>
        
        <div style="margin-top: 60px;">
            <a href="blog.php" class="btn btn-primary">← Back to Blog</a>
        </div>
    </div>

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
