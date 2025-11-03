<?php

namespace App\Admin;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;

class LoginController extends Controller
{
    public function handle(Request $request): void
    {
        $auth = new Auth();
        
        // If already logged in, redirect to dashboard
        if ($auth->check()) {
            $this->redirect('/admin');
        }

        if ($request->getMethod() === 'POST') {
            $username = $request->post('username');
            $password = $request->post('password');

            if ($auth->login($username, $password)) {
                $this->redirect('/admin');
            } else {
                $this->view('admin/login', [
                    'error' => 'Invalid username or password'
                ]);
                return;
            }
        }

        $this->view('admin/login', []);
    }
}
