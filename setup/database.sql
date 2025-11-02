-- Skibidi Madness Database Schema
-- Create database and tables

CREATE DATABASE IF NOT EXISTS skibidi_madness CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE skibidi_madness;

-- Users table for admin authentication
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Heroes table
CREATE TABLE IF NOT EXISTS heroes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    video VARCHAR(255),
    abilities JSON,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Episodes table
CREATE TABLE IF NOT EXISTS episodes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    episode_number INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    thumbnail VARCHAR(255),
    video_url VARCHAR(500),
    duration VARCHAR(20),
    release_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Blog posts table
CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content TEXT,
    excerpt TEXT,
    image VARCHAR(255),
    author VARCHAR(100) DEFAULT 'FireStormX Studios',
    published BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Landing page content table
CREATE TABLE IF NOT EXISTS landing_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section VARCHAR(50) UNIQUE NOT NULL,
    title VARCHAR(255),
    subtitle VARCHAR(255),
    content TEXT,
    image VARCHAR(255),
    video VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user (password: 111111, hashed with bcrypt)
INSERT INTO users (username, password) VALUES 
('fsx', '$2y$10$sHd5IYqchqigS8C8YqYO6.VFKmUDi7jEWnn1CR8fEDiO1oQV26Uza');
-- Note: This is a bcrypt hash of '111111'

-- Insert demo heroes
INSERT INTO heroes (slug, name, description, image, video, abilities, display_order) VALUES
('titan-camera', 'Titan Cameraman', 'The vigilant guardian with unmatched surveillance capabilities. His camera lens sees through deception and captures the truth in every battle. Armed with devastating firepower and tactical precision.', 'res/img/heroes/promo/titan-camera.png', 'res/video/heroes/promo/titan-camera.mp4', '["Tactical Vision", "Heavy Artillery", "Combat Analysis"]', 1),
('titan-speaker', 'Titan Speakerman', 'Master of sonic devastation who channels raw sound energy into overwhelming force. His acoustic waves can shatter dimensions and resonate across the multiverse, disrupting enemy formations with thunderous power.', 'res/img/heroes/promo/titan-speaker.png', 'res/video/heroes/promo/titan-speaker.mp4', '["Sonic Blast", "Sound Barrier", "Resonance Strike"]', 2),
('titan-tv', 'Titan TV Man', 'The hypnotic warrior whose screen broadcasts reality-altering frequencies. Through his display, he can control minds, project illusions, and manipulate the very perception of his enemies across all dimensions.', 'res/img/heroes/promo/titan-tv.png', 'res/video/heroes/promo/titan-tv.mp4', '["Mind Control", "Hypno Wave", "Reality Distortion"]', 3),
('g-man', 'G-Man', 'The enigmatic leader whose true power remains shrouded in mystery. A master tactician and skilled combatant, G-Man coordinates the resistance with calculated precision, always three steps ahead of his adversaries.', 'res/img/heroes/promo/g-man.png', 'res/video/heroes/promo/g-man.mp4', '["Strategic Mastery", "Teleportation", "Energy Manipulation"]', 4),
('star-storage', 'Star Storage', 'The cosmic keeper who harnesses stellar energy from across galaxies. With the ability to store and release concentrated star power, this hero brings celestial might to every confrontation, illuminating the darkest battles.', 'res/img/heroes/promo/star-storage.png', 'res/video/heroes/promo/star-storage.mp4', '["Stellar Energy", "Cosmic Shield", "Star Burst"]', 5);

-- Insert demo episodes
INSERT INTO episodes (episode_number, title, description, thumbnail, video_url, duration, release_date) VALUES
(1, 'The Awakening', 'The Supreme Leader emerges from the shadows as the Asotra forces launch their first attack across multiple dimensions. The heroes must unite quickly or watch reality crumble.', 'res/img/all-together.png', 'https://www.youtube.com/@FirestomX-Tri', '10:30', '2024-01-15'),
(2, 'Multiverse Mayhem', 'As portals tear open between Marvel, DC, and Star Wars universes, our heroes face unprecedented challenges. Allies emerge from unexpected places.', 'res/img/heroes/promo/titan-camera.png', 'https://www.youtube.com/@FirestomX-Tri', '12:45', '2024-01-22'),
(3, 'The Supreme Leader Revealed', 'G-Man uncovers the shocking truth about the Supreme Leader\'s identity and their connection to the original Skibidi universe. Nothing will be the same.', 'res/img/heroes/promo/g-man.png', 'https://www.youtube.com/@FirestomX-Tri', '15:20', '2024-01-29'),
(4, 'Sonic Showdown', 'Titan Speakerman faces his greatest test as the Asotra deploy weapons that target sound itself. Can he overcome this deadly silence?', 'res/img/heroes/promo/titan-speaker.png', 'https://www.youtube.com/@FirestomX-Tri', '11:15', '2024-02-05'),
(5, 'Stellar Convergence', 'Star Storage channels the power of dying stars to create a weapon capable of sealing dimensional rifts. But at what cost?', 'res/img/heroes/promo/star-storage.png', 'https://www.youtube.com/@FirestomX-Tri', '13:50', '2024-02-12');

-- Insert demo blog posts
INSERT INTO blog_posts (title, slug, content, excerpt, image, author, published) VALUES
('Welcome to Skibidi Madness', 'welcome-to-skibidi-madness', 'Welcome to the official Skibidi Madness universe! This new saga brings together heroes from across dimensions in an epic battle against the forces of chaos. Stay tuned for exclusive content, behind-the-scenes updates, and much more!', 'Welcome to the official Skibidi Madness universe! This new saga brings together heroes from across dimensions.', 'res/img/all-together.png', 'FireStormX Studios', TRUE),
('Meet the Heroes', 'meet-the-heroes', 'Get to know the legendary heroes of Skibidi Madness. From Titan Cameraman to Star Storage, each hero brings unique abilities and strengths to the fight against the Supreme Leader.', 'Get to know the legendary heroes of Skibidi Madness and their unique abilities.', 'res/img/heroes/promo/titan-camera.png', 'FireStormX Studios', TRUE),
('Behind the Scenes', 'behind-the-scenes', 'Ever wondered how Skibidi Madness is made? Dive into the creative process and learn about the animation techniques, story development, and production secrets.', 'Dive into the creative process behind Skibidi Madness animation.', 'res/img/heroes/promo/g-man.png', 'FireStormX Studios', TRUE);

-- Insert landing page content
INSERT INTO landing_content (section, title, subtitle, content) VALUES
('hero', 'SKIBIDI MADNESS', 'A New Era of Chaos Begins', 'Dive into an epic multiverse where heroes unite against the forces of chaos. From the depths of the Skibidi universe to the realms of Marvel, DC, Star Wars, and beyond.'),
('about', 'The Story Unfolds', 'A New Chapter in the Skibidi Universe', 'Welcome to Skibidi Madness - an extraordinary animation series created by FireStormX Studios that transcends the boundaries of the original Skibidi Toilet universe.'),
('channel', 'Join the FirestomX-Tri Community', 'Subscribe to our channel', 'Subscribe to FirestomX-Tri on YouTube to never miss an episode of Skibidi Madness! Get exclusive behind-the-scenes content, character reveals, and be part of the growing community.');
