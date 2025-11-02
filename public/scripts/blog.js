// Blog Display Script for Front-End

document.addEventListener('DOMContentLoaded', function() {
    loadBlogPosts();
});

async function loadBlogPosts() {
    try {
        // Get blog posts from API
        const response = await fetch('/api/blog-posts');
        const posts = await response.json();
        
        const container = document.getElementById('blog-posts-grid');
        const noPostsDiv = document.getElementById('no-posts');
        
        if (posts.length === 0) {
            if (container) container.style.display = 'none';
            if (noPostsDiv) noPostsDiv.style.display = 'block';
            return;
        }
        
        if (container) {
            container.innerHTML = posts.map(post => createBlogCard(post)).join('');
        }
        
        if (noPostsDiv) noPostsDiv.style.display = 'none';
    } catch (error) {
        console.error('Error loading blog posts:', error);
    }
}

function createBlogCard(post) {
    const date = formatBlogDate(post.published_at);
    const excerpt = post.excerpt || truncateText(post.content, 150);
    const image = post.image || 'res/img/all-together.png';
    
    return `
        <div class="blog-card">
            <img src="${image}" alt="${post.title}" class="blog-card-image" onerror="this.src='res/img/all-together.png'">
            <div class="blog-card-content">
                <h3 class="blog-card-title">${post.title}</h3>
                <div class="blog-card-meta">
                    ${post.author || 'FireStormX Studios'} • ${date}
                </div>
                <p class="blog-card-excerpt">${excerpt}</p>
                <a href="/blog/${post.slug}" class="blog-card-link">Read More →</a>
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
async function loadRecentBlogPosts(containerId, limit = 3) {
    try {
        const response = await fetch(`/api/blog-posts-recent?limit=${limit}`);
        const posts = await response.json();
        
        const container = document.getElementById(containerId);
        
        if (!container) return;
        
        if (posts.length === 0) {
            container.innerHTML = '<div class="no-content"><p>No blog posts yet. Check back soon!</p></div>';
            return;
        }
        
        container.innerHTML = posts.map(post => createBlogCard(post)).join('');
    } catch (error) {
        console.error('Error loading recent blog posts:', error);
    }
}
