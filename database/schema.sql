-- Database schema for Skibidi Madness

CREATE DATABASE IF NOT EXISTS skibidi_madness CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE skibidi_madness;

-- Heroes table
CREATE TABLE IF NOT EXISTS heroes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    image VARCHAR(255),
    video VARCHAR(255),
    abilities TEXT,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Episodes table
CREATE TABLE IF NOT EXISTS episodes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    episode_number INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    thumbnail VARCHAR(255),
    video_url VARCHAR(255),
    duration VARCHAR(20),
    release_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_episode_number (episode_number),
    INDEX idx_release_date (release_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Blog posts table
CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT,
    excerpt TEXT,
    image VARCHAR(255),
    author VARCHAR(255) DEFAULT 'FireStormX Studios',
    published TINYINT(1) DEFAULT 1,
    published_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_published (published),
    INDEX idx_published_at (published_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default heroes data
INSERT INTO heroes (name, slug, description, image, video, abilities, display_order) VALUES
('Titan Cameraman', 'titan-camera', 'The vigilant guardian with unmatched surveillance capabilities. His camera lens sees through deception and captures the truth in every battle. Armed with devastating firepower and tactical precision.', 'res/img/heroes/promo/titan-camera.png', 'res/video/heroes/promo/titan-camera.mp4', 'Tactical Vision,Heavy Artillery,Combat Analysis', 1),
('Titan Speakerman', 'titan-speaker', 'Master of sonic devastation who channels raw sound energy into overwhelming force. His acoustic waves can shatter dimensions and resonate across the multiverse, disrupting enemy formations with thunderous power.', 'res/img/heroes/promo/titan-speaker.png', 'res/video/heroes/promo/titan-speaker.mp4', 'Sonic Blast,Sound Barrier,Resonance Strike', 2),
('Titan TV Man', 'titan-tv', 'The hypnotic warrior whose screen broadcasts reality-altering frequencies. Through his display, he can control minds, project illusions, and manipulate the very perception of his enemies across all dimensions.', 'res/img/heroes/promo/titan-tv.png', 'res/video/heroes/promo/titan-tv.mp4', 'Mind Control,Hypno Wave,Reality Distortion', 3),
('G-Man', 'g-man', 'The enigmatic leader whose true power remains shrouded in mystery. A master tactician and skilled combatant, G-Man coordinates the resistance with calculated precision, always three steps ahead of his adversaries.', 'res/img/heroes/promo/g-man.png', 'res/video/heroes/promo/g-man.mp4', 'Strategic Mastery,Teleportation,Energy Manipulation', 4),
('Star Storage', 'star-storage', 'The cosmic keeper who harnesses stellar energy from across galaxies. With the ability to store and release concentrated star power, this hero brings celestial might to every confrontation, illuminating the darkest battles.', 'res/img/heroes/promo/star-storage.png', 'res/video/heroes/promo/star-storage.mp4', 'Stellar Energy,Cosmic Shield,Star Burst', 5);

-- Insert default episodes data
INSERT INTO episodes (episode_number, title, description, thumbnail, video_url, duration, release_date) VALUES
(1, 'The Awakening', 'The Supreme Leader emerges from the shadows as the Asotra forces launch their first attack across multiple dimensions. The heroes must unite quickly or watch reality crumble.', 'res/img/all-together.png', 'https://www.youtube.com/@FireStorm-Tri', '10:30', '2024-01-15'),
(2, 'Multiverse Mayhem', 'As portals tear open between Marvel, DC, and Star Wars universes, our heroes face unprecedented challenges. Allies emerge from unexpected places.', 'res/img/heroes/promo/titan-camera.png', 'https://www.youtube.com/@FireStorm-Tri', '12:45', '2024-01-22'),
(3, 'The Supreme Leader Revealed', 'G-Man uncovers the shocking truth about the Supreme Leader''s identity and their connection to the original Skibidi universe. Nothing will be the same.', 'res/img/heroes/promo/g-man.png', 'https://www.youtube.com/@FireStorm-Tri', '15:20', '2024-01-29'),
(4, 'Dimensional Rift', 'The Minecraft universe collides with reality as our heroes must protect Steve and Alex from the Asotra invasion while preventing total dimensional collapse.', 'res/img/heroes/promo/titan-speaker.png', 'https://www.youtube.com/@FireStorm-Tri', '11:15', '2024-02-05'),
(5, 'The Final Stand', 'All heroes unite in an epic confrontation with the Supreme Leader. The fate of all universes hangs in the balance. Who will survive?', 'res/img/heroes/promo/titan-tv.png', 'https://www.youtube.com/@FireStorm-Tri', '18:00', '2024-02-12');

-- Insert sample blog posts
INSERT INTO blog_posts (title, slug, content, excerpt, image, author, published, published_at) VALUES
('Welcome to Skibidi Madness', 'welcome-to-skibidi-madness', '<p>Welcome to the official Skibidi Madness website! We are thrilled to bring you this epic multiverse adventure.</p><p>Skibidi Madness is not just another series - it is a revolutionary fusion of multiple dimensions, timelines, and realities where heroes from different universes unite against the forces of chaos.</p>', 'Welcome to the official Skibidi Madness website! We are thrilled to bring you this epic multiverse adventure.', 'res/img/all-together.png', 'FireStormX Studios', 1, '2024-01-10 10:00:00'),
('Behind the Scenes: Creating the Titans', 'behind-the-scenes-titans', '<p>Ever wondered how we create the epic Titan characters? In this post, we take you behind the scenes of our animation process.</p><p>From concept art to final render, each Titan goes through dozens of iterations to ensure they look perfect on screen.</p>', 'Ever wondered how we create the epic Titan characters? In this post, we take you behind the scenes.', 'res/img/heroes/promo/titan-camera.png', 'FireStormX Studios', 1, '2024-01-17 14:30:00'),
('Episode 3 Preview: What to Expect', 'episode-3-preview', '<p>Episode 3 is coming soon and it''s going to be HUGE! G-Man finally discovers the truth about the Supreme Leader.</p><p>Get ready for plot twists, epic battles, and revelations that will change everything you thought you knew about the Skibidi universe.</p>', 'Episode 3 is coming soon and it is going to be HUGE! Get ready for plot twists and epic battles.', 'res/img/heroes/promo/g-man.png', 'FireStormX Studios', 1, '2024-01-25 16:00:00');
