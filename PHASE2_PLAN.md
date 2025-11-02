# Phase 2 Implementation Plan - View Templates

## Status: Architecture Complete, Views In Progress

### ✅ Completed (Phase 1)

1. **Core MVC Framework**
   - Application bootstrap with autoloader
   - Router with middleware support
   - Request/Response wrappers
   - View rendering engine
   - Base Controller and Model classes

2. **Controllers (9 total)**
   - HomeController - Landing page
   - BlogController - Blog pages
   - AuthController - Login/logout
   - DashboardController - Admin dashboard
   - HeroController - CRUD for heroes
   - EpisodeController - CRUD for episodes
   - BlogAdminController - CRUD for blog posts
   - ContentController - Static content editor
   - UploadController - File uploads

3. **Models (5 total)**
   - User - Admin authentication
   - Hero - Hero characters
   - Episode - Episodes
   - BlogPost - Blog posts
   - StaticContent - Editable content

4. **Routing & URL Rewriting**
   - Single entry point (public/index.php)
   - SEO-friendly URLs via .htaccess
   - Centralized route configuration
   - Auth middleware

5. **Directory Structure**
   - Proper MVC separation
   - Public web root
   - Assets organization
   - Secure file structure

### 🔄 In Progress (Phase 2)

**View Templates Need to be Created:**

#### Layouts
- [ ] `app/Views/layouts/main.php` - Main site layout
- [ ] `app/Views/layouts/admin.php` - Admin panel layout

#### Public Pages
- [ ] `app/Views/home/index.php` - Landing page
- [ ] `app/Views/blog/index.php` - Blog listing
- [ ] `app/Views/blog/show.php` - Single blog post

#### Admin Pages
- [ ] `app/Views/admin/login.php` - Login page
- [ ] `app/Views/admin/dashboard.php` - Dashboard
- [ ] `app/Views/admin/heroes/index.php` - Heroes list
- [ ] `app/Views/admin/heroes/form.php` - Add/Edit hero
- [ ] `app/Views/admin/episodes/index.php` - Episodes list
- [ ] `app/Views/admin/episodes/form.php` - Add/Edit episode
- [ ] `app/Views/admin/blog/index.php` - Blog posts list
- [ ] `app/Views/admin/blog/form.php` - Add/Edit blog post
- [ ] `app/Views/admin/content/index.php` - Content editor

### 📋 Implementation Steps

#### Step 1: Create Main Layout Template

File: `app/Views/layouts/main.php`

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Skibidi Madness' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <?php include __DIR__ . '/../partials/nav.php'; ?>
    
    <main>
        <?= $content ?>
    </main>
    
    <?php include __DIR__ . '/../partials/footer.php'; ?>
    
    <script src="/assets/js/main.js"></script>
</body>
</html>
```

#### Step 2: Create Home Page View

File: `app/Views/home/index.php`

```php
<?php $this->layout('layouts/main'); ?>

<!-- Hero Section -->
<section class="hero" id="home">
    <video class="hero-video" autoplay muted loop playsinline>
        <source src="/assets/images/<?= $content['hero_video'] ?>" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title glitch"><?= $this->e($content['hero_title']) ?></h1>
        <p class="hero-subtitle"><?= $this->e($content['hero_subtitle']) ?></p>
        <!-- ... rest of content -->
    </div>
</section>

<!-- Episodes Section (BEFORE Heroes) -->
<section class="episodes" id="episodes">
    <?php foreach ($episodes as $episode): ?>
        <!-- Episode card -->
    <?php endforeach; ?>
</section>

<!-- Heroes Section (AFTER Episodes) -->
<section class="heroes" id="heroes">
    <?php foreach ($heroes as $hero): ?>
        <!-- Hero card -->
    <?php endforeach; ?>
</section>
```

#### Step 3: Create Admin Layout

File: `app/Views/layouts/admin.php`

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Admin Panel' ?></title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="admin-body">
    <?php include __DIR__ . '/../admin/partials/nav.php'; ?>
    
    <div class="admin-container">
        <?= $content ?>
    </div>
    
    <script src="/assets/js/admin.js"></script>
</body>
</html>
```

#### Step 4: Create Admin Dashboard View

File: `app/Views/admin/dashboard.php`

```php
<?php $this->layout('layouts/admin'); ?>

<h1>Admin Dashboard</h1>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Heroes</h3>
        <p class="stat-number"><?= $heroCount ?></p>
    </div>
    <!-- More stats -->
</div>

<!-- Password change form -->
<form method="POST" action="/admin/change-password">
    <!-- Form fields -->
</form>
```

### 🎯 Current Workaround

**Until views are created, the system can use the existing files:**

The old `index.php` and `blog.php` files are still present and functional. They can continue to work temporarily while views are being migrated.

**Migration Strategy:**
1. Keep old files temporarily
2. Create new views one by one
3. Test each view as it's created
4. Remove old files once all views are working
5. Update asset paths in views to use `/assets/` prefix

### 📝 Notes for Implementation

**Asset Paths:**
- OLD: `styles/main.css`, `scripts/main.js`
- NEW: `/assets/css/main.css`, `/assets/js/main.js`

**Database Access:**
- OLD: Direct queries in PHP files
- NEW: Controllers fetch data, pass to views

**Separation:**
- Views should ONLY contain HTML and minimal display logic
- NO database queries in views
- NO business logic in views
- Use `<?= $this->e($var) ?>` for safe output

**File Upload UI:**
Each admin form needs upload buttons:
```php
<input type="text" name="image_path" id="image_path">
<button type="button" onclick="uploadFile('image_path')">Upload Image</button>

<script>
async function uploadFile(inputId) {
    const formData = new FormData();
    formData.append('file', fileInput.files[0]);
    
    const response = await fetch('/admin/upload', {
        method: 'POST',
        body: formData
    });
    
    const result = await response.json();
    if (result.success) {
        document.getElementById(inputId).value = result.path;
    }
}
</script>
```

### ⚡ Quick Test

To test the current architecture:

```bash
cd /home/runner/work/web/web
php database/seed.php
cd public
php -S localhost:8000
```

Then visit:
- http://localhost:8000/ (should use old index.php temporarily)
- http://localhost:8000/admin/login (AuthController)

### 🚀 Next Commit

The next commit will include:
- All view templates created
- Asset paths updated
- Complete PHP/HTML separation
- File upload JavaScript
- Old files removed

This will complete the full MVC refactoring with SOLID/DRY/KISS principles fully implemented.
