<?php

namespace App\Controller\Dn\Episode;

use App\Controller\DnController;
use App\Core\Model\CollectionInterface;
use App\Model\BlogPost;
use App\Model\Episode;

class Delete extends DnController
{
    public function handle(): void
    {
        if ($this->getRequest()->isGet()) {
            $this->deleteEpisode();
        }
        $this->redirectReferer();
    }

    protected function getEpisode(): Episode
    {
        return new Episode();
    }

    protected function deleteEpisode()
    {
        $episode = new Episode();

        $episode->load($this->getRequest('id'));
        if (!$episode->getId()) {
            throw new \Exception('Episode not found');
        }
        
        $episode->delete($this->getRequest('id'));
    }
    
}
