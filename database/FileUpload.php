<?php
// File Upload Helper

class FileUpload {
    private $uploadDir;
    private $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private $maxSize = 5 * 1024 * 1024; // 5MB
    
    public function __construct($subDir = '') {
        $this->uploadDir = UPLOAD_DIR . $subDir;
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }
    
    public function upload($file, $oldFile = null) {
        // Check if file was uploaded
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return ['success' => false, 'error' => 'No file uploaded'];
        }
        
        // Check file size
        if ($file['size'] > $this->maxSize) {
            return ['success' => false, 'error' => 'File too large. Maximum size is 5MB'];
        }
        
        // Check file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, $this->allowedTypes)) {
            return ['success' => false, 'error' => 'Invalid file type. Only images are allowed'];
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $filepath = $this->uploadDir . '/' . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            // Delete old file if exists
            if ($oldFile && file_exists($oldFile)) {
                unlink($oldFile);
            }
            
            // Return relative path for database storage
            $relativePath = str_replace(UPLOAD_DIR, UPLOAD_URL, $filepath);
            return ['success' => true, 'path' => $relativePath];
        }
        
        return ['success' => false, 'error' => 'Failed to upload file'];
    }
    
    public function delete($filepath) {
        if ($filepath && file_exists($filepath)) {
            return unlink($filepath);
        }
        return false;
    }
}
