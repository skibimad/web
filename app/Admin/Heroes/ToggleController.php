<?php

namespace App\Admin\Heroes;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;
use App\Models\Hero;

/**
 * Admin Toggle Hero Status Controller
 */
class ToggleController extends Controller
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
                $hero->enabled = $hero->enabled ? 0 : 1;
                $hero->save();
            }
        }
        
        $this->redirect('/admin/heroes/heroes');
    }
}
