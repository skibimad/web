<?php
/**
 * Skibidi Madness - Main Landing Page
 * English Only - Dynamic Content from SQLite Database
 */

require_once 'config/config.php';
require_once 'core/Database.php';
require_once 'core/Model.php';
require_once 'models/Hero.php';
require_once 'models/Episode.php';
require_once 'models/BlogPost.php';
require_once 'models/StaticContent.php';

// Load data from database
$heroModel = new Hero();
$episodeModel = new Episode();
$blogModel = new BlogPost();
$contentModel = new StaticContent();

$heroes = $heroModel->findAll();
$episodes = $episodeModel->findAll();
$blogPosts = $blogModel->findPublished(3); // First 3 posts
$content = $contentModel->getAllAsKeyValue();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Skibidi Madness - A new era of chaos begins. Epic multiverse saga where heroes unite against the Asotra forces.">
    <meta name="keywords" content="Skibidi Toilet, Skibidi Madness, Animation, Multiverse, FireStormX Studios">
    <meta property="og:title" content="Skibidi Madness - A New Era of Chaos Begins">
    <meta property="og:description" content="Epic multiverse where heroes unite against chaos">
    <meta property="og:type" content="website">
    <title><?php echo htmlspecialchars($content['hero_title'] ?? 'SKIBIDI MADNESS'); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <span class="brand-text"><?php echo htmlspecialchars($content['hero_title'] ?? 'SKIBIDI'); ?></span>
                <span class="brand-subtitle">MADNESS</span>
            </div>
            <button class="mobile-menu-toggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <ul class="nav-menu">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#episodes">Episodes</a></li>
                <li><a href="#heroes">Heroes</a></li>
                <li><a href="#blog">Blog</a></li>
                <li><a href="#channel">Channel</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <video class="hero-video" autoplay muted loop playsinline>
            <source src="<?php echo htmlspecialchars($content['hero_video'] ?? 'res/video/all-together.mp4'); ?>" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title glitch" data-text="<?php echo htmlspecialchars($content['hero_title'] ?? 'SKIBIDI MADNESS'); ?>">
                <?php echo htmlspecialchars($content['hero_title'] ?? 'SKIBIDI MADNESS'); ?>
            </h1>
            <h2 class="hero-subtitle"><?php echo htmlspecialchars($content['hero_subtitle'] ?? 'A New Era of Chaos Begins'); ?></h2>
            <p class="hero-description"><?php echo htmlspecialchars($content['hero_description'] ?? 'Dive into an epic multiverse where heroes unite against the forces of chaos.'); ?></p>
            <div class="hero-buttons">
                <a href="https://www.youtube.com/@FireStormX" target="_blank" class="btn btn-primary">Watch Now</a>
                <a href="https://www.youtube.com/@FireStormX?sub_confirmation=1" target="_blank" class="btn btn-secondary">Subscribe</a>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="mouse"></div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php echo htmlspecialchars($content['about_title'] ?? 'The Story of Skibidi Madness'); ?></h2>
                <p class="section-subtitle"><?php echo htmlspecialchars($content['about_subtitle'] ?? 'Where Chaos Meets Destiny'); ?></p>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <p><?php echo nl2br(htmlspecialchars($content['about_paragraph1'] ?? '')); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($content['about_paragraph2'] ?? '')); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($content['about_paragraph3'] ?? '')); ?></p>
                </div>
                <div class="about-image">
                    <img src="<?php echo htmlspecialchars($content['about_image'] ?? 'res/img/all-together.png'); ?>" alt="Heroes Together">
                </div>
            </div>
            <div class="about-stats">
                <div class="stat-item">
                    <div class="stat-number"><?php echo count($heroes); ?></div>
                    <div class="stat-label">Heroes</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo count($episodes); ?></div>
                    <div class="stat-label">Episodes</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">∞</div>
                    <div class="stat-label">Universes</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Episodes Section (BEFORE Heroes per requirements) -->
    <section id="episodes" class="episodes-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Featured Episodes</h2>
                <p class="section-subtitle">Watch the Epic Saga Unfold</p>
            </div>
            <div class="episodes-grid">
                <?php foreach ($episodes as $episode): ?>
                <div class="episode-card">
                    <div class="episode-thumbnail">
                        <img src="<?php echo htmlspecialchars($episode['thumbnail_path']); ?>" alt="<?php echo htmlspecialchars($episode['title']); ?>">
                        <div class="episode-number">EP <?php echo $episode['episode_number']; ?></div>
                        <div class="episode-play">
                            <a href="<?php echo htmlspecialchars($episode['youtube_url']); ?>" target="_blank" class="play-button">▶</a>
                        </div>
                    </div>
                    <div class="episode-info">
                        <h3 class="episode-title"><?php echo htmlspecialchars($episode['title']); ?></h3>
                        <p class="episode-description"><?php echo htmlspecialchars($episode['description']); ?></p>
                        <div class="episode-meta">
                            <span class="episode-duration">⏱ <?php echo htmlspecialchars($episode['duration']); ?></span>
                            <span class="episode-date">📅 <?php echo date('M j, Y', strtotime($episode['release_date'])); ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Heroes Section (AFTER Episodes per requirements) -->
    <section id="heroes" class="heroes-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Meet the Heroes</h2>
                <p class="section-subtitle">Warriors of the Multiverse</p>
            </div>
            <div class="heroes-grid">
                <?php foreach ($heroes as $hero): ?>
                <div class="hero-card">
                    <div class="hero-media">
                        <img src="<?php echo htmlspecialchars($hero['image_path']); ?>" alt="<?php echo htmlspecialchars($hero['name']); ?>" class="hero-image">
                        <video class="hero-video-preview" muted loop>
                            <source src="<?php echo htmlspecialchars($hero['video_path']); ?>" type="video/mp4">
                        </video>
                    </div>
                    <div class="hero-info">
                        <h3 class="hero-name"><?php echo htmlspecialchars($hero['name']); ?></h3>
                        <p class="hero-description"><?php echo htmlspecialchars($hero['description']); ?></p>
                        <div class="hero-abilities">
                            <span class="ability"><?php echo htmlspecialchars($hero['ability1']); ?></span>
                            <span class="ability"><?php echo htmlspecialchars($hero['ability2']); ?></span>
                            <span class="ability"><?php echo htmlspecialchars($hero['ability3']); ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <?php if (count($blogPosts) > 0): ?>
    <section id="blog" class="blog-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Latest News</h2>
                <p class="section-subtitle">Updates from the Multiverse</p>
            </div>
            <div class="blog-grid">
                <?php foreach ($blogPosts as $post): ?>
                <article class="blog-card">
                    <div class="blog-image">
                        <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span class="blog-author"><?php echo htmlspecialchars($post['author']); ?></span>
                            <span class="blog-date"><?php echo date('M j, Y', strtotime($post['publish_date'])); ?></span>
                        </div>
                        <h3 class="blog-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                        <p class="blog-excerpt"><?php echo htmlspecialchars($post['excerpt']); ?></p>
                        <a href="blog-post.php?slug=<?php echo urlencode($post['slug']); ?>" class="blog-read-more">Read More →</a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <div class="section-footer">
                <a href="blog.php" class="btn btn-secondary">View All Posts</a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Channel Section -->
    <section id="channel" class="channel-section">
        <div class="container">
            <div class="channel-content">
                <div class="channel-info">
                    <h2 class="channel-title">Join the Madness</h2>
                    <p class="channel-description">Subscribe to FireStormX Studios for new episodes, behind-the-scenes content, and exclusive updates from the Skibidi Madness universe.</p>
                    <div class="channel-stats">
                        <div class="stat-badge">
                            <span class="stat-icon">🎬</span>
                            <span class="stat-text">New Episodes Weekly</span>
                        </div>
                        <div class="stat-badge">
                            <span class="stat-icon">🌟</span>
                            <span class="stat-text">Exclusive Content</span>
                        </div>
                        <div class="stat-badge">
                            <span class="stat-icon">👥</span>
                            <span class="stat-text">Growing Community</span>
                        </div>
                    </div>
                    <a href="https://www.youtube.com/@FireStormX?sub_confirmation=1" target="_blank" class="btn btn-youtube">
                        <span class="youtube-icon">▶</span> Subscribe on YouTube
                    </a>
                </div>
                <div class="channel-video">
                    <div class="video-placeholder">
                        <a href="https://www.youtube.com/@FireStormX" target="_blank">
                            <img src="res/img/all-together.png" alt="Watch on YouTube">
                            <div class="play-overlay">▶</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Inspired By Section (Simplified - Only Original Creator per requirements) -->
    <section class="inspired-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Inspired by the Original Skibidi Toilet Universe</h2>
            </div>
            <div class="inspired-content">
                <a href="https://www.youtube.com/@DaFuqBoom" target="_blank" class="creator-link">
                    <div class="creator-card">
                        <div class="creator-icon">🎬</div>
                        <div class="creator-info">
                            <h3 class="creator-name">DaFuq!?Boom!</h3>
                            <p class="creator-role">Original Creator</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <h3>SKIBIDI MADNESS</h3>
                    <p>A FireStormX Studios Production</p>
                </div>
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#episodes">Episodes</a></li>
                        <li><a href="#heroes">Heroes</a></li>
                        <li><a href="blog.php">Blog</a></li>
                    </ul>
                </div>
                <div class="footer-social">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="https://www.youtube.com/@FireStormX" target="_blank" aria-label="YouTube">▶ YouTube</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> FireStormX Studios. All rights reserved.</p>
                <p class="disclaimer">Fan-made series inspired by the original Skibidi Toilet universe by DaFuq!?Boom!</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="scripts/main.js"></script>
</body>
</html>
