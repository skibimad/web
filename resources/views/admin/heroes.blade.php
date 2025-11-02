<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Heroes - Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('styles/' ) }}"main.css">
    <link rel="stylesheet" href="{{ asset('styles/' ) }}"admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="admin-body">
    <nav class="admin-navbar">
        <div class="admin-container">
            <div class="admin-logo">
                <span class="logo-main">SKIBIDI</span>
                <span class="logo-sub">ADMIN PANEL</span>
            </div>
            <ul class="admin-menu">
                <li><a href="admin.html">Dashboard</a></li>
                <li><a href="admin-heroes.html" class="active">Heroes</a></li>
                <li><a href="admin-episodes.html">Episodes</a></li>
                <li><a href="admin-blog.html">Blog</a></li>
                <li><a href="index.html">View Site</a></li>
            </ul>
        </div>
    </nav>

    <main class="admin-main">
        <div class="admin-container">
            <div class="admin-header">
                <h1 class="admin-title">Manage Heroes</h1>
                <button class="btn btn-primary" onclick="showAddHeroForm()">+ Add New Hero</button>
            </div>

            <!-- Hero Form (Hidden by default) -->
            <div id="hero-form" class="admin-form" style="display: none;">
                <h2 id="form-title">Add New Hero</h2>
                <form id="hero-edit-form">
                    <input type="hidden" id="hero-id">
                    
                    <div class="form-group">
                        <label for="hero-name">Hero Name *</label>
                        <input type="text" id="hero-name" required placeholder="e.g., Titan Cameraman">
                    </div>

                    <div class="form-group">
                        <label for="hero-slug">Slug (for URLs) *</label>
                        <input type="text" id="hero-slug" required placeholder="e.g., titan-camera">
                    </div>

                    <div class="form-group">
                        <label for="hero-description">Description *</label>
                        <textarea id="hero-description" required rows="4" placeholder="Describe the hero's abilities and role"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="hero-image">Image Path *</label>
                        <input type="text" id="hero-image" required placeholder="res/img/heroes/promo/hero-name.png">
                    </div>

                    <div class="form-group">
                        <label for="hero-video">Video Path *</label>
                        <input type="text" id="hero-video" required placeholder="res/video/heroes/promo/hero-name.mp4">
                    </div>

                    <div class="form-group">
                        <label>Abilities (3 required)</label>
                        <input type="text" id="ability-1" required placeholder="Ability 1">
                        <input type="text" id="ability-2" required placeholder="Ability 2">
                        <input type="text" id="ability-3" required placeholder="Ability 3">
                    </div>

                    <div class="form-group">
                        <label for="hero-order">Display Order</label>
                        <input type="number" id="hero-order" min="1" value="1">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save Hero</button>
                        <button type="button" class="btn btn-secondary" onclick="hideHeroForm()">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Heroes List -->
            <div class="admin-list">
                <div id="heroes-list" class="items-grid">
                    <!-- Heroes will be loaded here -->
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('scripts/' ) }}"admin-common.js"></script>
    <script src="{{ asset('scripts/' ) }}"admin-heroes.js"></script>
</body>
</html>
