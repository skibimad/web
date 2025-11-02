<?php
$pageTitle = 'Manage Blog';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../database/models/BlogPost.php';
require_once __DIR__ . '/../database/FileUpload.php';

$blogModel = new BlogPost();
$message = '';
$error = '';

// Helper function to create slug from title
function createSlug($title) {
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return trim($slug, '-');
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create' || $action === 'update') {
        $title = $_POST['title'] ?? '';
        $slug = $_POST['slug'] ?? createSlug($title);
        
        $data = [
            'title' => $title,
            'slug' => $slug,
            'content' => $_POST['content'] ?? '',
            'excerpt' => $_POST['excerpt'] ?? '',
            'author' => $_POST['author'] ?? 'FireStormX Studios',
            'published' => isset($_POST['published']) ? 1 : 0,
        ];
        
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploader = new FileUpload('blog');
            $result = $uploader->upload($_FILES['image']);
            if ($result['success']) {
                $data['image'] = $result['path'];
            } else {
                $error = $result['error'];
            }
        } elseif (!empty($_POST['existing_image'])) {
            $data['image'] = $_POST['existing_image'];
        }
        
        if ($action === 'create') {
            if ($blogModel->create($data)) {
                $message = 'Blog post created successfully!';
            } else {
                $error = 'Failed to create blog post.';
            }
        } else {
            $id = $_POST['id'] ?? 0;
            if ($blogModel->update($id, $data)) {
                $message = 'Blog post updated successfully!';
            } else {
                $error = 'Failed to update blog post.';
            }
        }
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? 0;
        if ($blogModel->delete($id)) {
            $message = 'Blog post deleted successfully!';
        } else {
            $error = 'Failed to delete blog post.';
        }
    }
}

// Get action from URL
$urlAction = $_GET['action'] ?? 'list';
$editId = $_GET['id'] ?? 0;

// Get post for editing
$editPost = null;
if ($urlAction === 'edit' && $editId) {
    $editPost = $blogModel->findById($editId);
}

// Get all posts
$posts = $blogModel->findAll('created_at DESC');
?>

<h1 class="admin-title">Manage Blog</h1>

<?php if ($message): ?>
    <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<?php if ($urlAction === 'new' || $urlAction === 'edit'): ?>
<div class="content-card">
    <h2><?php echo $editPost ? 'Edit Blog Post' : 'Create New Blog Post'; ?></h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="<?php echo $editPost ? 'update' : 'create'; ?>">
        <?php if ($editPost): ?>
            <input type="hidden" name="id" value="<?php echo $editPost['id']; ?>">
            <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($editPost['image'] ?? ''); ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label for="title">Title *</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($editPost['title'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="slug">Slug (URL-friendly)</label>
            <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($editPost['slug'] ?? ''); ?>">
            <small style="color: #888;">Leave empty to auto-generate from title</small>
        </div>
        
        <div class="form-group">
            <label for="excerpt">Excerpt (Short description)</label>
            <textarea id="excerpt" name="excerpt" rows="3"><?php echo htmlspecialchars($editPost['excerpt'] ?? ''); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" rows="10"><?php echo htmlspecialchars($editPost['content'] ?? ''); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="image">Featured Image</label>
            <input type="file" id="image" name="image" accept="image/*">
            <?php if ($editPost && $editPost['image']): ?>
                <img src="<?php echo htmlspecialchars($editPost['image']); ?>" alt="Current image" class="image-preview">
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($editPost['author'] ?? 'FireStormX Studios'); ?>">
        </div>
        
        <div class="form-group">
            <label>
                <input type="checkbox" name="published" value="1" <?php echo ($editPost['published'] ?? 1) ? 'checked' : ''; ?>>
                Published
            </label>
        </div>
        
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary"><?php echo $editPost ? 'Update Post' : 'Create Post'; ?></button>
            <a href="/admin/blog.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?php else: ?>
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>All Blog Posts</h2>
        <a href="/admin/blog.php?action=new" class="btn btn-primary">+ Create New Post</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
            <tr>
                <td><?php echo htmlspecialchars($post['title']); ?></td>
                <td><?php echo htmlspecialchars($post['author']); ?></td>
                <td><?php echo $post['published'] ? '✓ Published' : '✗ Draft'; ?></td>
                <td><?php echo date('M d, Y', strtotime($post['created_at'])); ?></td>
                <td class="actions">
                    <a href="/admin/blog.php?action=edit&id=<?php echo $post['id']; ?>" class="btn btn-secondary">Edit</a>
                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
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
