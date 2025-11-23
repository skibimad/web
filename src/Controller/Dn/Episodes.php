<?php

namespace App\Controller\Dn;

use App\Controller\DnController;
use App\Core\Model\CollectionInterface;
use App\Model\Episode;

class Episodes extends DnController
{
    public function handle(): void
    {

        $this->render(
            'admin/episodes',
            [
                'episodes' => $this->getPEpisodes()
            ]
        );
    }

    protected function getPEpisodes()
    {
        $episodeCollection = (new Episode())
            ->getCollection()
            ->setItemMode(CollectionInterface::ITEM_MODE_OBJECT)
            ->sort('created_at', 'DESC');

        return $episodeCollection;
    }
}
