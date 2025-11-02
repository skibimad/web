<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\StaticContent;
use Core\Security;
use Core\Request;

/**
 * Content Controller
 * Handles static content editing in admin
 */
class ContentController extends Controller {
    
    private $model;
    
    public function __construct() {
        $this->model = new StaticContent();
    }
    
    public function index() {
        $content = $this->model->getAllAsKeyValue();
        $this->view('admin/content/index', ['content' => $content]);
    }
    
    public function update() {
        foreach ($_POST as $key => $value) {
            if ($key !== 'csrf_token') {
                $this->model->updateByKey($key, $value);
            }
        }
        
        $_SESSION['success'] = 'Content updated successfully';
        $this->redirect('/admin/content');
    }
}
