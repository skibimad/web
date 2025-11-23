<?php

namespace App\Controller\Dn\Blog;

use App\Controller\DnController;
use App\Core\Model\CollectionInterface;
use App\Model\BlogPost;

class Add extends DnController
{
    public function handle(): void
    {
        $this->render(
            'admin/blog/post',
            [
                'post' => $this->getPost()
            ]
        );
    }
    
    protected function getPost()
    {
        return new BlogPost();
    }

    
}
