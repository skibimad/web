<?php

namespace Core;

/**
 * Base Controller Class
 */
class Controller {
    
    /**
     * Render a view
     */
    protected function view($template, $data = []) {
        return View::make($template, $data);
    }

    /**
     * Return JSON response
     */
    protected function json($data, $statusCode = 200) {
        return Response::json($data, $statusCode);
    }

    /**
     * Redirect to URL
     */
    protected function redirect($url) {
        return Response::redirect($url);
    }

    /**
     * Get static content as key-value array
     */
    protected function getStaticContent() {
        $model = new StaticContent();
        return $model->getAllAsKeyValue();
    }
}
