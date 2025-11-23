<?php
namespace App\Controller\Blog;

use App\Core\Controller;
use App\Core\Model\Collection;
use App\Model\BlogPost;

class Index extends Controller
{
    public function handle(): void
    {
        $this->render('blog/index', [
            'blogPosts' => $this->getBlogPosts(),
        ]);
        
    }

    /**
     * Retrieve blog posts collection
     *
     * @return Collection
     */
    protected function getBlogPosts(): Collection
    {
        $blogPostsCollection = (new BlogPost())
            ->getCollection()
            ->addFilter(['published' => 1])
            ->sort('created_at', 'DESC')
            ->setItemMode(Collection::ITEM_MODE_OBJECT)
            //->setPageSize(5)
            ;

        return $blogPostsCollection;
    }


}