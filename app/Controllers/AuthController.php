<?php

namespace App\Controllers;

use Core\Controller;
use Core\Security;
use App\Models\User;
use Core\Request;
use Core\Response;

/**
 * Auth Controller
 * Handles authentication
 */
class AuthController extends Controller {
    
    public function showLogin() {
        // Redirect if already logged in
        if (Security::isAuthenticated()) {
            $this->redirect('/admin');
        }
        
        $this->view('admin/login');
    }
    
    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $userModel = new User();
        $user = $userModel->findByUsername($username);
        
        if ($user && Security::verifyPassword($password, $user['password'])) {
            Security::login($user);
            $this->redirect('/admin');
        } else {
            $_SESSION['error'] = 'Invalid credentials';
            $this->redirect('/admin/login');
        }
    }
    
    public function logout() {
        Security::logout();
        $this->redirect('/admin/login');
    }
}
