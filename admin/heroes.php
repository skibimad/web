<?php
$pageTitle = 'Manage Heroes';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../database/models/Hero.php';
require_once __DIR__ . '/../database/FileUpload.php';

$heroModel = new Hero();
$message = '';
$error = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create' || $action === 'update') {
        $abilities = array_filter(array_map('trim', explode(',', $_POST['abilities'] ?? '')));
        
        $data = [
            'slug' => $_POST['slug'] ?? '',
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'abilities' => json_encode($abilities),
            'display_order' => $_POST['display_order'] ?? 0,
        ];
        
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploader = new FileUpload('heroes');
            $result = $uploader->upload($_FILES['image']);
            if ($result['success']) {
                $data['image'] = $result['path'];
            } else {
                $error = $result['error'];
            }
        } elseif (!empty($_POST['existing_image'])) {
            $data['image'] = $_POST['existing_image'];
        }
        
        // Handle video upload/path
        if (!empty($_POST['video'])) {
            $data['video'] = $_POST['video'];
        } elseif (!empty($_POST['existing_video'])) {
            $data['video'] = $_POST['existing_video'];
        }
        
        if ($action === 'create') {
            if ($heroModel->create($data)) {
                $message = 'Hero created successfully!';
            } else {
                $error = 'Failed to create hero.';
            }
        } else {
            $id = $_POST['id'] ?? 0;
            if ($heroModel->update($id, $data)) {
                $message = 'Hero updated successfully!';
            } else {
                $error = 'Failed to update hero.';
            }
        }
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? 0;
        if ($heroModel->delete($id)) {
            $message = 'Hero deleted successfully!';
        } else {
            $error = 'Failed to delete hero.';
        }
    }
}

// Get action from URL
$urlAction = $_GET['action'] ?? 'list';
$editId = $_GET['id'] ?? 0;

// Get hero for editing
$editHero = null;
if ($urlAction === 'edit' && $editId) {
    $editHero = $heroModel->findById($editId);
    if ($editHero && $editHero['abilities']) {
        $editHero['abilities_text'] = implode(', ', json_decode($editHero['abilities'], true));
    }
}

// Get all heroes
$heroes = $heroModel->getAllOrdered();
?>

<h1 class="admin-title">Manage Heroes</h1>

<?php if ($message): ?>
    <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<?php if ($urlAction === 'new' || $urlAction === 'edit'): ?>
<div class="content-card">
    <h2><?php echo $editHero ? 'Edit Hero' : 'Add New Hero'; ?></h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="<?php echo $editHero ? 'update' : 'create'; ?>">
        <?php if ($editHero): ?>
            <input type="hidden" name="id" value="<?php echo $editHero['id']; ?>">
            <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($editHero['image'] ?? ''); ?>">
            <input type="hidden" name="existing_video" value="<?php echo htmlspecialchars($editHero['video'] ?? ''); ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label for="name">Hero Name *</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($editHero['name'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="slug">Slug (URL-friendly name) *</label>
            <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($editHero['slug'] ?? ''); ?>" required>
            <small style="color: #888;">e.g., titan-camera, g-man</small>
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description"><?php echo htmlspecialchars($editHero['description'] ?? ''); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="image">Hero Image</label>
            <input type="file" id="image" name="image" accept="image/*">
            <?php if ($editHero && $editHero['image']): ?>
                <img src="<?php echo htmlspecialchars($editHero['image']); ?>" alt="Current image" class="image-preview">
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="video">Video Path</label>
            <input type="text" id="video" name="video" value="<?php echo htmlspecialchars($editHero['video'] ?? ''); ?>">
            <small style="color: #888;">e.g., res/video/heroes/promo/hero-name.mp4</small>
        </div>
        
        <div class="form-group">
            <label for="abilities">Abilities (comma-separated)</label>
            <input type="text" id="abilities" name="abilities" value="<?php echo htmlspecialchars($editHero['abilities_text'] ?? ''); ?>">
            <small style="color: #888;">e.g., Tactical Vision, Heavy Artillery, Combat Analysis</small>
        </div>
        
        <div class="form-group">
            <label for="display_order">Display Order</label>
            <input type="number" id="display_order" name="display_order" value="<?php echo $editHero['display_order'] ?? 0; ?>">
        </div>
        
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary"><?php echo $editHero ? 'Update Hero' : 'Create Hero'; ?></button>
            <a href="/admin/heroes.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?php else: ?>
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>All Heroes</h2>
        <a href="/admin/heroes.php?action=new" class="btn btn-primary">+ Add New Hero</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Order</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($heroes as $hero): ?>
            <tr>
                <td><?php echo $hero['display_order']; ?></td>
                <td><?php echo htmlspecialchars($hero['name']); ?></td>
                <td><?php echo htmlspecialchars($hero['slug']); ?></td>
                <td>
                    <?php if ($hero['image']): ?>
                        <img src="<?php echo htmlspecialchars($hero['image']); ?>" alt="<?php echo htmlspecialchars($hero['name']); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <a href="/admin/heroes.php?action=edit&id=<?php echo $hero['id']; ?>" class="btn btn-secondary">Edit</a>
                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this hero?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $hero['id']; ?>">
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
