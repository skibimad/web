<?php

namespace Database\Seeders;

use App\Models\Episode;
use Illuminate\Database\Seeder;

class EpisodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $episodes = [
            [
                'title' => 'Episode 1: The Awakening',
                'slug' => 'episode-1-the-awakening',
                'description' => 'The Supreme Leader emerges from the shadows as the Asotra forces launch their first attack across multiple dimensions. The heroes must unite quickly or watch reality crumble.',
                'thumbnail' => 'res/img/all-together.png',
                'video_url' => 'https://www.youtube.com/@FireStormX!?',
                'episode_number' => 1,
                'published_at' => now(),
                'featured' => true,
            ],
            [
                'title' => 'Episode 2: Multiverse Mayhem',
                'slug' => 'episode-2-multiverse-mayhem',
                'description' => 'As portals tear open between Marvel, DC, and Star Wars universes, our heroes face unprecedented challenges. Allies emerge from unexpected places.',
                'thumbnail' => 'res/img/heroes/promo/titan-camera.png',
                'video_url' => 'https://www.youtube.com/@FireStormX!?',
                'episode_number' => 2,
                'published_at' => now(),
                'featured' => false,
            ],
            [
                'title' => 'Episode 3: The Supreme Leader Revealed',
                'slug' => 'episode-3-the-supreme-leader-revealed',
                'description' => 'G-Man uncovers the shocking truth about the Supreme Leader\'s identity and their connection to the original Skibidi universe. Nothing will be the same.',
                'thumbnail' => 'res/img/heroes/promo/g-man.png',
                'video_url' => 'https://www.youtube.com/@FireStormX!?',
                'episode_number' => 3,
                'published_at' => now(),
                'featured' => false,
            ],
            [
                'title' => 'Episode 4: Sonic Showdown',
                'slug' => 'episode-4-sonic-showdown',
                'description' => 'Titan Speakerman faces his greatest test as the Asotra deploy weapons that target sound itself. Can he overcome this deadly silence?',
                'thumbnail' => 'res/img/heroes/promo/titan-speaker.png',
                'video_url' => 'https://www.youtube.com/@FireStormX!?',
                'episode_number' => 4,
                'published_at' => now(),
                'featured' => false,
            ],
            [
                'title' => 'Episode 5: Stellar Convergence',
                'slug' => 'episode-5-stellar-convergence',
                'description' => 'Star Storage channels the power of dying stars to create a weapon capable of sealing dimensional rifts. But at what cost?',
                'thumbnail' => 'res/img/heroes/promo/star-storage.png',
                'video_url' => 'https://www.youtube.com/@FireStormX!?',
                'episode_number' => 5,
                'published_at' => now(),
                'featured' => false,
            ],
        ];

        foreach ($episodes as $episode) {
            Episode::create($episode);
        }
    }
}
