<?php

namespace App\Controller\Dn\Episode;

use App\Controller\DnController;
use App\Core\Model\CollectionInterface;
use App\Model\BlogPost;
use App\Model\Episode;

class Add extends DnController
{
    public function handle(): void
    {
        $this->render(
            'admin/episode/form',
            [
                'episode' => $this->getEpisode()
            ]
        );
    }

    protected function getEpisode(): Episode
    {
        return new Episode();
    }

    
}
