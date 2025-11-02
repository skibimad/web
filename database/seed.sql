-- Seed data for Skibidi Madness
USE skibidi_madness;

-- Insert default admin user (password: 111111)
INSERT INTO admin_users (username, password) VALUES 
('fsx', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); -- 111111

-- Insert heroes
INSERT INTO heroes (slug, name, description, image, video, abilities, display_order) VALUES
('titan-camera', 'Titan Cameraman', 
 'The vigilant guardian with unmatched surveillance capabilities. His camera lens sees through deception and captures the truth in every battle. Armed with devastating firepower and tactical precision.',
 'res/img/heroes/promo/titan-camera.png', 
 'res/video/heroes/promo/titan-camera.mp4',
 '["Tactical Vision", "Heavy Artillery", "Combat Analysis"]', 
 1),
 
('titan-speaker', 'Titan Speakerman', 
 'Master of sonic devastation who channels raw sound energy into overwhelming force. His acoustic waves can shatter dimensions and resonate across the multiverse, disrupting enemy formations with thunderous power.',
 'res/img/heroes/promo/titan-speaker.png',
 'res/video/heroes/promo/titan-speaker.mp4',
 '["Sonic Blast", "Sound Barrier", "Resonance Strike"]',
 2),
 
('titan-tv', 'Titan TV Man', 
 'The hypnotic warrior whose screen broadcasts reality-altering frequencies. Through his display, he can control minds, project illusions, and manipulate the very perception of his enemies across all dimensions.',
 'res/img/heroes/promo/titan-tv.png',
 'res/video/heroes/promo/titan-tv.mp4',
 '["Mind Control", "Hypno Wave", "Reality Distortion"]',
 3),
 
('g-man', 'G-Man', 
 'The enigmatic leader whose true power remains shrouded in mystery. A master tactician and skilled combatant, G-Man coordinates the resistance with calculated precision, always three steps ahead of his adversaries.',
 'res/img/heroes/promo/g-man.png',
 'res/video/heroes/promo/g-man.mp4',
 '["Strategic Mastery", "Teleportation", "Energy Manipulation"]',
 4),
 
('star-storage', 'Star Storage', 
 'The cosmic keeper who harnesses stellar energy from across galaxies. With the ability to store and release concentrated star power, this hero brings celestial might to every confrontation, illuminating the darkest battles.',
 'res/img/heroes/promo/star-storage.png',
 'res/video/heroes/promo/star-storage.mp4',
 '["Stellar Energy", "Cosmic Shield", "Star Burst"]',
 5);

-- Insert episodes
INSERT INTO episodes (episode_number, title, description, thumbnail, video_url, duration, release_date, display_order) VALUES
(1, 'The Awakening', 
 'The Supreme Leader emerges from the shadows as the Asotra forces launch their first attack across multiple dimensions. The heroes must unite quickly or watch reality crumble.',
 'res/img/all-together.png',
 'https://www.youtube.com/@FirestomX-Tri',
 '10:30',
 '2024-01-15',
 1),
 
(2, 'Multiverse Mayhem', 
 'As portals tear open between Marvel, DC, and Star Wars universes, our heroes face unprecedented challenges. Allies emerge from unexpected places.',
 'res/img/heroes/promo/titan-camera.png',
 'https://www.youtube.com/@FirestomX-Tri',
 '12:45',
 '2024-01-22',
 2),
 
(3, 'The Supreme Leader Revealed', 
 'G-Man uncovers the shocking truth about the Supreme Leader\'s identity and their connection to the original Skibidi universe. Nothing will be the same.',
 'res/img/heroes/promo/g-man.png',
 'https://www.youtube.com/@FirestomX-Tri',
 '15:20',
 '2024-01-29',
 3),
 
(4, 'Sonic Showdown', 
 'Titan Speakerman faces his greatest test as the Asotra deploy weapons that target sound itself. Can he overcome this deadly silence?',
 'res/img/heroes/promo/titan-speaker.png',
 'https://www.youtube.com/@FirestomX-Tri',
 '11:15',
 '2024-02-05',
 4),
 
(5, 'Stellar Convergence', 
 'Star Storage channels the power of dying stars to create a weapon capable of sealing dimensional rifts. But at what cost?',
 'res/img/heroes/promo/star-storage.png',
 'https://www.youtube.com/@FirestomX-Tri',
 '13:50',
 '2024-02-12',
 5);

-- Insert landing page content
INSERT INTO landing_content (section, content_key, content_value, content_type) VALUES
('hero', 'title', 'SKIBIDI MADNESS', 'text'),
('hero', 'subtitle', 'A New Era of Chaos Begins', 'text'),
('hero', 'description', 'Dive into an epic multiverse where heroes unite against the forces of chaos. From the depths of the Skibidi universe to the realms of Marvel, DC, Star Wars, and beyond.', 'text'),
('hero', 'video', 'res/video/all-together.mp4', 'video'),

('about', 'title', 'The Story Unfolds', 'text'),
('about', 'subtitle', 'A New Chapter in the Skibidi Universe', 'text'),
('about', 'paragraph1', 'Welcome to <strong>Skibidi Madness</strong> - an extraordinary animation series created by FireStormX Studios that transcends the boundaries of the original Skibidi Toilet universe. This isn\'t just another story; it\'s a revolutionary fusion of multiple dimensions, timelines, and realities.', 'text'),
('about', 'paragraph2', 'In this new saga, witness the unprecedented chaos unleashed by the malevolent forces known as the <strong>Asotra</strong>. Unlike previous battles against entire armies, our heroes now face their most formidable adversary yet - the mysterious and powerful <strong>Supreme Leader</strong>, whose ambitions threaten not just one universe, but the entire multiverse fabric.', 'text'),
('about', 'paragraph3', 'Skibidi Madness weaves together elements from beloved franchises including Marvel\'s cosmic battles, the supernatural mysteries of Stranger Things, DC\'s legendary heroes, the epic space opera of Star Wars, the blocky realms of Minecraft, and countless other dimensions. This is where everything you love collides in spectacular fashion.', 'text'),
('about', 'image', 'res/img/all-together.png', 'image'),

('channel', 'title', 'Join the FireStormX Community', 'text'),
('channel', 'description', 'Subscribe to FireStormX Studios on YouTube to never miss an episode of Skibidi Madness! Get exclusive behind-the-scenes content, character reveals, and be part of the growing community of fans exploring the multiverse.', 'text'),
('channel', 'video', 'res/video/all-together.mp4', 'video');
