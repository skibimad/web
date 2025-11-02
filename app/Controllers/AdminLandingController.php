<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\LandingContent;
use App\Helpers\FileUpload;

class AdminLandingController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $contentModel = new LandingContent();
        
        $data = [
            'heroContent' => $contentModel->getBySection('hero'),
            'aboutContent' => $contentModel->getBySection('about'),
            'channelContent' => $contentModel->getBySection('channel'),
        ];
        
        $this->render('admin/landing/index', $data, $response);
    }
    
    public function update(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $contentModel = new LandingContent();
            $section = $request->input('section');
            $key = $request->input('key');
            $value = $request->input('value');
            
            // Handle file uploads
            if ($request->hasFile('file')) {
                $upload = FileUpload::upload($_FILES['file'], 'landing');
                if ($upload['success']) {
                    $value = $upload['path'];
                }
            }
            
            $contentModel->updateValue($section, $key, $value);
            
            $this->json(['success' => true, 'message' => 'Content updated successfully'], 200, $response);
            return;
        }
        
        $this->redirect('/admin/landing');
    }
}
