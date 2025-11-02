<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\BlogPost;
use App\Helpers\FileUpload;

class AdminBlogController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $blogModel = new BlogPost();
        $data = ['posts' => $blogModel->all()];
        $this->render('admin/blog/index', $data, $response);
    }
    
    public function create(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $title = $request->input('title');
            $slug = $this->generateSlug($title);
            
            $data = [
                'slug' => $slug,
                'title' => $title,
                'excerpt' => $request->input('excerpt'),
                'content' => $request->input('content'),
                'author' => $request->input('author', 'FireStormX Studios'),
                'published_at' => $request->input('published') ? date('Y-m-d H:i:s') : null,
            ];
            
            if ($request->hasFile('image')) {
                $upload = FileUpload::upload($_FILES['image'], 'blog');
                if ($upload['success']) {
                    $data['image'] = $upload['path'];
                }
            }
            
            $blogModel = new BlogPost();
            $blogModel->create($data);
            
            $this->redirect('/admin/blog');
            return;
        }
        
        $this->render('admin/blog/create', [], $response);
    }
    
    public function edit(Request $request, Response $response, $id)
    {
        $blogModel = new BlogPost();
        $post = $blogModel->find($id);
        
        if (!$post) {
            $response->setStatusCode(404);
            $this->render('errors/404', [], $response);
            return;
        }
        
        if ($request->isPost()) {
            $title = $request->input('title');
            $slug = $request->input('slug') ?: $this->generateSlug($title);
            
            $data = [
                'slug' => $slug,
                'title' => $title,
                'excerpt' => $request->input('excerpt'),
                'content' => $request->input('content'),
                'author' => $request->input('author', 'FireStormX Studios'),
            ];
            
            // Handle publish status
            if ($request->input('published') && !$post['published_at']) {
                $data['published_at'] = date('Y-m-d H:i:s');
            } elseif (!$request->input('published')) {
                $data['published_at'] = null;
            }
            
            if ($request->hasFile('image')) {
                $upload = FileUpload::upload($_FILES['image'], 'blog');
                if ($upload['success']) {
                    if ($post['image']) {
                        FileUpload::delete($post['image']);
                    }
                    $data['image'] = $upload['path'];
                }
            }
            
            $blogModel->update($id, $data);
            $this->redirect('/admin/blog');
            return;
        }
        
        $this->render('admin/blog/edit', ['post' => $post], $response);
    }
    
    public function delete(Request $request, Response $response, $id)
    {
        $blogModel = new BlogPost();
        $post = $blogModel->find($id);
        
        if ($post) {
            if ($post['image']) {
                FileUpload::delete($post['image']);
            }
            
            $blogModel->delete($id);
        }
        
        $this->redirect('/admin/blog');
    }
    
    private function generateSlug($title)
    {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-');
    }
}
