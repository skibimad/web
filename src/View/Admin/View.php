<?php

namespace App\View\Admin;

class View extends \App\Core\View implements \App\Core\Contract\ViewInterface
{

    protected function getLayoutDir(): string
    {
        return $this->layoutsDir . '/admin/';
    }

}