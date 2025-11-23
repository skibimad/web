<?php
namespace App\Core;

use App\Core\Router;

class App
{
    private static ?App $instance = null;

    private Request $request;

    private Router $router;

    private function __construct()
    {
        $this->request = Request::getInstance();
        $this->router = new Router();

    }

    public static function getInstance(): App
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function run(): void
    {
        ob_start();
        try{
         $this->handleRequest();
        } catch (\Throwable $e) {
            ob_end_clean();
            throw new \Exception($e);
        }
        ob_end_flush();
    }


    private function handleRequest(): void
    {
        $this->getRouter()->dispatch();

    }

    protected function getRouter(): Router
    {
        return $this->router;
    }

    protected function getRequest(): Request
    {
        return $this->request;
    }
}