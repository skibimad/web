<?php

namespace App\Admin\Episodes;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;
use App\Models\Episode;

/**
 * Delete Episode Controller
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
            Episode::delete($id);
        }
        
        $this->redirect('/admin/episodes/episodes');
    }
}
