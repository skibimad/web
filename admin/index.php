<?php
$pageTitle = 'Dashboard';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../database/models/Hero.php';
require_once __DIR__ . '/../database/models/Episode.php';
require_once __DIR__ . '/../database/models/BlogPost.php';

$heroModel = new Hero();
$episodeModel = new Episode();
$blogModel = new BlogPost();

$heroCount = $heroModel->count();
$episodeCount = $episodeModel->count();
$blogCount = $blogModel->count();
?>

<h1 class="admin-title">Dashboard</h1>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 40px;">
    <div class="content-card" style="text-align: center;">
        <div style="font-size: 3em; margin-bottom: 10px;">📺</div>
        <h3 style="color: #00ffcc; margin-bottom: 10px;">Episodes</h3>
        <p style="font-size: 2.5em; font-weight: 700; color: #ff3366; margin-bottom: 15px;"><?php echo $episodeCount; ?></p>
        <a href="/admin/episodes.php" class="btn btn-primary">Manage Episodes</a>
    </div>
    
    <div class="content-card" style="text-align: center;">
        <div style="font-size: 3em; margin-bottom: 10px;">🦸</div>
        <h3 style="color: #00ffcc; margin-bottom: 10px;">Heroes</h3>
        <p style="font-size: 2.5em; font-weight: 700; color: #ff3366; margin-bottom: 15px;"><?php echo $heroCount; ?></p>
        <a href="/admin/heroes.php" class="btn btn-primary">Manage Heroes</a>
    </div>
    
    <div class="content-card" style="text-align: center;">
        <div style="font-size: 3em; margin-bottom: 10px;">📝</div>
        <h3 style="color: #00ffcc; margin-bottom: 10px;">Blog Posts</h3>
        <p style="font-size: 2.5em; font-weight: 700; color: #ff3366; margin-bottom: 15px;"><?php echo $blogCount; ?></p>
        <a href="/admin/blog.php" class="btn btn-primary">Manage Blog</a>
    </div>
</div>

<div class="content-card">
    <h2 style="color: #00ffcc; margin-bottom: 20px;">Quick Actions</h2>
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="/admin/episodes.php?action=new" class="btn btn-secondary">Add New Episode</a>
        <a href="/admin/heroes.php?action=new" class="btn btn-secondary">Add New Hero</a>
        <a href="/admin/blog.php?action=new" class="btn btn-secondary">Write Blog Post</a>
        <a href="/admin/landing.php" class="btn btn-secondary">Edit Landing Page</a>
        <a href="/admin/settings.php" class="btn btn-secondary">Change Password</a>
    </div>
</div>

<div class="content-card">
    <h2 style="color: #00ffcc; margin-bottom: 20px;">System Information</h2>
    <table>
        <tr>
            <td><strong>Username:</strong></td>
            <td><?php echo htmlspecialchars(Auth::getUsername()); ?></td>
        </tr>
        <tr>
            <td><strong>PHP Version:</strong></td>
            <td><?php echo phpversion(); ?></td>
        </tr>
        <tr>
            <td><strong>Database:</strong></td>
            <td>MySQL (<?php echo DB_NAME; ?>)</td>
        </tr>
        <tr>
            <td><strong>Upload Directory:</strong></td>
            <td><?php echo is_writable(UPLOAD_DIR) ? '✓ Writable' : '✗ Not Writable'; ?></td>
        </tr>
    </table>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
