<?php

namespace App\Controller\Dn;

use App\Controller\DnController;
use App\Core\Model\CollectionInterface;

class Blog extends DnController
{
    public function handle(): void
    {

        $this->render(
            'admin/blog',
            [
                'posts' => $this->getPosts()
            ]
        );
    }

    protected function getPosts()
    {
        $blogPostsCollection = (new \App\Model\BlogPost())
            ->getCollection()
            ->setItemMode(CollectionInterface::ITEM_MODE_OBJECT)
            ->sort('created_at', 'DESC');

        return $blogPostsCollection;
    }
}
