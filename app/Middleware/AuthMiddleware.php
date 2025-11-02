<?php

namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;

class AuthMiddleware
{
    public function handle(Request $request, Response $response): bool
    {
        session_start();
        
        if (!isset($_SESSION['admin_user_id'])) {
            $response->redirect('/admin/login');
            return false;
        }
        
        return true;
    }
}
