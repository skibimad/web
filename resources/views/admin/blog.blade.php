<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blog - Admin Panel</title>
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
                <li><a href="admin-episodes.html">Episodes</a></li>
                <li><a href="admin-blog.html" class="active">Blog</a></li>
                <li><a href="index.html">View Site</a></li>
            </ul>
        </div>
    </nav>

    <main class="admin-main">
        <div class="admin-container">
            <div class="admin-header">
                <h1 class="admin-title">Manage Blog Posts</h1>
                <button class="btn btn-primary" onclick="showAddBlogForm()">+ Write New Post</button>
            </div>

            <!-- Blog Post Form (Hidden by default) -->
            <div id="blog-form" class="admin-form" style="display: none;">
                <h2 id="form-title">Write New Post</h2>
                <form id="blog-edit-form">
                    <input type="hidden" id="blog-id">
                    
                    <div class="form-group">
                        <label for="blog-title">Title *</label>
                        <input type="text" id="blog-title" required placeholder="Enter post title">
                    </div>

                    <div class="form-group">
                        <label for="blog-slug">Slug (for URLs) *</label>
                        <input type="text" id="blog-slug" required placeholder="auto-generated-from-title">
                    </div>

                    <div class="form-group">
                        <label for="blog-image">Featured Image Path *</label>
                        <input type="text" id="blog-image" required placeholder="res/img/blog/post-image.png">
                    </div>

                    <div class="form-group">
                        <label for="blog-excerpt">Excerpt (Short Description)</label>
                        <textarea id="blog-excerpt" rows="2" placeholder="A brief summary shown on the blog list"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="blog-content">Content *</label>
                        <textarea id="blog-content" required rows="12" placeholder="Write your blog post content here (HTML supported)"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="blog-author">Author</label>
                            <input type="text" id="blog-author" placeholder="FireStormX Studios">
                        </div>

                        <div class="form-group">
                            <label for="blog-date">Publish Date</label>
                            <input type="date" id="blog-date">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="blog-published">
                            Published (uncheck to save as draft)
                        </label>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save Post</button>
                        <button type="button" class="btn btn-secondary" onclick="hideBlogForm()">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Blog Posts List -->
            <div class="admin-list">
                <div id="blog-list" class="items-list">
                    <!-- Blog posts will be loaded here -->
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('scripts/' ) }}"admin-common.js"></script>
    <script src="{{ asset('scripts/' ) }}"admin-blog.js"></script>
</body>
</html>
