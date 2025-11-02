<?php
require_once '../config/config.php';
require_once '../core/Security.php';

header('Content-Type: application/json');

// Require authentication
if (!Security::isAuthenticated()) {
    echo json_encode(['success' => false, 'error' => 'Not authenticated']);
    exit;
}

// Check if file was uploaded
if (!isset($_FILES['file'])) {
    echo json_encode(['success' => false, 'error' => 'No file uploaded']);
    exit;
}

$file = $_FILES['file'];

// Determine allowed types based on field
$allowedTypes = array_merge(ALLOWED_IMAGE_TYPES, ALLOWED_VIDEO_TYPES);

// Validate upload
$validation = Security::validateUpload($file, $allowedTypes);
if (!$validation['success']) {
    echo json_encode($validation);
    exit;
}

// Generate unique filename
$filename = Security::generateFilename($file['name']);
$uploadPath = UPLOAD_DIR . $filename;

// Create upload directory if it doesn't exist
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}

// Move uploaded file
if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
    echo json_encode([
        'success' => true,
        'filename' => $filename,
        'path' => 'uploads/' . $filename,
        'size' => $file['size']
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file']);
}
