<?php

namespace App\Controller\Admin;

use App\Controller\AdminController;
use App\Core\Helper\Auth;

class Login extends AdminController
{
    /**
     * Handle login request
     * 
     * @return void
     */
    public function handle(): void
    {
        // If user is already logged in, redirect to dashboard
        if (Auth::isLoggedIn()) {
            $this->redirect('/?q=admin/index');
            return;
        }

        if ($this->getRequest()->isPost()) {
            $this->processLogin();
            return;
        }

        // Show login form
        $this->render(
            'admin/login',
            [],
            true
        );
    }

    /**
     * Process login attempt
     *
     * @return void
     */
    private function processLogin(): void
    {
        $userData = [
            'email' => $this->getRequest()->getPost('email'),
            'password' => $this->getRequest()->getPost('password'),
        ];

        try {
            $auth = $this->getAuth();
            $auth->login($userData);
            
            // Login successful - get intended URL or default to admin dashboard
            $intendedUrl = $this->getRequest()->getSession('intended_url', '/?q=admin/index');
            $this->getRequest()->setSession('intended_url', null);
            
            $this->redirect($intendedUrl);
            return;
        } catch (\Throwable $e) {
            $this->getRequest()->addError($e->getMessage());
        }

        // On failure, redirect back to login page
        $this->redirect('/?q=admin/login');
    }

    /**
     * Get Auth helper instance
     *
     * @return Auth
     */
    protected function getAuth(): Auth
    {
        return new Auth();
    }
}
