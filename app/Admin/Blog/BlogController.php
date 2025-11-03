<?php

namespace App\Admin\Blog;

use App\Core\Controller;
use App\Core\Request;
use App\Models\BlogPost;

/**
 * Admin Blog List Controller
 */
class BlogController extends Controller
{
    public function handle(Request $request): void
    {
        $posts = BlogPost::all();
        
        $this->view('admin/blog/list', [
            'posts' => $posts
        ]);
    }
}
