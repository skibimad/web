<?php

namespace App\Controller\Admin\Hero;

use App\Controller\AdminController;
use App\Model\Hero;

class Update extends AdminController
{
    public function handle(): void
    {
        if ($this->getRequest()->isPost()) {
            $this->updateHero();
            $this->redirect('/admin/heroes');
        }

        $this->render(
            'admin/hero/form',
            [
                'hero' => $this->findHero()
            ]
        );
    }

    protected function findHero()
    {
        $hero = new Hero();
        $hero->load($this->getRequest('id'));

        return $hero;
    }

    protected function updateHero()
    {
        $heroData = $this->getRequest('hero');
        $this->assertValid($heroData);
        $hero = new Hero();
        $hero->load($heroData['id']);
        unset($heroData['id']);
        $hero->setData($heroData)->save();
    }

    protected function assertValid(array &$data)
    {
        return true;
    }
}
