<?php

/**
 * Upload Controller
 * Handles file uploads
 */
class UploadController extends Controller {
    
    public function upload() {
        if (!isset($_FILES['file'])) {
            return $this->json(['success' => false, 'message' => 'No file uploaded'], 400);
        }
        
        $file = $_FILES['file'];
        
        // Validate file
        $validation = Security::validateFile($file);
        if (!$validation['valid']) {
            return $this->json(['success' => false, 'message' => $validation['error']], 400);
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $uploadPath = ROOT_PATH . '/public/uploads/' . $filename;
        
        // Move file
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return $this->json([
                'success' => true,
                'filename' => $filename,
                'path' => 'uploads/' . $filename,
                'size' => $file['size']
            ]);
        } else {
            return $this->json(['success' => false, 'message' => 'Failed to upload file'], 500);
        }
    }
}
