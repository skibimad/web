<?php
$pageTitle = 'Manage Episodes';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../database/models/Episode.php';
require_once __DIR__ . '/../database/FileUpload.php';

$episodeModel = new Episode();
$message = '';
$error = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create' || $action === 'update') {
        $data = [
            'episode_number' => $_POST['episode_number'] ?? 0,
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'video_url' => $_POST['video_url'] ?? '',
            'duration' => $_POST['duration'] ?? '',
            'release_date' => $_POST['release_date'] ?? date('Y-m-d'),
        ];
        
        // Handle thumbnail upload
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $uploader = new FileUpload('episodes');
            $result = $uploader->upload($_FILES['thumbnail']);
            if ($result['success']) {
                $data['thumbnail'] = $result['path'];
            } else {
                $error = $result['error'];
            }
        } elseif (!empty($_POST['existing_thumbnail'])) {
            $data['thumbnail'] = $_POST['existing_thumbnail'];
        }
        
        if ($action === 'create') {
            if ($episodeModel->create($data)) {
                $message = 'Episode created successfully!';
            } else {
                $error = 'Failed to create episode.';
            }
        } else {
            $id = $_POST['id'] ?? 0;
            if ($episodeModel->update($id, $data)) {
                $message = 'Episode updated successfully!';
            } else {
                $error = 'Failed to update episode.';
            }
        }
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? 0;
        if ($episodeModel->delete($id)) {
            $message = 'Episode deleted successfully!';
        } else {
            $error = 'Failed to delete episode.';
        }
    }
}

// Get action from URL
$urlAction = $_GET['action'] ?? 'list';
$editId = $_GET['id'] ?? 0;

// Get episode for editing
$editEpisode = null;
if ($urlAction === 'edit' && $editId) {
    $editEpisode = $episodeModel->findById($editId);
}

// Get all episodes
$episodes = $episodeModel->getAllOrdered();
?>

<h1 class="admin-title">Manage Episodes</h1>

<?php if ($message): ?>
    <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<?php if ($urlAction === 'new' || $urlAction === 'edit'): ?>
<div class="content-card">
    <h2><?php echo $editEpisode ? 'Edit Episode' : 'Add New Episode'; ?></h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="<?php echo $editEpisode ? 'update' : 'create'; ?>">
        <?php if ($editEpisode): ?>
            <input type="hidden" name="id" value="<?php echo $editEpisode['id']; ?>">
            <input type="hidden" name="existing_thumbnail" value="<?php echo htmlspecialchars($editEpisode['thumbnail'] ?? ''); ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label for="episode_number">Episode Number *</label>
            <input type="number" id="episode_number" name="episode_number" value="<?php echo $editEpisode['episode_number'] ?? ''; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="title">Title *</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($editEpisode['title'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description"><?php echo htmlspecialchars($editEpisode['description'] ?? ''); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="thumbnail">Thumbnail Image</label>
            <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
            <?php if ($editEpisode && $editEpisode['thumbnail']): ?>
                <img src="<?php echo htmlspecialchars($editEpisode['thumbnail']); ?>" alt="Current thumbnail" class="image-preview">
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="video_url">Video URL</label>
            <input type="url" id="video_url" name="video_url" value="<?php echo htmlspecialchars($editEpisode['video_url'] ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label for="duration">Duration (e.g., 10:30)</label>
            <input type="text" id="duration" name="duration" value="<?php echo htmlspecialchars($editEpisode['duration'] ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label for="release_date">Release Date</label>
            <input type="date" id="release_date" name="release_date" value="<?php echo $editEpisode['release_date'] ?? date('Y-m-d'); ?>">
        </div>
        
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary"><?php echo $editEpisode ? 'Update Episode' : 'Create Episode'; ?></button>
            <a href="/admin/episodes.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?php else: ?>
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>All Episodes</h2>
        <a href="/admin/episodes.php?action=new" class="btn btn-primary">+ Add New Episode</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Duration</th>
                <th>Release Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($episodes as $episode): ?>
            <tr>
                <td><?php echo $episode['episode_number']; ?></td>
                <td><?php echo htmlspecialchars($episode['title']); ?></td>
                <td><?php echo htmlspecialchars($episode['duration'] ?? 'N/A'); ?></td>
                <td><?php echo date('M d, Y', strtotime($episode['release_date'])); ?></td>
                <td class="actions">
                    <a href="/admin/episodes.php?action=edit&id=<?php echo $episode['id']; ?>" class="btn btn-secondary">Edit</a>
                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this episode?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $episode['id']; ?>">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
