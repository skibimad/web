<?php

namespace App\Controller\Dn\Blog;

use App\Controller\DnController;
use App\Core\Model\CollectionInterface;
use App\Model\BlogPost;

class Delete extends DnController
{
    public function handle(): void
    {
        //try {
            $this->deletePost();

        //} catch (\Throwable) {
            $this->redirect('/admin/blog');
        //}


    }

    protected function deletePost()
    {
        $postId = $this->getRequest()->query('id');
        $post = new BlogPost();
        $post->delete($postId);

    }

    protected function assertValid(array $data)
    {
        return true;
    }

    
}
