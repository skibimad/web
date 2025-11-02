<?php
require_once '../config/config.php';
require_once '../core/Database.php';
require_once '../core/Security.php';
require_once '../core/Model.php';
require_once '../models/Hero.php';
require_once '../models/Episode.php';
require_once '../models/BlogPost.php';
require_once '../models/User.php';

Security::requireAuth();

$heroModel = new Hero();
$episodeModel = new Episode();
$blogModel = new BlogPost();

$heroCount = $heroModel->count();
$episodeCount = $episodeModel->count();
$blogCount = $blogModel->count();

// Handle password change
$passwordMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'change_password') {
    if (Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if ($newPassword === $confirmPassword) {
            $userModel = new User();
            $user = $userModel->findById($_SESSION['user_id']);
            
            if ($user && Security::verifyPassword($currentPassword, $user['password'])) {
                if ($userModel->updatePassword($_SESSION['user_id'], $newPassword)) {
                    $passwordMessage = 'Password changed successfully!';
                } else {
                    $passwordMessage = 'Error updating password';
                }
            } else {
                $passwordMessage = 'Current password is incorrect';
            }
        } else {
            $passwordMessage = 'New passwords do not match';
        }
    }
}

$csrfToken = Security::generateCsrfToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Skibidi Madness</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght=400;700;900&family=Rajdhani:wght=300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include 'views/_nav.php'; ?>
        
        <main class="admin-content">
            <div class="page-header">
                <h1>Admin Dashboard</h1>
                <p>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            </div>

            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <div class="card-icon">🦸</div>
                    <div class="card-content">
                        <h3>Heroes</h3>
                        <div class="card-number"><?php echo $heroCount; ?></div>
                        <a href="heroes.php" class="card-link">Manage Heroes →</a>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-icon">🎬</div>
                    <div class="card-content">
                        <h3>Episodes</h3>
                        <div class="card-number"><?php echo $episodeCount; ?></div>
                        <a href="episodes.php" class="card-link">Manage Episodes →</a>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-icon">📝</div>
                    <div class="card-content">
                        <h3>Blog Posts</h3>
                        <div class="card-number"><?php echo $blogCount; ?></div>
                        <a href="blog.php" class="card-link">Manage Blog →</a>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-icon">✏️</div>
                    <div class="card-content">
                        <h3>Static Content</h3>
                        <div class="card-number">Editor</div>
                        <a href="content.php" class="card-link">Edit Content →</a>
                    </div>
                </div>
            </div>

            <div class="admin-section">
                <h2>Quick Actions</h2>
                <div class="button-group">
                    <a href="heroes.php?action=new" class="btn btn-primary">+ Add Hero</a>
                    <a href="episodes.php?action=new" class="btn btn-primary">+ Add Episode</a>
                    <a href="blog.php?action=new" class="btn btn-primary">+ Write Post</a>
                    <a href="content.php" class="btn btn-secondary">Edit Landing Page</a>
                </div>
            </div>

            <div class="admin-section">
                <h2>Change Password</h2>
                <?php if ($passwordMessage): ?>
                <div class="message <?php echo strpos($passwordMessage, 'success') !== false ? 'success' : 'error'; ?>">
                    <?php echo htmlspecialchars($passwordMessage); ?>
                </div>
                <?php endif; ?>
                <form method="POST" class="password-form">
                    <input type="hidden" name="action" value="change_password">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="confirm_password" required minlength="6">
                    </div>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            </div>

            <div class="admin-section">
                <h2>System Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">PHP Version:</span>
                        <span class="info-value"><?php echo phpversion(); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Database:</span>
                        <span class="info-value">SQLite</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Session Timeout:</span>
                        <span class="info-value">24 hours</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Max Upload:</span>
                        <span class="info-value">10MB</span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
