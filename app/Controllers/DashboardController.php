<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Hero;
use App\Models\Episode;
use App\Models\BlogPost;
use Core\Security;
use App\Models\User;

/**
 * Dashboard Controller
 * Handles admin dashboard
 */
class DashboardController extends Controller {
    
    public function index() {
        $heroModel = new Hero();
        $episodeModel = new Episode();
        $blogModel = new BlogPost();
        
        $data = [
            'heroCount' => count($heroModel->findAll()),
            'episodeCount' => count($episodeModel->findAll()),
            'blogCount' => count($blogModel->findAll()),
            'user' => Security::user()
        ];
        
        $this->view('admin/dashboard', $data);
    }
    
    public function changePassword() {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match';
            $this->redirect('/admin');
        }
        
        $userModel = new User();
        $user = Security::user();
        $dbUser = $userModel->find($user['id']);
        
        if (!Security::verifyPassword($currentPassword, $dbUser['password'])) {
            $_SESSION['error'] = 'Current password is incorrect';
            $this->redirect('/admin');
        }
        
        $userModel->update($user['id'], [
            'password' => Security::hashPassword($newPassword)
        ]);
        
        $_SESSION['success'] = 'Password changed successfully';
        $this->redirect('/admin');
    }
}
