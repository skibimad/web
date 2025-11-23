<?php

namespace App\Core\Helper;

use App\Model\AdminUser;

class Auth extends Helper
{
    public static function isLoggedIn(): bool
    {
        $request = static::getRequest();
        return $request->getSession()->get('user_id') !== null;
    }

    public function login(array $userData): void
    {
        $request = static::getRequest();
        $adminUser = new AdminUser();
        try {
            $adminUser->loadByEmail($userData['email']);
            if ($adminUser->getId() && password_verify($userData['password'], $adminUser->get('password_hash'))) {
                $request->session('user_id', $adminUser->getId());
            }
        } catch (\Throwable $e) {
            throw new \Exception('Invalid login credentials.');
        }
        
        
    }
}