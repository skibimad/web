<?php

namespace App\Controller\Dn;

use App\Controller\DnController;
use App\Core\Helper\Auth;

class Login extends DnController
{
    public function handle(): void
    {
        if ($this->getRequest()->isPost()) {
            $userData = [
                'email' => $this->getRequest('email'),
                'password' => $this->getRequest('password'),
            ];

            $this->getAuth()->login($userData);
            $this->redirect('/admin/');
        }

        $this->render(
            'admin/login',
            [],
            true
        );
    }

    protected function getAuth()
    {
        return new Auth();
    }
}
