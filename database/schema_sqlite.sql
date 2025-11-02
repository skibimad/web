-- SQLite Database schema for Skibidi Madness

-- Heroes table
CREATE TABLE IF NOT EXISTS heroes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    slug TEXT NOT NULL UNIQUE,
    description TEXT,
    image TEXT,
    video TEXT,
    abilities TEXT,
    display_order INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS idx_heroes_slug ON heroes(slug);
CREATE INDEX IF NOT EXISTS idx_heroes_order ON heroes(display_order);

-- Episodes table
CREATE TABLE IF NOT EXISTS episodes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    episode_number INTEGER NOT NULL,
    title TEXT NOT NULL,
    description TEXT,
    thumbnail TEXT,
    video_url TEXT,
    duration TEXT,
    release_date DATE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS idx_episodes_number ON episodes(episode_number);
CREATE INDEX IF NOT EXISTS idx_episodes_date ON episodes(release_date);

-- Blog posts table
CREATE TABLE IF NOT EXISTS blog_posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    slug TEXT NOT NULL UNIQUE,
    content TEXT,
    excerpt TEXT,
    image TEXT,
    author TEXT DEFAULT 'FireStormX Studios',
    published INTEGER DEFAULT 1,
    published_at DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS idx_blog_slug ON blog_posts(slug);
CREATE INDEX IF NOT EXISTS idx_blog_published ON blog_posts(published);
CREATE INDEX IF NOT EXISTS idx_blog_published_at ON blog_posts(published_at);

-- Insert default heroes data
INSERT INTO heroes (name, slug, description, image, video, abilities, display_order) VALUES
('Titan Cameraman', 'titan-camera', 'The vigilant guardian with unmatched surveillance capabilities. His camera lens sees through deception and captures the truth in every battle. Armed with devastating firepower and tactical precision.', 'res/img/heroes/promo/titan-camera.png', 'res/video/heroes/promo/titan-camera.mp4', 'Tactical Vision,Heavy Artillery,Combat Analysis', 1),
('Titan Speakerman', 'titan-speaker', 'Master of sonic devastation who channels raw sound energy into overwhelming force. His acoustic waves can shatter dimensions and resonate across the multiverse, disrupting enemy formations with thunderous power.', 'res/img/heroes/promo/titan-speaker.png', 'res/video/heroes/promo/titan-speaker.mp4', 'Sonic Blast,Sound Barrier,Resonance Strike', 2),
('Titan TV Man', 'titan-tv', 'The hypnotic warrior whose screen broadcasts reality-altering frequencies. Through his display, he can control minds, project illusions, and manipulate the very perception of his enemies across all dimensions.', 'res/img/heroes/promo/titan-tv.png', 'res/video/heroes/promo/titan-tv.mp4', 'Mind Control,Hypno Wave,Reality Distortion', 3),
('G-Man', 'g-man', 'The enigmatic leader whose true power remains shrouded in mystery. A master tactician and skilled combatant, G-Man coordinates the resistance with calculated precision, always three steps ahead of his adversaries.', 'res/img/heroes/promo/g-man.png', 'res/video/heroes/promo/g-man.mp4', 'Strategic Mastery,Teleportation,Energy Manipulation', 4),
('Star Storage', 'star-storage', 'The cosmic keeper who harnesses stellar energy from across galaxies. With the ability to store and release concentrated star power, this hero brings celestial might to every confrontation, illuminating the darkest battles.', 'res/img/heroes/promo/star-storage.png', 'res/video/heroes/promo/star-storage.mp4', 'Stellar Energy,Cosmic Shield,Star Burst', 5);

-- Insert default episodes data
INSERT INTO episodes (episode_number, title, description, thumbnail, video_url, duration, release_date) VALUES
(1, 'The Awakening', 'The Supreme Leader emerges from the shadows as the Asotra forces launch their first attack across multiple dimensions. The heroes must unite quickly or watch reality crumble.', 'res/img/all-together.png', 'https://www.youtube.com/@FireStormX!?', '10:30', '2024-01-15'),
(2, 'Multiverse Mayhem', 'As portals tear open between Marvel, DC, and Star Wars universes, our heroes face unprecedented challenges. Allies emerge from unexpected places.', 'res/img/heroes/promo/titan-camera.png', 'https://www.youtube.com/@FireStormX!?', '12:45', '2024-01-22'),
(3, 'The Supreme Leader Revealed', 'G-Man uncovers the shocking truth about the Supreme Leader''s identity and their connection to the original Skibidi universe. Nothing will be the same.', 'res/img/heroes/promo/g-man.png', 'https://www.youtube.com/@FireStormX!?', '15:20', '2024-01-29'),
(4, 'Dimensional Rift', 'The Minecraft universe collides with reality as our heroes must protect Steve and Alex from the Asotra invasion while preventing total dimensional collapse.', 'res/img/heroes/promo/titan-speaker.png', 'https://www.youtube.com/@FireStormX!?', '11:15', '2024-02-05'),
(5, 'The Final Stand', 'All heroes unite in an epic confrontation with the Supreme Leader. The fate of all universes hangs in the balance. Who will survive?', 'res/img/heroes/promo/titan-tv.png', 'https://www.youtube.com/@FireStormX!?', '18:00', '2024-02-12');

-- Insert sample blog posts
INSERT INTO blog_posts (title, slug, content, excerpt, image, author, published, published_at) VALUES
('Welcome to Skibidi Madness', 'welcome-to-skibidi-madness', '<p>Welcome to the official Skibidi Madness website! We are thrilled to bring you this epic multiverse adventure.</p><p>Skibidi Madness is not just another series - it is a revolutionary fusion of multiple dimensions, timelines, and realities where heroes from different universes unite against the forces of chaos.</p>', 'Welcome to the official Skibidi Madness website! We are thrilled to bring you this epic multiverse adventure.', 'res/img/all-together.png', 'FireStormX Studios', 1, '2024-01-10 10:00:00'),
('Behind the Scenes: Creating the Titans', 'behind-the-scenes-titans', '<p>Ever wondered how we create the epic Titan characters? In this post, we take you behind the scenes of our animation process.</p><p>From concept art to final render, each Titan goes through dozens of iterations to ensure they look perfect on screen.</p>', 'Ever wondered how we create the epic Titan characters? In this post, we take you behind the scenes.', 'res/img/heroes/promo/titan-camera.png', 'FireStormX Studios', 1, '2024-01-17 14:30:00'),
('Episode 3 Preview: What to Expect', 'episode-3-preview', '<p>Episode 3 is coming soon and it''s going to be HUGE! G-Man finally discovers the truth about the Supreme Leader.</p><p>Get ready for plot twists, epic battles, and revelations that will change everything you thought you knew about the Skibidi universe.</p>', 'Episode 3 is coming soon and it is going to be HUGE! Get ready for plot twists and epic battles.', 'res/img/heroes/promo/g-man.png', 'FireStormX Studios', 1, '2024-01-25 16:00:00');

-- Landing page content table
CREATE TABLE IF NOT EXISTS landing_page_content (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    section TEXT NOT NULL,
    key TEXT NOT NULL,
    value TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(section, key)
);

CREATE INDEX IF NOT EXISTS idx_landing_section ON landing_page_content(section);

-- Insert default values
INSERT OR IGNORE INTO landing_page_content (section, key, value) VALUES
('hero', 'title', 'SKIBIDI MADNESS'),
('hero', 'subtitle', 'A New Era of Chaos Begins'),
('hero', 'description', 'Dive into an epic multiverse where heroes unite against the forces of chaos. From the depths of the Skibidi universe to the realms of Marvel, DC, Star Wars, and beyond.'),
('about', 'title', 'The Story Unfolds'),
('about', 'subtitle', 'A New Chapter in the Skibidi Universe'),
('channel', 'title', 'Join the FireStormX Community'),
('channel', 'description', 'Subscribe to FireStormX Studios on YouTube to never miss an episode of Skibidi Madness! Get exclusive behind-the-scenes content, character reveals, and be part of the growing community of fans exploring the multiverse.');
