<?php

namespace App\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Hero;
use App\Models\Episode;
use App\Models\BlogPost;

/**
 * Admin Dashboard Controller
 */
class AdminController extends Controller
{
    public function handle(Request $request): void
    {
        $heroCount = Hero::all()->count();
        $episodeCount = Episode::all()->count();
        $blogCount = BlogPost::all()->count();
        
        $this->view('admin/dashboard', [
            'heroCount' => $heroCount,
            'episodeCount' => $episodeCount,
            'blogCount' => $blogCount
        ]);
    }
}
