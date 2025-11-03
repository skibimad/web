<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\BlogPost;

/**
 * Blog Controller
 */
class BlogController extends Controller
{
    public function handle(Request $request): void
    {
        $posts = BlogPost::published();
        
        $this->view('blog', [
            'posts' => $posts
        ]);
    }
}
