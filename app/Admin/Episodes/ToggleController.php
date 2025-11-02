<?php

namespace App\Admin\Episodes;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;
use App\Models\Episode;

/**
 * Toggle Episode Enabled/Disabled Controller
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
            $episode = Episode::find($id);
            if ($episode) {
                $episode->enabled = $episode->enabled ? 0 : 1;
                $episode->save();
            }
        }
        
        $this->redirect('/admin/episodes/episodes');
    }
}
