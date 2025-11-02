<?php
/**
 * Base Controller Class
 */
class Controller {
    
    protected function view($viewPath, $data = []) {
        extract($data);
        $viewFile = __DIR__ . '/../views/' . $viewPath . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View not found: {$viewPath}");
        }
    }

    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function redirect($url) {
        header('Location: ' . $url);
        exit;
    }

    protected function getInput($key, $default = null) {
        return Security::sanitize($_POST[$key] ?? $_GET[$key] ?? $default);
    }

    protected function getAllInput() {
        return Security::sanitize($_POST + $_GET);
    }
}
