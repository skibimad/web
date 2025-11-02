// Blog Display Script for Front-End

document.addEventListener('DOMContentLoaded', function() {
    loadBlogPosts();
});

function loadBlogPosts() {
    // Get blog posts from localStorage
    const blogData = localStorage.getItem('skibidi_blog');
    const posts = blogData ? JSON.parse(blogData) : [];
    
    // Filter only published posts
    const publishedPosts = posts.filter(post => post.published !== false);
    
    // Sort by date (newest first)
    publishedPosts.sort((a, b) => new Date(b.date) - new Date(a.date));
    
    const container = document.getElementById('blog-posts-grid');
    const noPostsDiv = document.getElementById('no-posts');
    
    if (publishedPosts.length === 0) {
        if (container) container.style.display = 'none';
        if (noPostsDiv) noPostsDiv.style.display = 'block';
        return;
    }
    
    if (container) {
        container.innerHTML = publishedPosts.map(post => createBlogCard(post)).join('');
    }
    
    if (noPostsDiv) noPostsDiv.style.display = 'none';
}

function createBlogCard(post) {
    const date = formatBlogDate(post.date);
    const excerpt = post.excerpt || truncateText(post.content, 150);
    
    return `
        <div class="blog-card">
            <img src="${post.image}" alt="${post.title}" class="blog-card-image" onerror="this.src='res/img/all-together.png'">
            <div class="blog-card-content">
                <h3 class="blog-card-title">${post.title}</h3>
                <div class="blog-card-meta">
                    ${post.author || 'FireStormX Studios'} • ${date}
                </div>
                <p class="blog-card-excerpt">${excerpt}</p>
                <a href="blog-post.html?id=${post.id}" class="blog-card-link">Read More →</a>
            </div>
        </div>
    `;
}

function formatBlogDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}

function truncateText(text, maxLength) {
    // Remove HTML tags
    const cleanText = text.replace(/<[^>]*>/g, '');
    if (cleanText.length <= maxLength) return cleanText;
    return cleanText.substring(0, maxLength).trim() + '...';
}

// Function to load first 3 posts for home page
function loadRecentBlogPosts(containerId, limit = 3) {
    const blogData = localStorage.getItem('skibidi_blog');
    const posts = blogData ? JSON.parse(blogData) : [];
    
    const publishedPosts = posts.filter(post => post.published !== false);
    publishedPosts.sort((a, b) => new Date(b.date) - new Date(a.date));
    
    const recentPosts = publishedPosts.slice(0, limit);
    const container = document.getElementById(containerId);
    
    if (!container) return;
    
    if (recentPosts.length === 0) {
        container.innerHTML = '<div class="no-content"><p>No blog posts yet. Check back soon!</p></div>';
        return;
    }
    
    container.innerHTML = recentPosts.map(post => createBlogCard(post)).join('');
}
