<?php
namespace App\Core\Contract;

interface ViewInterface
{
    public function getTemplate(): string;

    public function setTemplate(string $template): void;

    public function render(array $params = [], bool $standalone = false): void;
}