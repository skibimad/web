<?php
/**
 * Database Seeder - Populate with Demo Data
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Security.php';

echo "Initializing Skibidi Madness database...\n";

$db = Database::getInstance();

// Read and execute schema
$schema = file_get_contents(__DIR__ . '/schema.sql');
$db->getConnection()->exec($schema);
echo "✓ Schema created\n";

// Insert admin user (fsx/111111)
$hashedPassword = Security::hashPassword('111111');
$db->execute("INSERT OR REPLACE INTO users (id, username, password) VALUES (1, 'fsx', ?)", [$hashedPassword]);
echo "✓ Admin user created (fsx/111111)\n";

// Insert heroes
$heroes = [
    [
        'name' => 'Titan Cameraman',
        'slug' => 'titan-cameraman',
        'description' => 'The vigilant guardian with unmatched surveillance capabilities. His camera lens sees through deception and captures the truth in every battle. Armed with powerful weaponry and tactical vision, Titan Cameraman leads the charge against the Asotra forces.',
        'image_path' => 'res/img/heroes/promo/TitanCameraman.png',
        'video_path' => 'res/video/heroes/promo/TitanCameraman.mp4',
        'ability1' => 'Tactical Vision',
        'ability2' => 'Heavy Artillery',
        'ability3' => 'Combat Analysis',
        'display_order' => 1
    ],
    [
        'name' => 'Titan Speakerman',
        'slug' => 'titan-speakerman',
        'description' => 'Master of sonic devastation who channels raw sound energy into overwhelming force. His acoustic waves can shatter dimensions and resonate across the multiverse. A formidable warrior whose power grows with every battle cry.',
        'image_path' => 'res/img/heroes/promo/TitanSpeakerman.png',
        'video_path' => 'res/video/heroes/promo/TitanSpeakerman.mp4',
        'ability1' => 'Sonic Blast',
        'ability2' => 'Sound Barrier',
        'ability3' => 'Resonance Strike',
        'display_order' => 2
    ],
    [
        'name' => 'Titan TV Man',
        'slug' => 'titan-tv-man',
        'description' => 'The hypnotic warrior whose screen broadcasts reality-altering frequencies. Through his display, he can control minds, project illusions, and manipulate the fabric of perception itself. A mysterious force that bends reality to his will.',
        'image_path' => 'res/img/heroes/promo/TitanTVMan.png',
        'video_path' => 'res/video/heroes/promo/TitanTVMan.mp4',
        'ability1' => 'Mind Control',
        'ability2' => 'Hypno Wave',
        'ability3' => 'Reality Distortion',
        'display_order' => 3
    ],
    [
        'name' => 'G-Man',
        'slug' => 'g-man',
        'description' => 'The enigmatic leader whose true power remains shrouded in mystery. A master tactician and skilled combatant, G-Man coordinates the resistance with calculated precision. His strategic genius and hidden abilities make him a formidable commander.',
        'image_path' => 'res/img/heroes/promo/G-Man.png',
        'video_path' => 'res/video/heroes/promo/G-Man.mp4',
        'ability1' => 'Strategic Mastery',
        'ability2' => 'Teleportation',
        'ability3' => 'Energy Manipulation',
        'display_order' => 4
    ],
    [
        'name' => 'Star Storage',
        'slug' => 'star-storage',
        'description' => 'The cosmic keeper who harnesses stellar energy from across galaxies. With the ability to store and release concentrated star power, this hero brings cosmic destruction to enemies. A celestial force that channels the universe itself.',
        'image_path' => 'res/img/heroes/promo/StarStorage.png',
        'video_path' => 'res/video/heroes/promo/StarStorage.mp4',
        'ability1' => 'Stellar Energy',
        'ability2' => 'Cosmic Shield',
        'ability3' => 'Star Burst',
        'display_order' => 5
    ]
];

foreach ($heroes as $hero) {
    $db->execute("INSERT OR REPLACE INTO heroes (name, slug, description, image_path, video_path, ability1, ability2, ability3, display_order) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", 
                  array_values($hero));
}
echo "✓ " . count($heroes) . " heroes added\n";

// Insert episodes
$episodes = [
    [
        'episode_number' => 1,
        'title' => 'The Awakening',
        'description' => 'When the Asotra forces emerge from the depths, our heroes must unite for the first time. Witness the beginning of an epic saga as Titan Cameraman discovers the true scale of the threat facing all realities.',
        'thumbnail_path' => 'res/img/episodes/episode1.jpg',
        'youtube_url' => 'https://www.youtube.com/@FireStormX',
        'duration' => '12:34',
        'release_date' => '2024-01-15'
    ],
    [
        'episode_number' => 2,
        'title' => 'Multiverse Mayhem',
        'description' => 'The battle expands beyond dimensions as heroes from Marvel, DC, and Star Wars join the fight. Titan Speakerman unleashes his full sonic power against an army that threatens to consume all universes.',
        'thumbnail_path' => 'res/img/episodes/episode2.jpg',
        'youtube_url' => 'https://www.youtube.com/@FireStormX',
        'duration' => '15:22',
        'release_date' => '2024-02-01'
    ],
    [
        'episode_number' => 3,
        'title' => 'Supreme Leader Revealed',
        'description' => 'The mysterious Supreme Leader finally shows his face. Titan TV Man must use his reality-bending powers to uncover the truth behind the Asotra invasion and their ultimate goal.',
        'thumbnail_path' => 'res/img/episodes/episode3.jpg',
        'youtube_url' => 'https://www.youtube.com/@FireStormX',
        'duration' => '18:45',
        'release_date' => '2024-02-15'
    ],
    [
        'episode_number' => 4,
        'title' => 'Sonic Showdown',
        'description' => 'An all-out sonic battle erupts as Titan Speakerman faces his greatest challenge yet. The fate of the multiverse hangs in the balance as sound itself becomes a weapon of mass destruction.',
        'thumbnail_path' => 'res/img/episodes/episode4.jpg',
        'youtube_url' => 'https://www.youtube.com/@FireStormX',
        'duration' => '14:56',
        'release_date' => '2024-03-01'
    ],
    [
        'episode_number' => 5,
        'title' => 'Stellar Convergence',
        'description' => 'Star Storage taps into the power of a thousand stars to deliver the final blow. But victory comes at a price as our heroes discover the true nature of their cosmic enemy.',
        'thumbnail_path' => 'res/img/episodes/episode5.jpg',
        'youtube_url' => 'https://www.youtube.com/@FireStormX',
        'duration' => '20:12',
        'release_date' => '2024-03-15'
    ]
];

foreach ($episodes as $episode) {
    $db->execute("INSERT OR REPLACE INTO episodes (episode_number, title, description, thumbnail_path, youtube_url, duration, release_date) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)", 
                  array_values($episode));
}
echo "✓ " . count($episodes) . " episodes added\n";

// Insert static content
$staticContent = [
    ['hero_title', 'SKIBIDI MADNESS'],
    ['hero_subtitle', 'A New Era of Chaos Begins'],
    ['hero_description', 'Dive into an epic multiverse where heroes unite against the forces of chaos. From the depths of the Skibidi universe to the realms of Marvel, DC, Star Wars, and beyond.'],
    ['hero_video', 'res/video/all-together.mp4'],
    ['about_title', 'The Story of Skibidi Madness'],
    ['about_subtitle', 'Where Chaos Meets Destiny'],
    ['about_paragraph1', 'A new story and new adventures from the original series. It will show the Chaos and anger of the villains called "Asotra". In this new story, the main enemy is not an entire army, but the so-called "Supreme Leader".'],
    ['about_paragraph2', 'The new series is not only about the Skibidi Toilet universe from various stories like DOM Studio, Virlance, or Maxedy. In the new story, Skibidi Madness will include everything that exists: Marvel, Stranger Things, DC, Star Wars, Minecraft, and much more.'],
    ['about_paragraph3', 'Join our heroes as they battle across dimensions, facing threats that challenge the very fabric of reality. Every episode brings new revelations, epic battles, and unexpected alliances in the fight against the Asotra forces.'],
    ['about_image', 'res/img/all-together.png']
];

foreach ($staticContent as $content) {
    $db->execute("INSERT OR REPLACE INTO static_content (content_key, content_value) VALUES (?, ?)", $content);
}
echo "✓ Static content added\n";

echo "\n✅ Database initialization complete!\n";
echo "Admin credentials: fsx / 111111\n";
echo "Database location: " . DB_PATH . "\n";
