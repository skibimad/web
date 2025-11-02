<?php

namespace App\Admin\Blog;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;
use App\Models\BlogPost;

/**
 * Archive/Unarchive Blog Post Controller
 */
class ArchiveController extends Controller
{
    public function handle(Request $request): void
    {
        // Require authentication
        $auth = new Auth();
        $auth->require();
        
        $id = $request->get('id');
        if ($id) {
            $post = BlogPost::find($id);
            if ($post) {
                $post->archived = $post->archived ? 0 : 1;
                $post->save();
            }
        }
        
        $this->redirect('/admin/blog/blog');
    }
}
