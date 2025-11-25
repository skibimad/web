-- Migration: Create landing_page_content table for managing home page sections
-- Version: 1.0.3

CREATE TABLE `landing_page_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(50) NOT NULL,
  `field_key` varchar(100) NOT NULL,
  `field_value` text DEFAULT NULL,
  `field_type` enum('string','rich') NOT NULL DEFAULT 'string',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `section_field` (`section`, `field_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default content extracted from existing home.phtml

-- Home Section
INSERT INTO `landing_page_content` (`section`, `field_key`, `field_value`, `field_type`) VALUES
('home', 'hero_subtitle', 'A New Era of Chaos Begins', 'string'),
('home', 'hero_description', 'Dive into an epic multiverse where heroes unite against the forces of chaos. From the depths of the Skibidi universe to the realms of Marvel, DC, Star Wars, and beyond.', 'rich');

-- About Section
INSERT INTO `landing_page_content` (`section`, `field_key`, `field_value`, `field_type`) VALUES
('about', 'title', 'The Story Unfolds', 'string'),
('about', 'about_text', '<h3>A New Chapter in the Skibidi Universe</h3>
<p>
    Welcome to <strong>Skibidi Madness</strong> - an extraordinary animation series created by FireStormX Studios 
    that transcends the boundaries of the original Skibidi Toilet universe. This isn''t just another story; 
    it''s a revolutionary fusion of multiple dimensions, timelines, and realities. It''s a celebration of creativity, imagination, and the limitless possibilities 
    of storytelling.
</p>
<p>
    In this new saga, witness the unprecedented chaos unleashed by the malevolent forces known as the 
    <strong>Asotra</strong>. Unlike previous battles against entire armies, our heroes now face their 
    most formidable adversary yet - the mysterious and powerful <strong>Supreme Leader</strong>, 
    whose ambitions threaten not just one universe, but the entire multiverse fabric.
</p>
<p>
    Skibidi Madness weaves together elements from beloved franchises including Marvel''s cosmic battles, 
    the supernatural mysteries of Stranger Things, DC''s legendary heroes, the epic space opera of Star Wars, 
    the blocky realms of Minecraft, and countless other dimensions. This is where everything you love 
    collides in spectacular fashion.
</p>', 'rich');

-- Episodes Section
INSERT INTO `landing_page_content` (`section`, `field_key`, `field_value`, `field_type`) VALUES
('episodes', 'title', 'Featured Episodes', 'string'),
('episodes', 'subtitle', 'Watch the epic battles and witness the chaos unfold', 'rich');

-- Heroes Section
INSERT INTO `landing_page_content` (`section`, `field_key`, `field_value`, `field_type`) VALUES
('heroes', 'title', 'The Legendary Heroes', 'string'),
('heroes', 'subtitle', 'Meet the champions who stand between order and absolute chaos', 'rich');

-- Channel Section
INSERT INTO `landing_page_content` (`section`, `field_key`, `field_value`, `field_type`) VALUES
('channel', 'title', 'Join the FireStormX Community', 'string'),
('channel', 'subtitle', 'Subscribe to FireStormX Studios on YouTube to never miss an episode of Skibidi Madness! Get exclusive behind-the-scenes content, character reveals, and be part of the growing community of fans exploring the multiverse.', 'rich');
