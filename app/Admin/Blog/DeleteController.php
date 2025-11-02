<?php

namespace App\Admin\Blog;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;
use App\Models\BlogPost;

/**
 * Delete Blog Post Controller
 */
class DeleteController extends Controller
{
    public function handle(Request $request): void
    {
        // Require authentication
        $auth = new Auth();
        $auth->require();
        
        $id = $request->get('id');
        if ($id) {
            BlogPost::delete($id);
        }
        
        $this->redirect('/admin/blog/blog');
    }
}
