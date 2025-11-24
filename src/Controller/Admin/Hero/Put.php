<?php

namespace App\Controller\Admin\Hero;

use App\Controller\AdminController;
use App\Model\Hero;

class Put extends AdminController
{
    public function handle(): void
    {
        if ($this->getRequest()->isPost()) {
            $this->createHero();
            $this->redirect('/admin/heroes');
        }

        $this->redirect('/admin/hero/add');
    }

    protected function createHero()
    {
        $heroData = $this->getRequest('hero');
        $this->assertValid($heroData);
        unset($heroData['id']);
        $hero = new Hero();
        $hero->setData($heroData)->save();
    }

    protected function assertValid(array &$data)
    {
        return true;
    }
}
