<?php

/**
 * View - Template rendering engine
 */
class View {
    private $template;
    private $data = [];
    private $layout = null;
    
    public function __construct($template, $data = []) {
        $this->template = $template;
        $this->data = $data;
    }
    
    /**
     * Set layout
     */
    public function layout($layout) {
        $this->layout = $layout;
    }
    
    /**
     * Render the view
     */
    public function render() {
        extract($this->data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        $viewFile = __DIR__ . '/../app/Views/' . $this->template . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            throw new Exception("View not found: {$this->template}");
        }
        
        $content = ob_get_clean();
        
        // If layout is set, wrap content in layout
        if ($this->layout) {
            ob_start();
            $layoutFile = __DIR__ . '/../app/Views/' . $this->layout . '.php';
            if (file_exists($layoutFile)) {
                include $layoutFile;
            }
            return ob_get_clean();
        }
        
        return $content;
    }
    
    /**
     * Escape output
     */
    public function e($value) {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Static helper to create and render view
     */
    public static function make($template, $data = []) {
        $view = new self($template, $data);
        echo $view->render();
    }
}
