<?php

namespace App\Core;

abstract class Controller
{
    protected $db;
    
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    
    protected function render(string $view, array $data = [], Response $response = null): void
    {
        $viewPath = __DIR__ . "/../Views/{$view}.phtml";
        
        if (file_exists($viewPath)) {
            extract($data);
            ob_start();
            require $viewPath;
            $content = ob_get_clean();
            
            if ($response) {
                $response->setContent($content)->send();
            } else {
                echo $content;
            }
        } else {
            throw new \Exception("View not found: {$view}");
        }
    }
    
    protected function json(array $data, int $statusCode = 200, Response $response = null): void
    {
        if ($response) {
            $response->json($data, $statusCode)->send();
        } else {
            header('Content-Type: application/json');
            http_response_code($statusCode);
            echo json_encode($data);
        }
    }
    
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}
