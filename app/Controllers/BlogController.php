<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\BlogPost;

/**
 * Blog Controller
 * Handles public blog pages
 */
class BlogController extends Controller {
    
    public function index() {
        $blogModel = new BlogPost();
        $posts = $blogModel->findPublished();
        
        $this->view('blog/index', [
            'posts' => $posts,
            'content' => $this->getStaticContent()
        ]);
    }
    
    public function show($slug) {
        $blogModel = new BlogPost();
        $post = $blogModel->findBySlug($slug);
        
        if (!$post) {
            Response::notFound();
        }
        
        $this->view('blog/show', [
            'post' => $post,
            'content' => $this->getStaticContent()
        ]);
    }
}
