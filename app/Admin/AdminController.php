<?php

namespace App\Admin;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;
use App\Models\Hero;
use App\Models\Episode;
use App\Models\BlogPost;
use App\Models\Analytics;

/**
 * Admin Dashboard Controller
 */
class AdminController extends Controller
{
    public function handle(Request $request): void
    {
        // Require authentication
        $auth = new Auth();
        $auth->require();
        
        $heroCount = Hero::all()->count();
        $episodeCount = Episode::all()->count();
        $blogCount = BlogPost::all()->count();
        
        // Get analytics data
        $youtubeStats = [
            'day' => Analytics::getYouTubeStats('day'),
            'week' => Analytics::getYouTubeStats('week'),
            'month' => Analytics::getYouTubeStats('month'),
            'year' => Analytics::getYouTubeStats('year')
        ];
        
        $visitorStats = [
            'day' => Analytics::getVisitorStats('day'),
            'week' => Analytics::getVisitorStats('week'),
            'month' => Analytics::getVisitorStats('month'),
            'year' => Analytics::getVisitorStats('year')
        ];
        
        $this->view('admin/dashboard', [
            'heroCount' => $heroCount,
            'episodeCount' => $episodeCount,
            'blogCount' => $blogCount,
            'youtubeStats' => $youtubeStats,
            'visitorStats' => $visitorStats,
            'username' => $auth->username()
        ]);
    }
}
