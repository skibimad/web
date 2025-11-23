<?php
namespace App\Controller;

use App\Core\Controller;

class NotFound extends Controller
{

    public function index()
    {
        $this->render('error/404');
    }
}