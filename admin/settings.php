<?php
$pageTitle = 'Settings';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../database/models/User.php';

$userModel = new User();
$message = '';
$error = '';

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if ($currentPassword && $newPassword && $confirmPassword) {
        // Get current user
        $userId = Auth::getUserId();
        $user = $userModel->findById($userId);
        
        // Verify current password
        if (!$userModel->verifyPassword($currentPassword, $user['password'])) {
            $error = 'Current password is incorrect.';
        } elseif ($newPassword !== $confirmPassword) {
            $error = 'New passwords do not match.';
        } elseif (strlen($newPassword) < 6) {
            $error = 'New password must be at least 6 characters long.';
        } else {
            if ($userModel->changePassword($userId, $newPassword)) {
                $message = 'Password changed successfully!';
            } else {
                $error = 'Failed to change password.';
            }
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>

<h1 class="admin-title">Settings</h1>

<?php if ($message): ?>
    <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="content-card">
    <h2>Change Password</h2>
    <form method="POST">
        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" required>
        </div>
        
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" required>
            <small style="color: #888;">Must be at least 6 characters long</small>
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Change Password</button>
    </form>
</div>

<div class="content-card">
    <h2>Account Information</h2>
    <table>
        <tr>
            <td><strong>Username:</strong></td>
            <td><?php echo htmlspecialchars(Auth::getUsername()); ?></td>
        </tr>
        <tr>
            <td><strong>User ID:</strong></td>
            <td><?php echo Auth::getUserId(); ?></td>
        </tr>
    </table>
</div>

<div class="content-card">
    <h2>System Information</h2>
    <table>
        <tr>
            <td><strong>PHP Version:</strong></td>
            <td><?php echo phpversion(); ?></td>
        </tr>
        <tr>
            <td><strong>Database:</strong></td>
            <td><?php echo DB_NAME; ?> on <?php echo DB_HOST; ?></td>
        </tr>
        <tr>
            <td><strong>Upload Directory:</strong></td>
            <td><?php echo UPLOAD_DIR; ?> (<?php echo is_writable(UPLOAD_DIR) ? 'Writable' : 'Not Writable'; ?>)</td>
        </tr>
    </table>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
