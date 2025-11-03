<?php

namespace App\Admin\Episodes;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;
use App\Models\Episode;

/**
 * Add New Episode Controller
 */
class AddController extends Controller
{
    public function handle(Request $request): void
    {
        // Require authentication
        $auth = new Auth();
        $auth->require();
        
        if ($request->method === 'POST') {
            $episode = new Episode();
            $episode->title = $request->post('title');
            $episode->description = $request->post('description');
            $episode->video_url = $request->post('video_url');
            $episode->episode_number = (int)$request->post('episode_number');
            $episode->enabled = (int)$request->post('enabled', 1);
            
            if ($episode->save()) {
                $this->redirect('/admin/episodes/episodes');
            }
        }
        
        $this->view('admin/episodes/add', []);
    }
}
