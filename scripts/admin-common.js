// Admin Common Functions - Data Management for Skibidi Madness Admin Panel

// Data Storage Keys
const STORAGE_KEYS = {
    HEROES: 'skibidi_heroes',
    EPISODES: 'skibidi_episodes',
    BLOG: 'skibidi_blog'
};

// Initialize Storage
function initStorage() {
    // Initialize heroes with default data if empty
    if (!localStorage.getItem(STORAGE_KEYS.HEROES)) {
        const defaultHeroes = [
            {
                id: 'titan-camera',
                name: 'Titan Cameraman',
                slug: 'titan-camera',
                description: 'The vigilant guardian with unmatched surveillance capabilities. His camera lens sees through deception and captures the truth in every battle. Armed with devastating firepower and tactical precision.',
                image: 'res/img/heroes/promo/titan-camera.png',
                video: 'res/video/heroes/promo/titan-camera.mp4',
                abilities: ['Tactical Vision', 'Heavy Artillery', 'Combat Analysis'],
                order: 1
            },
            {
                id: 'titan-speaker',
                name: 'Titan Speakerman',
                slug: 'titan-speaker',
                description: 'Master of sonic devastation who channels raw sound energy into overwhelming force. His acoustic waves can shatter dimensions and resonate across the multiverse, disrupting enemy formations with thunderous power.',
                image: 'res/img/heroes/promo/titan-speaker.png',
                video: 'res/video/heroes/promo/titan-speaker.mp4',
                abilities: ['Sonic Blast', 'Sound Barrier', 'Resonance Strike'],
                order: 2
            },
            {
                id: 'titan-tv',
                name: 'Titan TV Man',
                slug: 'titan-tv',
                description: 'The hypnotic warrior whose screen broadcasts reality-altering frequencies. Through his display, he can control minds, project illusions, and manipulate the very perception of his enemies across all dimensions.',
                image: 'res/img/heroes/promo/titan-tv.png',
                video: 'res/video/heroes/promo/titan-tv.mp4',
                abilities: ['Mind Control', 'Hypno Wave', 'Reality Distortion'],
                order: 3
            },
            {
                id: 'g-man',
                name: 'G-Man',
                slug: 'g-man',
                description: 'The enigmatic leader whose true power remains shrouded in mystery. A master tactician and skilled combatant, G-Man coordinates the resistance with calculated precision, always three steps ahead of his adversaries.',
                image: 'res/img/heroes/promo/g-man.png',
                video: 'res/video/heroes/promo/g-man.mp4',
                abilities: ['Strategic Mastery', 'Teleportation', 'Energy Manipulation'],
                order: 4
            },
            {
                id: 'star-storage',
                name: 'Star Storage',
                slug: 'star-storage',
                description: 'The cosmic keeper who harnesses stellar energy from across galaxies. With the ability to store and release concentrated star power, this hero brings celestial might to every confrontation, illuminating the darkest battles.',
                image: 'res/img/heroes/promo/star-storage.png',
                video: 'res/video/heroes/promo/star-storage.mp4',
                abilities: ['Stellar Energy', 'Cosmic Shield', 'Star Burst'],
                order: 5
            }
        ];
        localStorage.setItem(STORAGE_KEYS.HEROES, JSON.stringify(defaultHeroes));
    }

    // Initialize episodes with default data if empty
    if (!localStorage.getItem(STORAGE_KEYS.EPISODES)) {
        const defaultEpisodes = [
            {
                id: 'ep-1',
                number: 1,
                title: 'The Awakening',
                description: 'The Supreme Leader emerges from the shadows as the Asotra forces launch their first attack across multiple dimensions. The heroes must unite quickly or watch reality crumble.',
                thumbnail: 'res/img/all-together.png',
                videoUrl: 'https://www.youtube.com/@FirestomX-Tri',
                duration: '10:30',
                releaseDate: '2024-01-15'
            },
            {
                id: 'ep-2',
                number: 2,
                title: 'Multiverse Mayhem',
                description: 'As portals tear open between Marvel, DC, and Star Wars universes, our heroes face unprecedented challenges. Allies emerge from unexpected places.',
                thumbnail: 'res/img/heroes/promo/titan-camera.png',
                videoUrl: 'https://www.youtube.com/@FirestomX-Tri',
                duration: '12:45',
                releaseDate: '2024-01-22'
            },
            {
                id: 'ep-3',
                number: 3,
                title: 'The Supreme Leader Revealed',
                description: "G-Man uncovers the shocking truth about the Supreme Leader's identity and their connection to the original Skibidi universe. Nothing will be the same.",
                thumbnail: 'res/img/heroes/promo/g-man.png',
                videoUrl: 'https://www.youtube.com/@FirestomX-Tri',
                duration: '15:20',
                releaseDate: '2024-01-29'
            },
            {
                id: 'ep-4',
                number: 4,
                title: 'Sonic Showdown',
                description: 'Titan Speakerman faces his greatest test as the Asotra deploy weapons that target sound itself. Can he overcome this deadly silence?',
                thumbnail: 'res/img/heroes/promo/titan-speaker.png',
                videoUrl: 'https://www.youtube.com/@FirestomX-Tri',
                duration: '11:15',
                releaseDate: '2024-02-05'
            },
            {
                id: 'ep-5',
                number: 5,
                title: 'Stellar Convergence',
                description: 'Star Storage channels the power of dying stars to create a weapon capable of sealing dimensional rifts. But at what cost?',
                thumbnail: 'res/img/heroes/promo/star-storage.png',
                videoUrl: 'https://www.youtube.com/@FirestomX-Tri',
                duration: '13:50',
                releaseDate: '2024-02-12'
            }
        ];
        localStorage.setItem(STORAGE_KEYS.EPISODES, JSON.stringify(defaultEpisodes));
    }

    // Initialize blog with empty array if not exists
    if (!localStorage.getItem(STORAGE_KEYS.BLOG)) {
        localStorage.setItem(STORAGE_KEYS.BLOG, JSON.stringify([]));
    }
}

// Generic CRUD operations
function getData(key) {
    const data = localStorage.getItem(key);
    return data ? JSON.parse(data) : [];
}

function saveData(key, data) {
    localStorage.setItem(key, JSON.stringify(data));
    updateLastModified();
}

function addItem(key, item) {
    const data = getData(key);
    data.push(item);
    saveData(key, data);
}

function updateItem(key, id, updatedItem) {
    const data = getData(key);
    const index = data.findIndex(item => item.id === id);
    if (index !== -1) {
        data[index] = { ...data[index], ...updatedItem };
        saveData(key, data);
        return true;
    }
    return false;
}

function deleteItem(key, id) {
    const data = getData(key);
    const filtered = data.filter(item => item.id !== id);
    saveData(key, filtered);
}

function getItemById(key, id) {
    const data = getData(key);
    return data.find(item => item.id === id);
}

// Helper functions
function generateId(prefix = '') {
    return prefix + Date.now() + Math.random().toString(36).substr(2, 9);
}

function slugify(text) {
    return text
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
}

function formatDate(date) {
    if (!date) return '';
    const d = new Date(date);
    return d.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}

function updateLastModified() {
    localStorage.setItem('skibidi_last_modified', new Date().toISOString());
}

function getLastModified() {
    const lastMod = localStorage.getItem('skibidi_last_modified');
    return lastMod ? formatDate(lastMod) : 'Never';
}

function getStorageSize() {
    let total = 0;
    for (let key in localStorage) {
        if (localStorage.hasOwnProperty(key)) {
            total += localStorage[key].length + key.length;
        }
    }
    return (total / 1024).toFixed(2) + ' KB';
}

// Export/Import functions
function exportData() {
    const data = {
        heroes: getData(STORAGE_KEYS.HEROES),
        episodes: getData(STORAGE_KEYS.EPISODES),
        blog: getData(STORAGE_KEYS.BLOG),
        exported: new Date().toISOString()
    };
    
    const dataStr = JSON.stringify(data, null, 2);
    const dataBlob = new Blob([dataStr], { type: 'application/json' });
    const url = URL.createObjectURL(dataBlob);
    
    const link = document.createElement('a');
    link.href = url;
    link.download = `skibidi-madness-data-${Date.now()}.json`;
    link.click();
    
    URL.revokeObjectURL(url);
}

function importData() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'application/json';
    
    input.onchange = (e) => {
        const file = e.target.files[0];
        const reader = new FileReader();
        
        reader.onload = (event) => {
            try {
                const data = JSON.parse(event.target.result);
                
                if (confirm('This will replace all existing data. Continue?')) {
                    if (data.heroes) saveData(STORAGE_KEYS.HEROES, data.heroes);
                    if (data.episodes) saveData(STORAGE_KEYS.EPISODES, data.episodes);
                    if (data.blog) saveData(STORAGE_KEYS.BLOG, data.blog);
                    
                    alert('Data imported successfully!');
                    location.reload();
                }
            } catch (error) {
                alert('Error importing data: ' + error.message);
            }
        };
        
        reader.readAsText(file);
    };
    
    input.click();
}

// Confirmation dialog
function confirmDelete(itemName) {
    return confirm(`Are you sure you want to delete "${itemName}"? This action cannot be undone.`);
}

// Initialize on load
initStorage();
