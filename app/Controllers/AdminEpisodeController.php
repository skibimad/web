<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Episode;
use App\Helpers\FileUpload;

class AdminEpisodeController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $episodeModel = new Episode();
        $data = ['episodes' => $episodeModel->getAllOrdered()];
        $this->render('admin/episodes/index', $data, $response);
    }
    
    public function create(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $data = [
                'episode_number' => (int)$request->input('episode_number'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'video_url' => $request->input('video_url'),
                'duration' => $request->input('duration'),
                'release_date' => $request->input('release_date'),
                'display_order' => (int)$request->input('display_order', 0),
            ];
            
            if ($request->hasFile('thumbnail')) {
                $upload = FileUpload::upload($_FILES['thumbnail'], 'episodes');
                if ($upload['success']) {
                    $data['thumbnail'] = $upload['path'];
                }
            }
            
            $episodeModel = new Episode();
            $episodeModel->create($data);
            
            $this->redirect('/admin/episodes');
            return;
        }
        
        $this->render('admin/episodes/create', [], $response);
    }
    
    public function edit(Request $request, Response $response, $id)
    {
        $episodeModel = new Episode();
        $episode = $episodeModel->find($id);
        
        if (!$episode) {
            $response->setStatusCode(404);
            $this->render('errors/404', [], $response);
            return;
        }
        
        if ($request->isPost()) {
            $data = [
                'episode_number' => (int)$request->input('episode_number'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'video_url' => $request->input('video_url'),
                'duration' => $request->input('duration'),
                'release_date' => $request->input('release_date'),
                'display_order' => (int)$request->input('display_order', 0),
            ];
            
            if ($request->hasFile('thumbnail')) {
                $upload = FileUpload::upload($_FILES['thumbnail'], 'episodes');
                if ($upload['success']) {
                    if ($episode['thumbnail']) {
                        FileUpload::delete($episode['thumbnail']);
                    }
                    $data['thumbnail'] = $upload['path'];
                }
            }
            
            $episodeModel->update($id, $data);
            $this->redirect('/admin/episodes');
            return;
        }
        
        $this->render('admin/episodes/edit', ['episode' => $episode], $response);
    }
    
    public function delete(Request $request, Response $response, $id)
    {
        $episodeModel = new Episode();
        $episode = $episodeModel->find($id);
        
        if ($episode) {
            if ($episode['thumbnail']) {
                FileUpload::delete($episode['thumbnail']);
            }
            
            $episodeModel->delete($id);
        }
        
        $this->redirect('/admin/episodes');
    }
}
