<?php

namespace App\Api;

use App\Core\Controller;
use App\Core\Request;
use App\Core\FileUploader;

/**
 * File Upload API Controller
 */
class UploadController extends Controller
{
    public function handle(Request $request): void
    {
        // Only allow POST requests
        if ($request->getMethod() !== 'POST') {
            $this->json(['error' => 'Method not allowed'], 405);
            return;
        }
        
        // Check if file was uploaded
        if (empty($_FILES['file'])) {
            $this->json(['error' => 'No file uploaded'], 400);
            return;
        }
        
        // Get category from request
        $category = $_POST['category'] ?? 'general';
        
        // Upload file
        $uploader = new FileUploader();
        $result = $uploader->upload($_FILES['file'], $category);
        
        if ($result['success']) {
            $this->json([
                'success' => true,
                'path' => $result['path'],
                'filename' => $result['filename']
            ]);
        } else {
            $this->json([
                'success' => false,
                'error' => $result['error']
            ], 400);
        }
    }
}
