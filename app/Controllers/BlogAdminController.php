<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\BlogPost;
use Core\Security;
use Core\Request;

/**
 * Blog Admin Controller
 * Handles blog post management in admin
 */
class BlogAdminController extends Controller {
    
    private $model;
    
    public function __construct() {
        $this->model = new BlogPost();
    }
    
    public function index() {
        $posts = $this->model->findAll();
        $this->view('admin/blog/index', ['posts' => $posts]);
    }
    
    public function create() {
        $this->view('admin/blog/form', ['post' => null]);
    }
    
    public function store() {
        $data = [
            'title' => $_POST['title'] ?? '',
            'slug' => $_POST['slug'] ?? $this->generateSlug($_POST['title'] ?? ''),
            'featured_image' => $_POST['featured_image'] ?? '',
            'excerpt' => $_POST['excerpt'] ?? '',
            'content' => $_POST['content'] ?? '',
            'author' => $_POST['author'] ?? 'Admin',
            'publish_date' => $_POST['publish_date'] ?? date('Y-m-d'),
            'is_published' => isset($_POST['is_published']) ? 1 : 0
        ];
        
        $this->model->create($data);
        $_SESSION['success'] = 'Blog post created successfully';
        $this->redirect('/admin/blog');
    }
    
    public function edit($id) {
        $post = $this->model->find($id);
        if (!$post) {
            Response::notFound();
        }
        $this->view('admin/blog/form', ['post' => $post]);
    }
    
    public function update($id) {
        $data = [
            'title' => $_POST['title'] ?? '',
            'slug' => $_POST['slug'] ?? '',
            'featured_image' => $_POST['featured_image'] ?? '',
            'excerpt' => $_POST['excerpt'] ?? '',
            'content' => $_POST['content'] ?? '',
            'author' => $_POST['author'] ?? 'Admin',
            'publish_date' => $_POST['publish_date'] ?? date('Y-m-d'),
            'is_published' => isset($_POST['is_published']) ? 1 : 0
        ];
        
        $this->model->update($id, $data);
        $_SESSION['success'] = 'Blog post updated successfully';
        $this->redirect('/admin/blog');
    }
    
    public function delete($id) {
        $this->model->delete($id);
        $_SESSION['success'] = 'Blog post deleted successfully';
        $this->redirect('/admin/blog');
    }
    
    private function generateSlug($title) {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-');
    }
}
