<?php

namespace App\Admin\Episodes;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;
use App\Models\Episode;

/**
 * Admin Episodes List Controller
 */
class EpisodesController extends Controller
{
    public function handle(Request $request): void
    {
        // Require authentication
        $auth = new Auth();
        $auth->require();
        
        $episodes = Episode::allOrdered();
        
        $this->view('admin/episodes/list', [
            'episodes' => $episodes
        ]);
    }
}
