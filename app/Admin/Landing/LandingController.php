<?php

namespace App\Admin\Landing;

use App\Core\Controller;
use App\Core\Request;
use App\Models\LandingPage;

class LandingController extends Controller
{
    public function handle(Request $request): void
    {
        if ($request->getMethod() === 'POST') {
            $this->handleUpdate($request);
            return;
        }
        
        // Get current settings
        $hero = LandingPage::getSection('hero');
        $about = LandingPage::getSection('about');
        $channel = LandingPage::getSection('channel');
        
        $this->view('admin/landing/edit', [
            'hero' => $hero,
            'about' => $about,
            'channel' => $channel
        ]);
    }
    
    private function handleUpdate(Request $request): void
    {
        $post = $request->getPost();
        
        // Update hero section
        if (isset($post['hero_title'])) {
            LandingPage::set('hero', 'title', $post['hero_title']);
        }
        if (isset($post['hero_subtitle'])) {
            LandingPage::set('hero', 'subtitle', $post['hero_subtitle']);
        }
        if (isset($post['hero_description'])) {
            LandingPage::set('hero', 'description', $post['hero_description']);
        }
        
        // Update about section
        if (isset($post['about_title'])) {
            LandingPage::set('about', 'title', $post['about_title']);
        }
        if (isset($post['about_subtitle'])) {
            LandingPage::set('about', 'subtitle', $post['about_subtitle']);
        }
        
        // Update channel section
        if (isset($post['channel_title'])) {
            LandingPage::set('channel', 'title', $post['channel_title']);
        }
        if (isset($post['channel_description'])) {
            LandingPage::set('channel', 'description', $post['channel_description']);
        }
        
        $this->redirect('/admin/landing/landing?success=1');
    }
}
