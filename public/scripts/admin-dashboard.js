// Admin Dashboard Script

document.addEventListener('DOMContentLoaded', function() {
    updateDashboardStats();
    updateSystemInfo();
});

function updateDashboardStats() {
    // Update counts
    const heroes = getData(STORAGE_KEYS.HEROES);
    const episodes = getData(STORAGE_KEYS.EPISODES);
    const blog = getData(STORAGE_KEYS.BLOG);
    
    document.getElementById('heroes-count').textContent = heroes.length;
    document.getElementById('episodes-count').textContent = episodes.length;
    document.getElementById('blog-count').textContent = blog.length;
}

function updateSystemInfo() {
    // Update storage info
    document.getElementById('storage-used').textContent = getStorageSize();
    document.getElementById('last-updated').textContent = getLastModified();
    document.getElementById('data-status').textContent = 'OK';
}
