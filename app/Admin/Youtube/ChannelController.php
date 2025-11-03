<?php

namespace App\Admin\Youtube;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Request;
use App\Models\YouTubeChannel;

/**
 * Admin YouTube Channel Settings Controller
 */
class ChannelController extends Controller
{
    public function handle(Request $request): void
    {
        // Require authentication
        $auth = new Auth();
        $auth->require();
        
        $channel = YouTubeChannel::get();
        
        // Handle POST request (save)
        if ($request->method() === 'POST') {
            YouTubeChannel::update([
                'channel_name' => $request->post('channel_name'),
                'channel_url' => $request->post('channel_url'),
                'channel_handle' => $request->post('channel_handle'),
                'description' => $request->post('description'),
                'subscriber_count' => $request->post('subscriber_count'),
                'video_count' => $request->post('video_count')
            ]);
            
            $this->redirect('/admin/youtube/channel');
            return;
        }
        
        $this->view('admin/youtube/channel', [
            'channel' => $channel
        ]);
    }
}
