<?php

namespace Database\Seeders;

use App\Models\Hero;
use Illuminate\Database\Seeder;

class HeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $heroes = [
            [
                'name' => 'Titan Cameraman',
                'slug' => 'titan-camera',
                'description' => 'The vigilant guardian with unmatched surveillance capabilities. His camera lens sees through deception and captures the truth in every battle. Armed with devastating firepower and tactical precision.',
                'image_path' => 'res/img/heroes/promo/titan-camera.png',
                'video_path' => 'res/video/heroes/promo/titan-camera.mp4',
                'abilities' => ['Tactical Vision', 'Heavy Artillery', 'Combat Analysis'],
                'order' => 1,
                'active' => true,
            ],
            [
                'name' => 'Titan Speakerman',
                'slug' => 'titan-speaker',
                'description' => 'Master of sonic devastation who channels raw sound energy into overwhelming force. His acoustic waves can shatter dimensions and resonate across the multiverse, disrupting enemy formations with thunderous power.',
                'image_path' => 'res/img/heroes/promo/titan-speaker.png',
                'video_path' => 'res/video/heroes/promo/titan-speaker.mp4',
                'abilities' => ['Sonic Blast', 'Sound Barrier', 'Resonance Strike'],
                'order' => 2,
                'active' => true,
            ],
            [
                'name' => 'Titan TV Man',
                'slug' => 'titan-tv',
                'description' => 'The hypnotic warrior whose screen broadcasts reality-altering frequencies. Through his display, he can control minds, project illusions, and manipulate the very perception of his enemies across all dimensions.',
                'image_path' => 'res/img/heroes/promo/titan-tv.png',
                'video_path' => 'res/video/heroes/promo/titan-tv.mp4',
                'abilities' => ['Mind Control', 'Hypno Wave', 'Reality Distortion'],
                'order' => 3,
                'active' => true,
            ],
            [
                'name' => 'G-Man',
                'slug' => 'g-man',
                'description' => 'The enigmatic leader whose true power remains shrouded in mystery. A master tactician and skilled combatant, G-Man coordinates the resistance with calculated precision, always three steps ahead of his adversaries.',
                'image_path' => 'res/img/heroes/promo/g-man.png',
                'video_path' => 'res/video/heroes/promo/g-man.mp4',
                'abilities' => ['Strategic Mastery', 'Teleportation', 'Energy Manipulation'],
                'order' => 4,
                'active' => true,
            ],
            [
                'name' => 'Star Storage',
                'slug' => 'star-storage',
                'description' => 'The cosmic keeper who harnesses stellar energy from across galaxies. With the ability to store and release concentrated star power, this hero brings celestial might to every confrontation, illuminating the darkest battles.',
                'image_path' => 'res/img/heroes/promo/star-storage.png',
                'video_path' => 'res/video/heroes/promo/star-storage.mp4',
                'abilities' => ['Stellar Energy', 'Cosmic Shield', 'Star Burst'],
                'order' => 5,
                'active' => true,
            ],
        ];

        foreach ($heroes as $hero) {
            Hero::create($hero);
        }
    }
}
