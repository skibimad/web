// Admin Episodes Management

let editingEpisodeId = null;

document.addEventListener('DOMContentLoaded', function() {
    loadEpisodes();
    setupEpisodeForm();
});

function loadEpisodes() {
    const episodes = getData(STORAGE_KEYS.EPISODES);
    const container = document.getElementById('episodes-list');
    
    if (episodes.length === 0) {
        container.innerHTML = '<div class="no-content"><h3>No episodes yet</h3><p>Add your first episode to get started!</p></div>';
        return;
    }
    
    episodes.sort((a, b) => a.number - b.number);
    
    container.innerHTML = episodes.map(episode => `
        <div class="admin-item">
            <img src="${episode.thumbnail}" alt="${episode.title}" class="item-image" onerror="this.src='res/img/all-together.png'">
            <h3>Episode ${episode.number}: ${episode.title}</h3>
            <p>${episode.description}</p>
            <div class="item-meta">
                ${episode.duration ? `<span>⏱️ ${episode.duration}</span>` : ''}
                ${episode.releaseDate ? `<span>📅 ${formatDate(episode.releaseDate)}</span>` : ''}
            </div>
            <div class="item-actions">
                <button class="btn btn-primary btn-small" onclick="editEpisode('${episode.id}')">Edit</button>
                <button class="btn btn-danger btn-small" onclick="deleteEpisode('${episode.id}', '${episode.title}')">Delete</button>
            </div>
        </div>
    `).join('');
}

function setupEpisodeForm() {
    const form = document.getElementById('episode-edit-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        saveEpisode();
    });
}

function showAddEpisodeForm() {
    editingEpisodeId = null;
    document.getElementById('form-title').textContent = 'Add New Episode';
    document.getElementById('episode-edit-form').reset();
    
    // Set default episode number
    const episodes = getData(STORAGE_KEYS.EPISODES);
    const maxNumber = episodes.length > 0 ? Math.max(...episodes.map(e => e.number)) : 0;
    document.getElementById('episode-number').value = maxNumber + 1;
    
    document.getElementById('episode-form').style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function hideEpisodeForm() {
    document.getElementById('episode-form').style.display = 'none';
    editingEpisodeId = null;
}

function editEpisode(id) {
    const episode = getItemById(STORAGE_KEYS.EPISODES, id);
    if (!episode) return;
    
    editingEpisodeId = id;
    document.getElementById('form-title').textContent = 'Edit Episode';
    document.getElementById('episode-id').value = episode.id;
    document.getElementById('episode-number').value = episode.number;
    document.getElementById('episode-title').value = episode.title;
    document.getElementById('episode-description').value = episode.description;
    document.getElementById('episode-thumbnail').value = episode.thumbnail;
    document.getElementById('episode-video-url').value = episode.videoUrl || '';
    document.getElementById('episode-duration').value = episode.duration || '';
    document.getElementById('episode-release-date').value = episode.releaseDate || '';
    
    document.getElementById('episode-form').style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function saveEpisode() {
    const episode = {
        id: editingEpisodeId || generateId('ep-'),
        number: parseInt(document.getElementById('episode-number').value),
        title: document.getElementById('episode-title').value,
        description: document.getElementById('episode-description').value,
        thumbnail: document.getElementById('episode-thumbnail').value,
        videoUrl: document.getElementById('episode-video-url').value || '',
        duration: document.getElementById('episode-duration').value || '',
        releaseDate: document.getElementById('episode-release-date').value || ''
    };
    
    if (editingEpisodeId) {
        updateItem(STORAGE_KEYS.EPISODES, editingEpisodeId, episode);
    } else {
        addItem(STORAGE_KEYS.EPISODES, episode);
    }
    
    hideEpisodeForm();
    loadEpisodes();
    alert('Episode saved successfully!');
}

function deleteEpisode(id, title) {
    if (confirmDelete(title)) {
        deleteItem(STORAGE_KEYS.EPISODES, id);
        loadEpisodes();
    }
}
