<?php

namespace App\Controller\Dn;

use App\Controller\DnController;
use App\Model\BlogPost;

class Index extends DnController
{
    public function handle(): void
    {
        $blogs = (new BlogPost())->getCollection();

        $this->render(
            'admin/dashboard',
            [
                'blogCount' => $blogs->count(),
                'heroCount' => $this->getHeroCount(),
                'episodeCount' => $this->getEpisodeCount(),
                'youtubeStats' => $this->getYoutubeStats(),
            ]
        );
    }

    protected function getHeroCount(): int
    {
        $heroes = (new \App\Model\Hero())->getCollection();
        return $heroes->count();
    }

    protected function getEpisodeCount(): int
    {
        $episodes = (new \App\Model\Episode())->getCollection();
        return $episodes->count();
    }

    protected function getYoutubeStats(): array
    {
        return [
            'day' => 100,
            'week' => 500,
            'month' => 2000,
            'year' => 24000,
        ];
    }
}
