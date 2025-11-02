<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Hero;
use App\Models\Episode;
use App\Models\BlogPost;
use App\Models\LandingContent;

class HomeController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $heroModel = new Hero();
        $episodeModel = new Episode();
        $blogModel = new BlogPost();
        $contentModel = new LandingContent();
        
        $data = [
            'heroes' => $heroModel->getAllOrdered(),
            'episodes' => $episodeModel->getAllOrdered(),
            'recentPosts' => $blogModel->getRecent(3),
            'content' => [
                'hero' => $contentModel->getBySection('hero'),
                'about' => $contentModel->getBySection('about'),
                'channel' => $contentModel->getBySection('channel'),
            ],
            'youtubeChannel' => config('youtube_channel', 'https://www.youtube.com/@FirestomX-Tri'),
        ];
        
        $this->render('home/index', $data, $response);
    }
    
    public function blog(Request $request, Response $response)
    {
        $blogModel = new BlogPost();
        
        $data = [
            'posts' => $blogModel->getAllPublished(),
        ];
        
        $this->render('home/blog', $data, $response);
    }
}
