<?php

namespace App\Core;

/**
 * Base Controller
 */
abstract class Controller
{
    /**
     * Render a view template
     */
    protected function view(string $template, array $data = []): void
    {
        // Extract data to make variables available in template
        extract($data);
        
        // Build template path
        $templatePath = __DIR__ . '/../Views/' . $template . '.phtml';
        
        if (!file_exists($templatePath)) {
            throw new \Exception("View template not found: {$template}");
        }
        
        require $templatePath;
    }
    
    /**
     * Redirect to another URL
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
    
    /**
     * Return JSON response
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
