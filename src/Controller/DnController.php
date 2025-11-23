<?php
namespace App\Controller;

use App\Core\Contract\ViewInterface;
use App\Core\Controller;
use App\View\Admin\View;

abstract class DnController extends Controller
{
    /**
     * AccountController constructor.
     * Ensures that only admin users can access this controller.
     */
    public function __construct()
    {
        parent::__construct();
        // if (!User::isAdmin()) {
        //     $this->redirect('/error/notfound');
        // }
    }

    protected function getView(string $template, array $params = []): ViewInterface
    {
        return new View($this, $template, $params);
    }

}