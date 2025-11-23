<?php
namespace App\Controller\Youclick;

use App\Core\Controller;

class Index extends Controller
{
    public function handle(): void
    {
        $this->redirect($this->getRequest('y'));
    }
}