<?php

namespace App\Admin\Heroes;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;
use App\Models\Hero;

/**
 * Admin Delete Hero Controller
 */
class DeleteController extends Controller
{
    public function handle(Request $request): void
    {
        // Require authentication
        $auth = new Auth();
        $auth->require();
        
        $id = $request->get('id');
        
        if ($id) {
            $hero = Hero::find($id);
            if ($hero) {
                $hero->delete();
            }
        }
        
        $this->redirect('/admin/heroes/heroes');
    }
}
