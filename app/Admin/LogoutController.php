<?php

namespace App\Admin;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;

class LogoutController extends Controller
{
    public function handle(Request $request): void
    {
        $auth = new Auth();
        $auth->logout();
        header('Location: /admin/login');
        exit;
    }
}
