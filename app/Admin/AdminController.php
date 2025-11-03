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
            'day' => Analytics::getYouTubeStats('day')['count'],
            'week' => Analytics::getYouTubeStats('week')['count'],
            'month' => Analytics::getYouTubeStats('month')['count'],
            'year' => Analytics::getYouTubeStats('year')['count']
        ];
        
        $visitorStats = [
            'day' => Analytics::getVisitorStats('day')['count'],
            'week' => Analytics::getVisitorStats('week')['count'],
            'month' => Analytics::getVisitorStats('month')['count'],
            'year' => Analytics::getVisitorStats('year')['count']
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
