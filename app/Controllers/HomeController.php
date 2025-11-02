<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Hero;
use App\Models\Episode;
use App\Models\BlogPost;

/**
 * Home Controller
 * Handles main landing page
 */
class HomeController extends Controller {
    
    public function index() {
        $heroModel = new Hero();
        $episodeModel = new Episode();
        $blogModel = new BlogPost();
        
        $data = [
            'heroes' => $heroModel->findAll(),
            'episodes' => $episodeModel->findAll(),
            'blogPosts' => $blogModel->findPublished(3),
            'content' => $this->getStaticContent()
        ];
        
        $this->view('home/index', $data);
    }
}
