const sqlite3 = require('sqlite3').verbose();
const bcrypt = require('bcrypt');

const db = new sqlite3.Database('./database.sqlite');

async function initializeDatabase() {
    console.log('Initializing database...');
    
    // Create tables
    db.serialize(async () => {
        // Users table
        db.run(`CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )`);
        
        // Heroes table
        db.run(`CREATE TABLE IF NOT EXISTS heroes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            slug TEXT UNIQUE NOT NULL,
            description TEXT,
            image TEXT,
            video TEXT,
            abilities TEXT,
            display_order INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )`);
        
        // Episodes table
        db.run(`CREATE TABLE IF NOT EXISTS episodes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            episode_number INTEGER NOT NULL,
            title TEXT NOT NULL,
            description TEXT,
            thumbnail TEXT,
            video_url TEXT,
            duration TEXT,
            release_date DATE,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )`);
        
        // Blog posts table
        db.run(`CREATE TABLE IF NOT EXISTS blog_posts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            slug TEXT UNIQUE NOT NULL,
            image TEXT,
            excerpt TEXT,
            content TEXT,
            author TEXT DEFAULT 'FireStormX Studios',
            date DATE,
            published INTEGER DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )`);
        
        // Static content table
        db.run(`CREATE TABLE IF NOT EXISTS static_content (
            key TEXT PRIMARY KEY,
            value TEXT,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )`);
        
        // Create default admin user (fsx / 111111)
        const hashedPassword = await bcrypt.hash('111111', 10);
        
        db.run(`INSERT OR IGNORE INTO users (username, password) VALUES (?, ?)`, 
            ['fsx', hashedPassword], (err) => {
                if (err) {
                    console.error('Error creating admin user:', err);
                } else {
                    console.log('Admin user created: fsx / 111111');
                }
            });
        
        // Insert default heroes
        const heroes = [
            {
                name: 'Titan Cameraman',
                slug: 'titan-camera',
                description: 'The vigilant guardian with unmatched surveillance capabilities. His camera lens sees through deception and captures the truth in every battle. Armed with devastating firepower and tactical precision.',
                image: 'res/img/heroes/promo/titan-camera.png',
                video: 'res/video/heroes/promo/titan-camera.mp4',
                abilities: JSON.stringify(['Tactical Vision', 'Heavy Artillery', 'Combat Analysis']),
                display_order: 1
            },
            {
                name: 'Titan Speakerman',
                slug: 'titan-speaker',
                description: 'Master of sonic devastation who channels raw sound energy into overwhelming force. His acoustic waves can shatter dimensions and resonate across the multiverse, disrupting enemy formations with thunderous power.',
                image: 'res/img/heroes/promo/titan-speaker.png',
                video: 'res/video/heroes/promo/titan-speaker.mp4',
                abilities: JSON.stringify(['Sonic Blast', 'Sound Barrier', 'Resonance Strike']),
                display_order: 2
            },
            {
                name: 'Titan TV Man',
                slug: 'titan-tv',
                description: 'The hypnotic warrior whose screen broadcasts reality-altering frequencies. Through his display, he can control minds, project illusions, and manipulate the very perception of his enemies across all dimensions.',
                image: 'res/img/heroes/promo/titan-tv.png',
                video: 'res/video/heroes/promo/titan-tv.mp4',
                abilities: JSON.stringify(['Mind Control', 'Hypno Wave', 'Reality Distortion']),
                display_order: 3
            },
            {
                name: 'G-Man',
                slug: 'g-man',
                description: 'The enigmatic leader whose true power remains shrouded in mystery. A master tactician and skilled combatant, G-Man coordinates the resistance with calculated precision, always three steps ahead of his adversaries.',
                image: 'res/img/heroes/promo/g-man.png',
                video: 'res/video/heroes/promo/g-man.mp4',
                abilities: JSON.stringify(['Strategic Mastery', 'Teleportation', 'Energy Manipulation']),
                display_order: 4
            },
            {
                name: 'Star Storage',
                slug: 'star-storage',
                description: 'The cosmic keeper who harnesses stellar energy from across galaxies. With the ability to store and release concentrated star power, this hero brings celestial might to every confrontation, illuminating the darkest battles.',
                image: 'res/img/heroes/promo/star-storage.png',
                video: 'res/video/heroes/promo/star-storage.mp4',
                abilities: JSON.stringify(['Stellar Energy', 'Cosmic Shield', 'Star Burst']),
                display_order: 5
            }
        ];
        
        heroes.forEach(hero => {
            db.run(`INSERT OR IGNORE INTO heroes (name, slug, description, image, video, abilities, display_order) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)`,
                [hero.name, hero.slug, hero.description, hero.image, hero.video, hero.abilities, hero.display_order],
                (err) => {
                    if (err) {
                        console.error(`Error inserting hero ${hero.name}:`, err);
                    }
                });
        });
        
        // Insert default episodes
        const episodes = [
            {
                episode_number: 1,
                title: 'The Awakening',
                description: 'The Supreme Leader emerges from the shadows as the Asotra forces launch their first attack across multiple dimensions. The heroes must unite quickly or watch reality crumble.',
                thumbnail: 'res/img/all-together.png',
                video_url: 'https://www.youtube.com/@FireStormX!?',
                duration: '10:30',
                release_date: '2024-01-15'
            },
            {
                episode_number: 2,
                title: 'Multiverse Mayhem',
                description: 'As portals tear open between Marvel, DC, and Star Wars universes, our heroes face unprecedented challenges. Allies emerge from unexpected places.',
                thumbnail: 'res/img/heroes/promo/titan-camera.png',
                video_url: 'https://www.youtube.com/@FireStormX!?',
                duration: '12:45',
                release_date: '2024-01-22'
            },
            {
                episode_number: 3,
                title: 'The Supreme Leader Revealed',
                description: "G-Man uncovers the shocking truth about the Supreme Leader's identity and their connection to the original Skibidi universe. Nothing will be the same.",
                thumbnail: 'res/img/heroes/promo/g-man.png',
                video_url: 'https://www.youtube.com/@FireStormX!?',
                duration: '15:20',
                release_date: '2024-01-29'
            },
            {
                episode_number: 4,
                title: 'Sonic Showdown',
                description: 'Titan Speakerman faces his greatest test as the Asotra deploy weapons that target sound itself. Can he overcome this deadly silence?',
                thumbnail: 'res/img/heroes/promo/titan-speaker.png',
                video_url: 'https://www.youtube.com/@FireStormX!?',
                duration: '11:15',
                release_date: '2024-02-05'
            },
            {
                episode_number: 5,
                title: 'Stellar Convergence',
                description: 'Star Storage channels the power of dying stars to create a weapon capable of sealing dimensional rifts. But at what cost?',
                thumbnail: 'res/img/heroes/promo/star-storage.png',
                video_url: 'https://www.youtube.com/@FireStormX!?',
                duration: '13:50',
                release_date: '2024-02-12'
            }
        ];
        
        episodes.forEach(episode => {
            db.run(`INSERT OR IGNORE INTO episodes (episode_number, title, description, thumbnail, video_url, duration, release_date) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)`,
                [episode.episode_number, episode.title, episode.description, episode.thumbnail, episode.video_url, episode.duration, episode.release_date],
                (err) => {
                    if (err) {
                        console.error(`Error inserting episode ${episode.title}:`, err);
                    }
                });
        });
        
        // Insert default static content
        const staticContent = [
            { key: 'hero_title', value: 'SKIBIDI MADNESS' },
            { key: 'hero_subtitle', value: 'A New Era of Chaos Begins' },
            { key: 'hero_description', value: 'Dive into an epic multiverse where heroes unite against the forces of chaos. From the depths of the Skibidi universe to the realms of Marvel, DC, Star Wars, and beyond.' },
            { key: 'about_title', value: 'The Story Unfolds' },
            { key: 'about_subtitle', value: 'A New Chapter in the Skibidi Universe' },
            { key: 'about_paragraph1', value: 'Welcome to <strong>Skibidi Madness</strong> - an extraordinary animation series created by FireStormX Studios that transcends the boundaries of the original Skibidi Toilet universe. This isn\'t just another story; it\'s a revolutionary fusion of multiple dimensions, timelines, and realities.' },
            { key: 'about_paragraph2', value: 'In this new saga, witness the unprecedented chaos unleashed by the malevolent forces known as the <strong>Asotra</strong>. Unlike previous battles against entire armies, our heroes now face their most formidable adversary yet - the mysterious and powerful <strong>Supreme Leader</strong>, whose ambitions threaten not just one universe, but the entire multiverse fabric.' },
            { key: 'about_paragraph3', value: 'Skibidi Madness weaves together elements from beloved franchises including Marvel\'s cosmic battles, the supernatural mysteries of Stranger Things, DC\'s legendary heroes, the epic space opera of Star Wars, the blocky realms of Minecraft, and countless other dimensions. This is where everything you love collides in spectacular fashion.' },
            { key: 'hero_video', value: 'res/video/all-together.mp4' },
            { key: 'about_image', value: 'res/img/all-together.png' }
        ];
        
        staticContent.forEach(item => {
            db.run(`INSERT OR IGNORE INTO static_content (key, value) VALUES (?, ?)`,
                [item.key, item.value],
                (err) => {
                    if (err) {
                        console.error(`Error inserting static content ${item.key}:`, err);
                    }
                });
        });
        
        console.log('Database initialized with demo data!');
        console.log('Admin credentials: fsx / 111111');
        
        db.close();
    });
}

initializeDatabase().catch(console.error);
