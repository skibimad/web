<?php
namespace App\Core\Contract;

interface RenderableInterface
{
    public function render(array $params = []): string;
}