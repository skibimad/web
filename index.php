<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database/Database.php';
require_once __DIR__ . '/database/models/Episode.php';
require_once __DIR__ . '/database/models/Hero.php';
require_once __DIR__ . '/database/models/BlogPost.php';
require_once __DIR__ . '/database/models/LandingContent.php';

// Fetch data from database
$episodeModel = new Episode();
$heroModel = new Hero();
$blogModel = new BlogPost();
$contentModel = new LandingContent();

$episodes = $episodeModel->getLatest(5);
$heroes = $heroModel->getAllOrdered();
$recentPosts = $blogModel->getLatest(3);

$heroContent = $contentModel->findBySection('hero');
$aboutContent = $contentModel->findBySection('about');
$channelContent = $contentModel->findBySection('channel');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Skibidi Madness - A new story and adventures from the original series by FireStormX Studios. Featuring chaos, battles, and the Supreme Leader villain across Marvel, Stranger Things, DC, Star Wars, Minecraft universes and more.">
    <meta name="keywords" content="Skibidi Toilet, Skibidi Madness, FireStormX Studios, Titan Cameraman, Titan Speakerman, Titan TV Man, G-Man, animation series, Asotra, multiverse, post-apocalyptic">
    <meta property="og:title" content="Skibidi Madness - Epic Multiverse Animation Series">
    <meta property="og:description" content="New story and adventures featuring chaos, battles across multiple universes">
    <meta property="og:image" content="res/img/all-together.png">
    <meta property="og:type" content="website">
    <title>Skibidi Madness | FireStormX Studios</title>
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
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#videos">Episodes</a></li>
                <li><a href="#heroes">Heroes</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="#channel">Channel</a></li>
            </ul>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="hero-background">
            <video autoplay muted loop playsinline class="hero-video">
                <source src="res/video/all-together.mp4" type="video/mp4">
            </video>
            <div class="hero-overlay"></div>
        </div>
        <div class="hero-content">
            <h1 class="glitch-text" data-text="<?php echo htmlspecialchars($heroContent['title'] ?? 'SKIBIDI MADNESS'); ?>">
                <span><?php echo htmlspecialchars($heroContent['title'] ?? 'SKIBIDI MADNESS'); ?></span>
            </h1>
            <p class="hero-subtitle">
                <?php echo htmlspecialchars($heroContent['subtitle'] ?? 'A New Era of Chaos Begins'); ?>
            </p>
            <p class="hero-description">
                <?php echo htmlspecialchars($heroContent['content'] ?? 'Dive into an epic multiverse where heroes unite against the forces of chaos. From the depths of the Skibidi universe to the realms of Marvel, DC, Star Wars, and beyond.'); ?>
            </p>
            <div class="hero-buttons">
                <a href="#videos" class="btn btn-primary">Watch Now</a>
                <a href="https://www.youtube.com/@FirestomX-Tri" target="_blank" class="btn btn-secondary">Subscribe</a>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="scroll-arrow"></div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <h2 class="section-title"><?php echo htmlspecialchars($aboutContent['title'] ?? 'The Story Unfolds'); ?></h2>
            <div class="about-content">
                <div class="about-text">
                    <h3><?php echo htmlspecialchars($aboutContent['subtitle'] ?? 'A New Chapter in the Skibidi Universe'); ?></h3>
                    <p>
                        Welcome to <strong>Skibidi Madness</strong> - an extraordinary animation series created by FireStormX Studios 
                        that transcends the boundaries of the original Skibidi Toilet universe. This isn't just another story; 
                        it's a revolutionary fusion of multiple dimensions, timelines, and realities.
                    </p>
                    <p>
                        In this new saga, witness the unprecedented chaos unleashed by the malevolent forces known as the 
                        <strong>Asotra</strong>. Unlike previous battles against entire armies, our heroes now face their 
                        most formidable adversary yet - the mysterious and powerful <strong>Supreme Leader</strong>, 
                        whose ambitions threaten not just one universe, but the entire multiverse fabric.
                    </p>
                    <p>
                        Skibidi Madness weaves together elements from beloved franchises including Marvel's cosmic battles, 
                        the supernatural mysteries of Stranger Things, DC's legendary heroes, the epic space opera of Star Wars, 
                        the blocky realms of Minecraft, and countless other dimensions. This is where everything you love 
                        collides in spectacular fashion.
                    </p>
                    <div class="about-stats">
                        <div class="stat-item">
                            <span class="stat-number">5</span>
                            <span class="stat-label">Legendary Heroes</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">∞</span>
                            <span class="stat-label">Universes Connected</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">1</span>
                            <span class="stat-label">Supreme Threat</span>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img src="res/img/all-together.png" alt="All Heroes Together">
                    <div class="image-glow"></div>
                </div>
            </div>
            
            <!-- Original References -->
            <div class="original-references">
                <h3>Inspired by the Original Skibidi Toilet Universe</h3>
                <p>
                    This series builds upon the creative foundation established by the original Skibidi Toilet creator.
                </p>
                <div class="reference-links">
                    <a href="https://www.youtube.com/@DaFuqBoom" target="_blank" class="ref-link">
                        <span>DaFuq!?Boom! (Original Creator)</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Episodes Section (Now before Heroes) -->
    <section id="videos" class="videos-section">
        <div class="container">
            <h2 class="section-title">Featured Episodes</h2>
            <p class="section-subtitle">
                Watch the epic battles and witness the chaos unfold
            </p>
            
            <div class="videos-grid">
                <?php foreach ($episodes as $episode): ?>
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="<?php echo htmlspecialchars($episode['thumbnail']); ?>" alt="<?php echo htmlspecialchars($episode['title']); ?>">
                        <a href="<?php echo htmlspecialchars($episode['video_url']); ?>" target="_blank" class="play-button">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="video-info">
                        <h3>Episode <?php echo $episode['episode_number']; ?>: <?php echo htmlspecialchars($episode['title']); ?></h3>
                        <p><?php echo htmlspecialchars($episode['description']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Heroes Section (Now after Episodes) -->
    <section id="heroes" class="heroes-section">
        <div class="container">
            <h2 class="section-title">The Legendary Heroes</h2>
            <p class="section-subtitle">
                Meet the champions who stand between order and absolute chaos
            </p>
            
            <div class="heroes-grid">
                <?php foreach ($heroes as $hero): 
                    $abilities = json_decode($hero['abilities'], true) ?: [];
                ?>
                <div class="hero-card" data-hero="<?php echo htmlspecialchars($hero['slug']); ?>">
                    <div class="hero-card-inner">
                        <div class="hero-image-wrapper">
                            <img src="<?php echo htmlspecialchars($hero['image']); ?>" alt="<?php echo htmlspecialchars($hero['name']); ?>" class="hero-image">
                            <?php if ($hero['video']): ?>
                            <video class="hero-video-preview" muted loop>
                                <source src="<?php echo htmlspecialchars($hero['video']); ?>" type="video/mp4">
                            </video>
                            <?php endif; ?>
                        </div>
                        <div class="hero-info">
                            <h3 class="hero-name"><?php echo htmlspecialchars($hero['name']); ?></h3>
                            <p class="hero-description">
                                <?php echo htmlspecialchars($hero['description']); ?>
                            </p>
                            <div class="hero-abilities">
                                <?php foreach ($abilities as $ability): ?>
                                <span class="ability"><?php echo htmlspecialchars($ability); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section id="blog" class="blog-preview-section">
        <div class="container">
            <h2 class="section-title">Latest News</h2>
            <p class="section-subtitle">
                Stay updated with the latest news, behind-the-scenes content, and announcements
            </p>
            
            <div class="blog-grid">
                <?php foreach ($recentPosts as $post): ?>
                <div class="blog-card">
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="blog-card-image" onerror="this.src='res/img/all-together.png'">
                    <div class="blog-card-content">
                        <h3 class="blog-card-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                        <div class="blog-card-meta">
                            <?php echo htmlspecialchars($post['author']); ?> • <?php echo date('M d, Y', strtotime($post['created_at'])); ?>
                        </div>
                        <p class="blog-card-excerpt"><?php echo htmlspecialchars($post['excerpt'] ?: substr($post['content'], 0, 150) . '...'); ?></p>
                        <a href="blog-post.php?id=<?php echo $post['id']; ?>" class="blog-card-link">Read More →</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="blog-view-all">
                <a href="blog.php" class="btn btn-primary">View All Posts</a>
            </div>
        </div>
    </section>

    <!-- Channel Section -->
    <section id="channel" class="channel-section">
        <div class="container">
            <div class="channel-content">
                <div class="channel-info">
                    <h2><?php echo htmlspecialchars($channelContent['title'] ?? 'Join the FirestomX-Tri Community'); ?></h2>
                    <p>
                        <?php echo htmlspecialchars($channelContent['content'] ?? 'Subscribe to FirestomX-Tri on YouTube to never miss an episode of Skibidi Madness! Get exclusive behind-the-scenes content, character reveals, and be part of the growing community of fans exploring the multiverse.'); ?>
                    </p>
                    <div class="channel-stats">
                        <div class="stat">
                            <span class="stat-icon">🎬</span>
                            <span>New Episodes Weekly</span>
                        </div>
                        <div class="stat">
                            <span class="stat-icon">🌟</span>
                            <span>Exclusive Content</span>
                        </div>
                        <div class="stat">
                            <span class="stat-icon">🎮</span>
                            <span>Community Events</span>
                        </div>
                    </div>
                    <a href="https://www.youtube.com/@FirestomX-Tri" target="_blank" class="btn btn-channel">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="youtube-icon">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                        <span>Subscribe Now</span>
                    </a>
                </div>
                <div class="channel-visual">
                    <video autoplay muted loop playsinline class="channel-video">
                        <source src="res/video/all-together.mp4" type="video/mp4">
                    </video>
                </div>
            </div>
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
                            <li><a href="#about">About</a></li>
                            <li><a href="#heroes">Heroes</a></li>
                            <li><a href="blog.php">Blog</a></li>
                            <li><a href="#videos">Episodes</a></li>
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
