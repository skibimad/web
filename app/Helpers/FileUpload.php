<?php

namespace App\Helpers;

class FileUpload
{
    public static function upload($file, $directory, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'webm'])
    {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'No file uploaded or upload error'];
        }
        
        $uploadDir = __DIR__ . '/../../uploads/' . $directory;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($extension, $allowedTypes)) {
            return ['success' => false, 'message' => 'Invalid file type'];
        }
        
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $filepath = $uploadDir . '/' . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return [
                'success' => true,
                'filename' => $filename,
                'path' => 'uploads/' . $directory . '/' . $filename
            ];
        }
        
        return ['success' => false, 'message' => 'Failed to move uploaded file'];
    }
    
    public static function delete($path)
    {
        $fullPath = __DIR__ . '/../../' . $path;
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        return false;
    }
}
