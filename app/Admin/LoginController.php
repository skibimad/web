<?php

namespace App\Admin;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;

class LoginController extends Controller
{
    private Auth $auth;

    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
    }

    public function handle(Request $request): void
    {
        // If already logged in, redirect to dashboard
        if ($this->auth->check()) {
            header('Location: /admin');
            exit;
        }

        if ($request->method() === 'POST') {
            $username = $request->post('username');
            $password = $request->post('password');

            if ($this->auth->login($username, $password)) {
                header('Location: /admin');
                exit;
            } else {
                $this->render('admin/login', [
                    'error' => 'Invalid username or password'
                ]);
                return;
            }
        }

        $this->render('admin/login', [], 'layouts/auth');
    }
}
