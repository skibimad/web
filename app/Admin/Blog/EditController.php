<?php

namespace App\Admin\Blog;

use App\Core\Controller;
use App\Core\Request;
use App\Models\BlogPost;

/**
 * Admin Edit Blog Post Controller  
 */
class EditController extends Controller
{
    public function handle(Request $request): void
    {
        $id = $request->get('id');
        
        if (!$id) {
            $this->redirect('/admin/blog');
            return;
        }
        
        $post = BlogPost::find($id);
        
        if (!$post) {
            $this->redirect('/admin/blog');
            return;
        }
        
        // Handle POST request (save)
        if ($request->getMethod() === 'POST') {
            $post->title = $request->post('title');
            $post->slug = $request->post('slug');
            $post->content = $request->post('content');
            $post->excerpt = $request->post('excerpt');
            $post->image = $request->post('image');
            $post->author = $request->post('author');
            $post->published = $request->post('published', 0);
            
            $post->save();
            
            $this->redirect('/admin/blog/blog');
            return;
        }
        
        $this->view('admin/blog/edit', [
            'post' => $post
        ]);
    }
}
