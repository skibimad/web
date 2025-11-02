<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\AdminUser;
use App\Models\Hero;
use App\Models\Episode;
use App\Models\BlogPost;

class AdminController extends Controller
{
    public function login(Request $request, Response $response)
    {
        session_start();
        
        if (isset($_SESSION['admin_user_id'])) {
            $this->redirect('/admin');
            return;
        }
        
        if ($request->isPost()) {
            $username = $request->input('username');
            $password = $request->input('password');
            
            $adminModel = new AdminUser();
            $user = $adminModel->verifyPassword($username, $password);
            
            if ($user) {
                $_SESSION['admin_user_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                $this->redirect('/admin');
                return;
            }
            
            $error = 'Invalid username or password';
            $this->render('admin/login', ['error' => $error], $response);
            return;
        }
        
        $this->render('admin/login', [], $response);
    }
    
    public function logout(Request $request, Response $response)
    {
        session_start();
        session_destroy();
        $this->redirect('/admin/login');
    }
    
    public function dashboard(Request $request, Response $response)
    {
        session_start();
        
        $heroModel = new Hero();
        $episodeModel = new Episode();
        $blogModel = new BlogPost();
        
        $data = [
            'heroesCount' => count($heroModel->all()),
            'episodesCount' => count($episodeModel->all()),
            'blogCount' => count($blogModel->all()),
            'username' => $_SESSION['admin_username'] ?? 'Admin',
        ];
        
        $this->render('admin/dashboard', $data, $response);
    }
    
    public function changePassword(Request $request, Response $response)
    {
        session_start();
        
        if ($request->isPost()) {
            $currentPassword = $request->input('current_password');
            $newPassword = $request->input('new_password');
            $confirmPassword = $request->input('confirm_password');
            
            if ($newPassword !== $confirmPassword) {
                $this->json(['success' => false, 'message' => 'Passwords do not match'], 400, $response);
                return;
            }
            
            $adminModel = new AdminUser();
            $user = $adminModel->find($_SESSION['admin_user_id']);
            
            if (!password_verify($currentPassword, $user['password'])) {
                $this->json(['success' => false, 'message' => 'Current password is incorrect'], 400, $response);
                return;
            }
            
            $adminModel->updatePassword($user['id'], $newPassword);
            
            $this->json(['success' => true, 'message' => 'Password changed successfully'], 200, $response);
            return;
        }
        
        $this->render('admin/change-password', [], $response);
    }
}
