<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Hero;
use Core\Security;
use Core\Request;

/**
 * Hero Controller
 * Handles hero management in admin
 */
class HeroController extends Controller {
    
    private $model;
    
    public function __construct() {
        $this->model = new Hero();
    }
    
    public function index() {
        $heroes = $this->model->findAll();
        $this->view('admin/heroes/index', ['heroes' => $heroes]);
    }
    
    public function create() {
        $this->view('admin/heroes/form', ['hero' => null]);
    }
    
    public function store() {
        $data = [
            'name' => $_POST['name'] ?? '',
            'slug' => $_POST['slug'] ?? '',
            'description' => $_POST['description'] ?? '',
            'image_path' => $_POST['image_path'] ?? '',
            'video_path' => $_POST['video_path'] ?? '',
            'ability1' => $_POST['ability1'] ?? '',
            'ability2' => $_POST['ability2'] ?? '',
            'ability3' => $_POST['ability3'] ?? '',
            'display_order' => $_POST['display_order'] ?? 0
        ];
        
        $this->model->create($data);
        $_SESSION['success'] = 'Hero created successfully';
        $this->redirect('/admin/heroes');
    }
    
    public function edit($id) {
        $hero = $this->model->find($id);
        if (!$hero) {
            Response::notFound();
        }
        $this->view('admin/heroes/form', ['hero' => $hero]);
    }
    
    public function update($id) {
        $data = [
            'name' => $_POST['name'] ?? '',
            'slug' => $_POST['slug'] ?? '',
            'description' => $_POST['description'] ?? '',
            'image_path' => $_POST['image_path'] ?? '',
            'video_path' => $_POST['video_path'] ?? '',
            'ability1' => $_POST['ability1'] ?? '',
            'ability2' => $_POST['ability2'] ?? '',
            'ability3' => $_POST['ability3'] ?? '',
            'display_order' => $_POST['display_order'] ?? 0
        ];
        
        $this->model->update($id, $data);
        $_SESSION['success'] = 'Hero updated successfully';
        $this->redirect('/admin/heroes');
    }
    
    public function delete($id) {
        $this->model->delete($id);
        $_SESSION['success'] = 'Hero deleted successfully';
        $this->redirect('/admin/heroes');
    }
}
