<?php

namespace App\Admin\Heroes;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Hero;

/**
 * Admin Edit Hero Controller
 */
class EditController extends Controller
{
    public function handle(Request $request): void
    {
        $id = $request->get('id');
        
        if (!$id) {
            $this->redirect('/admin/heroes');
            return;
        }
        
        $hero = Hero::find($id);
        
        if (!$hero) {
            $this->redirect('/admin/heroes');
            return;
        }
        
        // Handle POST request (save)
        if ($request->getMethod() === 'POST') {
            $hero->name = $request->post('name');
            $hero->slug = $request->post('slug');
            $hero->description = $request->post('description');
            $hero->image = $request->post('image');
            $hero->video = $request->post('video');
            $hero->display_order = $request->post('display_order');
            
            $abilities = $request->post('abilities', '');
            $hero->abilities = $abilities;
            
            $hero->save();
            
            $this->redirect('/admin/heroes');
            return;
        }
        
        $this->view('admin/heroes/edit', [
            'hero' => $hero
        ]);
    }
}
