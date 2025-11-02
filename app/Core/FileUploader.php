<?php

namespace App\Core;

/**
 * File Upload Handler
 */
class FileUploader
{
    private string $uploadDir;
    private array $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'video/mp4', 'video/webm'];
    private int $maxFileSize = 10485760; // 10MB
    
    public function __construct(string $uploadDir = 'uploads')
    {
        $this->uploadDir = __DIR__ . '/../../' . $uploadDir;
        
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }
    
    /**
     * Handle file upload
     */
    public function upload(array $file, string $category = 'general'): array
    {
        // Validate file
        $validation = $this->validate($file);
        if (!$validation['success']) {
            return $validation;
        }
        
        // Create category directory if it doesn't exist
        $categoryDir = $this->uploadDir . '/' . $category;
        if (!is_dir($categoryDir)) {
            mkdir($categoryDir, 0755, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $this->generateUniqueFilename($extension);
        $filepath = $categoryDir . '/' . $filename;
        
        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            return [
                'success' => false,
                'error' => 'Failed to move uploaded file'
            ];
        }
        
        // Return success with file path
        return [
            'success' => true,
            'path' => '/uploads/' . $category . '/' . $filename,
            'filename' => $filename
        ];
    }
    
    /**
     * Validate uploaded file
     */
    private function validate(array $file): array
    {
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return [
                'success' => false,
                'error' => $this->getUploadErrorMessage($file['error'])
            ];
        }
        
        // Check file size
        if ($file['size'] > $this->maxFileSize) {
            return [
                'success' => false,
                'error' => 'File size exceeds maximum allowed size (10MB)'
            ];
        }
        
        // Check file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, $this->allowedTypes)) {
            return [
                'success' => false,
                'error' => 'Invalid file type. Allowed types: JPEG, PNG, GIF, WEBP, MP4, WEBM'
            ];
        }
        
        return ['success' => true];
    }
    
    /**
     * Generate unique filename
     */
    private function generateUniqueFilename(string $extension): string
    {
        return uniqid() . '_' . time() . '.' . strtolower($extension);
    }
    
    /**
     * Get upload error message
     */
    private function getUploadErrorMessage(int $errorCode): string
    {
        return match($errorCode) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'File is too large',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'File upload stopped by extension',
            default => 'Unknown upload error'
        };
    }
    
    /**
     * Delete file
     */
    public function delete(string $path): bool
    {
        $fullPath = __DIR__ . '/../../' . ltrim($path, '/');
        
        if (file_exists($fullPath) && is_file($fullPath)) {
            return unlink($fullPath);
        }
        
        return false;
    }
}
