<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Hero;
use App\Models\Episode;
use App\Models\BlogPost;
use App\Models\SocialLink;

/**
 * Home Controller
 */
class HomeController extends Controller
{
    public function handle(Request $request): void
    {
        // Get only enabled heroes and episodes for landing page
        $allHeroes = Hero::allOrdered();
        $heroes = array_filter($allHeroes->toArray(), fn($h) => $h->enabled == 1);
        
        $allEpisodes = Episode::allOrdered();
        $episodes = array_filter($allEpisodes->toArray(), fn($e) => $e->enabled == 1);
        $recentPosts = BlogPost::published();
        
        // Get only first 3 blog posts for home page
        $recentPostsArray = $recentPosts->toArray();
        $recentPosts = array_slice($recentPostsArray, 0, 3);
        
        // Get social links for footer
        $socialLinks = SocialLink::enabled();
        
        $this->view('home', [
            'heroes' => $heroes,
            'episodes' => $episodes,
            'recentPosts' => $recentPosts,
            'socialLinks' => $socialLinks
        ]);
    }
}
