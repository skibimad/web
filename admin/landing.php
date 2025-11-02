<?php
$pageTitle = 'Edit Landing Page';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../database/models/LandingContent.php';

$contentModel = new LandingContent();
$message = '';
$error = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section = $_POST['section'] ?? '';
    $data = [
        'title' => $_POST['title'] ?? '',
        'subtitle' => $_POST['subtitle'] ?? '',
        'content' => $_POST['content'] ?? '',
    ];
    
    if ($contentModel->updateBySection($section, $data)) {
        $message = 'Landing page content updated successfully!';
    } else {
        $error = 'Failed to update content.';
    }
}

// Get current content for all sections
$heroContent = $contentModel->findBySection('hero') ?: [];
$aboutContent = $contentModel->findBySection('about') ?: [];
$channelContent = $contentModel->findBySection('channel') ?: [];
?>

<h1 class="admin-title">Edit Landing Page Content</h1>

<?php if ($message): ?>
    <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="content-card">
    <h2>Hero Section</h2>
    <form method="POST">
        <input type="hidden" name="section" value="hero">
        
        <div class="form-group">
            <label for="hero_title">Main Title</label>
            <input type="text" id="hero_title" name="title" value="<?php echo htmlspecialchars($heroContent['title'] ?? 'SKIBIDI MADNESS'); ?>">
        </div>
        
        <div class="form-group">
            <label for="hero_subtitle">Subtitle</label>
            <input type="text" id="hero_subtitle" name="subtitle" value="<?php echo htmlspecialchars($heroContent['subtitle'] ?? 'A New Era of Chaos Begins'); ?>">
        </div>
        
        <div class="form-group">
            <label for="hero_content">Description</label>
            <textarea id="hero_content" name="content"><?php echo htmlspecialchars($heroContent['content'] ?? ''); ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Hero Section</button>
    </form>
</div>

<div class="content-card">
    <h2>About Section</h2>
    <form method="POST">
        <input type="hidden" name="section" value="about">
        
        <div class="form-group">
            <label for="about_title">Section Title</label>
            <input type="text" id="about_title" name="title" value="<?php echo htmlspecialchars($aboutContent['title'] ?? 'The Story Unfolds'); ?>">
        </div>
        
        <div class="form-group">
            <label for="about_subtitle">Subtitle</label>
            <input type="text" id="about_subtitle" name="subtitle" value="<?php echo htmlspecialchars($aboutContent['subtitle'] ?? 'A New Chapter in the Skibidi Universe'); ?>">
        </div>
        
        <div class="form-group">
            <label for="about_content">Content</label>
            <textarea id="about_content" name="content" rows="6"><?php echo htmlspecialchars($aboutContent['content'] ?? ''); ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Update About Section</button>
    </form>
</div>

<div class="content-card">
    <h2>Channel Section</h2>
    <form method="POST">
        <input type="hidden" name="section" value="channel">
        
        <div class="form-group">
            <label for="channel_title">Section Title</label>
            <input type="text" id="channel_title" name="title" value="<?php echo htmlspecialchars($channelContent['title'] ?? 'Join the FirestomX-Tri Community'); ?>">
        </div>
        
        <div class="form-group">
            <label for="channel_subtitle">Subtitle</label>
            <input type="text" id="channel_subtitle" name="subtitle" value="<?php echo htmlspecialchars($channelContent['subtitle'] ?? 'Subscribe to our channel'); ?>">
        </div>
        
        <div class="form-group">
            <label for="channel_content">Description</label>
            <textarea id="channel_content" name="content" rows="4"><?php echo htmlspecialchars($channelContent['content'] ?? ''); ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Channel Section</button>
    </form>
</div>

<div class="content-card">
    <h2>Notes</h2>
    <p>The landing page content is used on the main homepage. Changes made here will be reflected immediately.</p>
    <p>For images and videos, these are currently managed through the file system in the <code>res/</code> directory.</p>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
