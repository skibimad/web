// Admin Heroes Management

let editingHeroId = null;

document.addEventListener('DOMContentLoaded', function() {
    loadHeroes();
    setupHeroForm();
});

function loadHeroes() {
    const heroes = getData(STORAGE_KEYS.HEROES);
    const container = document.getElementById('heroes-list');
    
    if (heroes.length === 0) {
        container.innerHTML = '<div class="no-content"><h3>No heroes yet</h3><p>Add your first hero to get started!</p></div>';
        return;
    }
    
    heroes.sort((a, b) => a.order - b.order);
    
    container.innerHTML = heroes.map(hero => `
        <div class="admin-item">
            <img src="${hero.image}" alt="${hero.name}" class="item-image" onerror="this.src='res/img/all-together.png'">
            <h3>${hero.name}</h3>
            <p>${hero.description.substring(0, 150)}...</p>
            <div class="item-meta">
                <span>🎯 ${hero.abilities.join(', ')}</span>
                <span>📍 Order: ${hero.order}</span>
            </div>
            <div class="item-actions">
                <button class="btn btn-primary btn-small" onclick="editHero('${hero.id}')">Edit</button>
                <button class="btn btn-danger btn-small" onclick="deleteHero('${hero.id}', '${hero.name}')">Delete</button>
            </div>
        </div>
    `).join('');
}

function setupHeroForm() {
    const form = document.getElementById('hero-edit-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        saveHero();
    });
    
    // Auto-generate slug from name
    document.getElementById('hero-name').addEventListener('input', function(e) {
        if (!editingHeroId) {
            document.getElementById('hero-slug').value = slugify(e.target.value);
        }
    });
}

function showAddHeroForm() {
    editingHeroId = null;
    document.getElementById('form-title').textContent = 'Add New Hero';
    document.getElementById('hero-edit-form').reset();
    document.getElementById('hero-form').style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function hideHeroForm() {
    document.getElementById('hero-form').style.display = 'none';
    editingHeroId = null;
}

function editHero(id) {
    const hero = getItemById(STORAGE_KEYS.HEROES, id);
    if (!hero) return;
    
    editingHeroId = id;
    document.getElementById('form-title').textContent = 'Edit Hero';
    document.getElementById('hero-id').value = hero.id;
    document.getElementById('hero-name').value = hero.name;
    document.getElementById('hero-slug').value = hero.slug;
    document.getElementById('hero-description').value = hero.description;
    document.getElementById('hero-image').value = hero.image;
    document.getElementById('hero-video').value = hero.video;
    document.getElementById('ability-1').value = hero.abilities[0] || '';
    document.getElementById('ability-2').value = hero.abilities[1] || '';
    document.getElementById('ability-3').value = hero.abilities[2] || '';
    document.getElementById('hero-order').value = hero.order;
    
    document.getElementById('hero-form').style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function saveHero() {
    const hero = {
        id: editingHeroId || generateId('hero-'),
        name: document.getElementById('hero-name').value,
        slug: document.getElementById('hero-slug').value,
        description: document.getElementById('hero-description').value,
        image: document.getElementById('hero-image').value,
        video: document.getElementById('hero-video').value,
        abilities: [
            document.getElementById('ability-1').value,
            document.getElementById('ability-2').value,
            document.getElementById('ability-3').value
        ],
        order: parseInt(document.getElementById('hero-order').value) || 1
    };
    
    if (editingHeroId) {
        updateItem(STORAGE_KEYS.HEROES, editingHeroId, hero);
    } else {
        addItem(STORAGE_KEYS.HEROES, hero);
    }
    
    hideHeroForm();
    loadHeroes();
    alert('Hero saved successfully!');
}

function deleteHero(id, name) {
    if (confirmDelete(name)) {
        deleteItem(STORAGE_KEYS.HEROES, id);
        loadHeroes();
    }
}
