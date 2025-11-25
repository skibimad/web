<?php
/**
 * Migration: Create landing_page_content table for managing home page sections
 * Version: 1.0.3
 */

use App\Core\Database;

$pdo = Database::connect();

// Create the landing_page_content table (DDL cannot be in a transaction)
$pdo->exec("
    CREATE TABLE IF NOT EXISTS `landing_page_content` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `section` varchar(50) NOT NULL,
        `field_key` varchar(100) NOT NULL,
        `field_value` text DEFAULT NULL,
        `field_type` enum('string','rich','image') NOT NULL DEFAULT 'string',
        `created_at` timestamp NULL DEFAULT current_timestamp(),
        `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`id`),
        UNIQUE KEY `section_field` (`section`, `field_key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");

// Insert default content using prepared statements (handles special characters properly)
$stmt = $pdo->prepare("
    INSERT INTO `landing_page_content` (`section`, `field_key`, `field_value`, `field_type`) 
    VALUES (:section, :field_key, :field_value, :field_type)
");

// Home Section
$stmt->execute([
    'section' => 'home',
    'field_key' => 'hero_subtitle',
    'field_value' => 'A New Era of Chaos Begins',
    'field_type' => 'string'
]);

$stmt->execute([
    'section' => 'home',
    'field_key' => 'hero_description',
    'field_value' => 'Dive into an epic multiverse where heroes unite against the forces of chaos. From the depths of the Skibidi universe to the realms of Marvel, DC, Star Wars, and beyond.',
    'field_type' => 'rich'
]);

// About Section
$stmt->execute([
    'section' => 'about',
    'field_key' => 'title',
    'field_value' => 'The Story Unfolds',
    'field_type' => 'string'
]);

$aboutText = '<h3>A New Chapter in the Skibidi Universe</h3>
<p>
    Welcome to <strong>Skibidi Madness</strong> - an extraordinary animation series created by FireStormX Studios 
    that transcends the boundaries of the original Skibidi Toilet universe. This isn\'t just another story; 
    it\'s a revolutionary fusion of multiple dimensions, timelines, and realities. It\'s a celebration of creativity, imagination, and the limitless possibilities 
    of storytelling.
</p>
<p>
    In this new saga, witness the unprecedented chaos unleashed by the malevolent forces known as the 
    <strong>Asotra</strong>. Unlike previous battles against entire armies, our heroes now face their 
    most formidable adversary yet - the mysterious and powerful <strong>Supreme Leader</strong>, 
    whose ambitions threaten not just one universe, but the entire multiverse fabric.
</p>
<p>
    Skibidi Madness weaves together elements from beloved franchises including Marvel\'s cosmic battles, 
    the supernatural mysteries of Stranger Things, DC\'s legendary heroes, the epic space opera of Star Wars, 
    the blocky realms of Minecraft, and countless other dimensions. This is where everything you love 
    collides in spectacular fashion.
</p>';

$stmt->execute([
    'section' => 'about',
    'field_key' => 'about_text',
    'field_value' => $aboutText,
    'field_type' => 'rich'
]);

// About Section - Image (default to existing static image path)
$stmt->execute([
    'section' => 'about',
    'field_key' => 'image',
    'field_value' => '/public/media/img/all-together.png',
    'field_type' => 'image'
]);

// Episodes Section
$stmt->execute([
    'section' => 'episodes',
    'field_key' => 'title',
    'field_value' => 'Featured Episodes',
    'field_type' => 'string'
]);

$stmt->execute([
    'section' => 'episodes',
    'field_key' => 'subtitle',
    'field_value' => 'Watch the epic battles and witness the chaos unfold',
    'field_type' => 'rich'
]);

// Heroes Section
$stmt->execute([
    'section' => 'heroes',
    'field_key' => 'title',
    'field_value' => 'The Legendary Heroes',
    'field_type' => 'string'
]);

$stmt->execute([
    'section' => 'heroes',
    'field_key' => 'subtitle',
    'field_value' => 'Meet the champions who stand between order and absolute chaos',
    'field_type' => 'rich'
]);

// Channel Section
$stmt->execute([
    'section' => 'channel',
    'field_key' => 'title',
    'field_value' => 'Join the FireStormX Community',
    'field_type' => 'string'
]);

$stmt->execute([
    'section' => 'channel',
    'field_key' => 'subtitle',
    'field_value' => 'Subscribe to FireStormX Studios on YouTube to never miss an episode of Skibidi Madness! Get exclusive behind-the-scenes content, character reveals, and be part of the growing community of fans exploring the multiverse.',
    'field_type' => 'rich'
]);

return true;
