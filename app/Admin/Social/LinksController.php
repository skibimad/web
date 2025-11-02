<?php

namespace App\Admin\Social;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;
use App\Models\SocialLink;

/**
 * Admin Social Links Controller
 */
class LinksController extends Controller
{
    public function handle(Request $request): void
    {
        // Require authentication
        $auth = new Auth();
        $auth->require();
        
        $links = SocialLink::all();
        
        $this->view('admin/social/links', [
            'links' => $links
        ]);
    }
}
