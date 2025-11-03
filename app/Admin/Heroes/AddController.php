<?php

namespace App\Admin\Heroes;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;
use App\Models\Hero;

/**
 * Admin Add Hero Controller
 */
class AddController extends Controller
{
    public function handle(Request $request): void
    {
        // Require authentication
        $auth = new Auth();
        $auth->require();
        
        // Handle POST request (save new hero)
        if ($request->getMethod() === 'POST') {
            $hero = new Hero();
            $hero->name = $request->post('name');
            $hero->slug = $request->post('slug');
            $hero->description = $request->post('description');
            $hero->image = $request->post('image');
            $hero->video = $request->post('video');
            $hero->abilities = $request->post('abilities', '');
            $hero->display_order = $request->post('display_order', 0);
            $hero->enabled = $request->post('enabled', 1);
            
            $hero->save();
            
            $this->redirect('/admin/heroes/heroes');
            return;
        }
        
        $this->view('admin/heroes/add', []);
    }
}
