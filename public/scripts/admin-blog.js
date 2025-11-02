// Admin Blog Management

let editingBlogId = null;

document.addEventListener('DOMContentLoaded', function() {
    loadBlogPosts();
    setupBlogForm();
});

async function loadBlogPosts() {
    try {
        const posts = await BlogPostsAPI.getAll(true);
        const container = document.getElementById('blog-list');
        
        if (posts.length === 0) {
            container.innerHTML = '<div class="no-content"><h3>No blog posts yet</h3><p>Write your first post to get started!</p></div>';
            return;
        }
        
        posts.sort((a, b) => new Date(b.published_at) - new Date(a.published_at));
        
        container.innerHTML = posts.map(post => `
            <div class="admin-item">
                <img src="${post.image || 'res/img/all-together.png'}" alt="${post.title}" class="item-image" onerror="this.src='res/img/all-together.png'">
                <h3>${post.title}</h3>
                ${post.excerpt ? `<p>${post.excerpt}</p>` : ''}
                <div class="item-meta">
                    <span>✍️ ${post.author || 'FireStormX Studios'}</span>
                    <span>📅 ${formatDate(post.published_at)}</span>
                    <span>${post.published ? '✅ Published' : '📝 Draft'}</span>
                </div>
                <div class="item-actions">
                    <button class="btn btn-primary btn-small" onclick="editBlogPost(${post.id})">Edit</button>
                    <button class="btn btn-danger btn-small" onclick="deleteBlogPost(${post.id}, '${post.title.replace(/'/g, "\\'")}')">Delete</button>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading blog posts:', error);
        alert('Error loading blog posts. Please try again.');
    }
}

function setupBlogForm() {
    const form = document.getElementById('blog-edit-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        saveBlogPost();
    });
    
    // Auto-generate slug from title
    document.getElementById('blog-title').addEventListener('input', function(e) {
        if (!editingBlogId) {
            document.getElementById('blog-slug').value = slugify(e.target.value);
        }
    });
    
    // Set default date to today
    document.getElementById('blog-date').valueAsDate = new Date();
    
    // Set published checkbox default
    document.getElementById('blog-published').checked = true;
}

function showAddBlogForm() {
    editingBlogId = null;
    document.getElementById('form-title').textContent = 'Write New Post';
    document.getElementById('blog-edit-form').reset();
    document.getElementById('blog-date').valueAsDate = new Date();
    document.getElementById('blog-published').checked = true;
    document.getElementById('blog-form').style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function hideBlogForm() {
    document.getElementById('blog-form').style.display = 'none';
    editingBlogId = null;
}

async function editBlogPost(id) {
    try {
        const post = await BlogPostsAPI.get(id);
        if (!post) return;
        
        editingBlogId = id;
        document.getElementById('form-title').textContent = 'Edit Post';
        document.getElementById('blog-id').value = post.id;
        document.getElementById('blog-title').value = post.title;
        document.getElementById('blog-slug').value = post.slug;
        document.getElementById('blog-image').value = post.image || '';
        document.getElementById('blog-excerpt').value = post.excerpt || '';
        document.getElementById('blog-content').value = post.content;
        document.getElementById('blog-author').value = post.author || '';
        document.getElementById('blog-date').value = post.published_at ? post.published_at.split('T')[0] : '';
        document.getElementById('blog-published').checked = post.published !== false;
        
        document.getElementById('blog-form').style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } catch (error) {
        console.error('Error loading blog post:', error);
        alert('Error loading blog post. Please try again.');
    }
}

async function saveBlogPost() {
    try {
        const post = {
            title: document.getElementById('blog-title').value,
            slug: document.getElementById('blog-slug').value,
            image: document.getElementById('blog-image').value,
            excerpt: document.getElementById('blog-excerpt').value,
            content: document.getElementById('blog-content').value,
            author: document.getElementById('blog-author').value || 'FireStormX Studios',
            published_at: document.getElementById('blog-date').value || new Date().toISOString().split('T')[0],
            published: document.getElementById('blog-published').checked
        };
        
        if (editingBlogId) {
            await BlogPostsAPI.update(editingBlogId, post);
        } else {
            await BlogPostsAPI.create(post);
        }
        
        hideBlogForm();
        await loadBlogPosts();
        alert('Blog post saved successfully!');
    } catch (error) {
        console.error('Error saving blog post:', error);
        alert('Error saving blog post. Please try again.');
    }
}

async function deleteBlogPost(id, title) {
    if (confirmDelete(title)) {
        try {
            await BlogPostsAPI.delete(id);
            await loadBlogPosts();
        } catch (error) {
            console.error('Error deleting blog post:', error);
            alert('Error deleting blog post. Please try again.');
        }
    }
}
