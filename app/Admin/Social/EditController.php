<?php

namespace App\Admin\Social;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;
use App\Models\SocialLink;

/**
 * Admin Edit Social Link Controller
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
            $this->redirect('/admin/social/links');
            return;
        }
        
        $link = SocialLink::find($id);
        
        if (!$link) {
            $this->redirect('/admin/social/links');
            return;
        }
        
        // Handle POST request (save)
        if ($request->method() === 'POST') {
            $link->platform = $request->post('platform');
            $link->url = $request->post('url');
            $link->icon_class = $request->post('icon_class');
            $link->display_order = $request->post('display_order', 0);
            $link->enabled = $request->post('enabled', 1);
            
            $link->save();
            
            $this->redirect('/admin/social/links');
            return;
        }
        
        $this->view('admin/social/edit', [
            'link' => $link
        ]);
    }
}
