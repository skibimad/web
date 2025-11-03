<?php

namespace App\Admin\Blog;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;
use App\Models\BlogPost;

/**
 * Add New Blog Post Controller
 */
class AddController extends Controller
{
    public function handle(Request $request): void
    {
        // Require authentication
        $auth = new Auth();
        $auth->require();
        
        if ($request->isPost()) {
            $post = new BlogPost();
            $post->title = $request->post('title');
            $post->content = $request->post('content');
            $post->image = $request->post('image');
            $post->excerpt = $request->post('excerpt');
            $post->published = (int)$request->post('published', 0);
            $post->archived = 0;
            
            if ($post->published) {
                $post->published_at = date('Y-m-d H:i:s');
            }
            
            if ($post->save()) {
                $this->redirect('/admin/blog/blog');
            }
        }
        
        $this->view('admin/blog/add', []);
    }
}
