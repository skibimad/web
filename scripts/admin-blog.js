// Admin Blog Management

let editingBlogId = null;

document.addEventListener('DOMContentLoaded', function() {
    loadBlogPosts();
    setupBlogForm();
});

function loadBlogPosts() {
    const posts = getData(STORAGE_KEYS.BLOG);
    const container = document.getElementById('blog-list');
    
    if (posts.length === 0) {
        container.innerHTML = '<div class="no-content"><h3>No blog posts yet</h3><p>Write your first post to get started!</p></div>';
        return;
    }
    
    posts.sort((a, b) => new Date(b.date) - new Date(a.date));
    
    container.innerHTML = posts.map(post => `
        <div class="admin-item">
            <img src="${post.image}" alt="${post.title}" class="item-image" onerror="this.src='res/img/all-together.png'">
            <h3>${post.title}</h3>
            ${post.excerpt ? `<p>${post.excerpt}</p>` : ''}
            <div class="item-meta">
                <span>✍️ ${post.author || 'FireStormX Studios'}</span>
                <span>📅 ${formatDate(post.date)}</span>
                <span>${post.published ? '✅ Published' : '📝 Draft'}</span>
            </div>
            <div class="item-actions">
                <button class="btn btn-primary btn-small" onclick="editBlogPost('${post.id}')">Edit</button>
                <button class="btn btn-danger btn-small" onclick="deleteBlogPost('${post.id}', '${post.title.replace(/'/g, "\\'")}')">Delete</button>
            </div>
        </div>
    `).join('');
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

function editBlogPost(id) {
    const post = getItemById(STORAGE_KEYS.BLOG, id);
    if (!post) return;
    
    editingBlogId = id;
    document.getElementById('form-title').textContent = 'Edit Post';
    document.getElementById('blog-id').value = post.id;
    document.getElementById('blog-title').value = post.title;
    document.getElementById('blog-slug').value = post.slug;
    document.getElementById('blog-image').value = post.image;
    document.getElementById('blog-excerpt').value = post.excerpt || '';
    document.getElementById('blog-content').value = post.content;
    document.getElementById('blog-author').value = post.author || '';
    document.getElementById('blog-date').value = post.date || '';
    document.getElementById('blog-published').checked = post.published !== false;
    
    document.getElementById('blog-form').style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function saveBlogPost() {
    const post = {
        id: editingBlogId || generateId('post-'),
        title: document.getElementById('blog-title').value,
        slug: document.getElementById('blog-slug').value,
        image: document.getElementById('blog-image').value,
        excerpt: document.getElementById('blog-excerpt').value,
        content: document.getElementById('blog-content').value,
        author: document.getElementById('blog-author').value || 'FireStormX Studios',
        date: document.getElementById('blog-date').value || new Date().toISOString().split('T')[0],
        published: document.getElementById('blog-published').checked
    };
    
    if (editingBlogId) {
        updateItem(STORAGE_KEYS.BLOG, editingBlogId, post);
    } else {
        addItem(STORAGE_KEYS.BLOG, post);
    }
    
    hideBlogForm();
    loadBlogPosts();
    alert('Blog post saved successfully!');
}

function deleteBlogPost(id, title) {
    if (confirmDelete(title)) {
        deleteItem(STORAGE_KEYS.BLOG, id);
        loadBlogPosts();
    }
}
