<?php

namespace App\Admin\Heroes;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;
use App\Models\Hero;

/**
 * Admin Edit Hero Controller
 */
class EditController extends Controller
{
    public function handle(Request $request): void
    {
        // Require authentication
        $auth = new Auth();
        $auth->require();
        
        $id = $request->get('id');
        
        if (!$id) {
            $this->redirect('/admin/heroes/heroes');
            return;
        }
        
        $hero = Hero::find($id);
        
        if (!$hero) {
            $this->redirect('/admin/heroes/heroes');
            return;
        }
        
        // Handle POST request (save)
        if ($request->method() === 'POST') {
            $hero->name = $request->post('name');
            $hero->slug = $request->post('slug');
            $hero->description = $request->post('description');
            $hero->image = $request->post('image');
            $hero->video = $request->post('video');
            $hero->display_order = $request->post('display_order');
            $hero->enabled = $request->post('enabled', 1);
            
            $abilities = $request->post('abilities', '');
            $hero->abilities = $abilities;
            
            $hero->save();
            
            $this->redirect('/admin/heroes/heroes');
            return;
        }
        
        $this->view('admin/heroes/edit', [
            'hero' => $hero
        ]);
    }
}
