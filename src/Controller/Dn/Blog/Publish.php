<?php

namespace App\Controller\Dn\Blog;

use App\Controller\DnController;
use App\Core\Model\CollectionInterface;
use App\Model\BlogPost;

class Publish extends DnController
{
    public function handle(): void
    {
        //try {
            $this->publishPost();

        //} catch (\Throwable) {
            $this->redirectReferer();
        //}


    }

    protected function publishPost()
    {
        $postId = $this->getRequest()->query('id');
        $post = new BlogPost();
        $post->load($postId);
        $post->publish();

    }

    protected function assertValid(array $data)
    {
        return true;
    }

    
}
