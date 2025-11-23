<?php
namespace App\Core\Helper;

use App\Core\Request;

class Helper
{
    public static function getRequest(): Request
    {
        return Request::getInstance();
    }
}