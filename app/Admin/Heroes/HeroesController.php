<?php

namespace App\Admin\Heroes;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;
use App\Models\Hero;

/**
 * Admin Heroes List Controller
 */
class HeroesController extends Controller
{
    public function handle(Request $request): void
    {
        // Require authentication
        $auth = new Auth();
        $auth->require();
        
        $heroes = Hero::allOrdered();
        
        $this->view('admin/heroes/list', [
            'heroes' => $heroes
        ]);
    }
}
