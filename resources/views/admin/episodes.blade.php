<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Episodes - Admin Panel</title>
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
                <li><a href="admin-heroes.html">Heroes</a></li>
                <li><a href="admin-episodes.html" class="active">Episodes</a></li>
                <li><a href="admin-blog.html">Blog</a></li>
                <li><a href="index.html">View Site</a></li>
            </ul>
        </div>
    </nav>

    <main class="admin-main">
        <div class="admin-container">
            <div class="admin-header">
                <h1 class="admin-title">Manage Episodes</h1>
                <button class="btn btn-primary" onclick="showAddEpisodeForm()">+ Add New Episode</button>
            </div>

            <!-- Episode Form (Hidden by default) -->
            <div id="episode-form" class="admin-form" style="display: none;">
                <h2 id="form-title">Add New Episode</h2>
                <form id="episode-edit-form">
                    <input type="hidden" id="episode-id">
                    
                    <div class="form-group">
                        <label for="episode-number">Episode Number *</label>
                        <input type="number" id="episode-number" required min="1" placeholder="1">
                    </div>

                    <div class="form-group">
                        <label for="episode-title">Episode Title *</label>
                        <input type="text" id="episode-title" required placeholder="e.g., The Awakening">
                    </div>

                    <div class="form-group">
                        <label for="episode-description">Description *</label>
                        <textarea id="episode-description" required rows="4" placeholder="Describe what happens in this episode"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="episode-thumbnail">Thumbnail Path *</label>
                        <input type="text" id="episode-thumbnail" required placeholder="res/img/episodes/episode-1.png">
                    </div>

                    <div class="form-group">
                        <label for="episode-video-url">YouTube Video URL</label>
                        <input type="url" id="episode-video-url" placeholder="https://www.youtube.com/watch?v=...">
                    </div>

                    <div class="form-group">
                        <label for="episode-duration">Duration</label>
                        <input type="text" id="episode-duration" placeholder="e.g., 10:30">
                    </div>

                    <div class="form-group">
                        <label for="episode-release-date">Release Date</label>
                        <input type="date" id="episode-release-date">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save Episode</button>
                        <button type="button" class="btn btn-secondary" onclick="hideEpisodeForm()">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Episodes List -->
            <div class="admin-list">
                <div id="episodes-list" class="items-grid">
                    <!-- Episodes will be loaded here -->
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('scripts/' ) }}"admin-common.js"></script>
    <script src="{{ asset('scripts/' ) }}"admin-episodes.js"></script>
</body>
</html>
