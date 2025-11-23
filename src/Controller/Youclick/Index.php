<?php

namespace App\Controller\Youclick;

use App\Core\Controller;

class Index extends Controller
{
    public function handle(): void
    {
        $this->render(
            'youclick',
            [
                'videoUrl' => $this->getRequest('y')
            ]
        );
        //$this->redirect($this->getRequest('y'));
    }
}
