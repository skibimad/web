<?php

namespace App\Core\Helper;

use App\Model\AdminUser;

class Auth extends Helper
{
    /**
     * Check if admin user is logged in
     *
     * @return bool
     */
    public static function isLoggedIn(): bool
    {
        $request = static::getRequest();
        return $request->getSession('admin_user_id') !== null;
    }

    /**
     * Get the currently logged in admin user ID
     *
     * @return int|null
     */
    public static function getAdminUserId(): ?int
    {
        $request = static::getRequest();
        $userId = $request->getSession('admin_user_id');
        return $userId !== null ? (int)$userId : null;
    }

    /**
     * Attempt to login an admin user
     *
     * @param array $userData Array containing 'email' and 'password'
     * @return bool True if login successful, false otherwise
     * @throws \Exception If credentials are invalid
     */
    public function login(array $userData): bool
    {
        $request = static::getRequest();
        
        $email = $userData['email'] ?? '';
        $password = $userData['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            throw new \Exception('Please enter your email and password.');
        }
        
        try {
            $adminUser = new AdminUser();
            $adminUser->loadByEmail($email);
            
            if ($adminUser->getId() && password_verify($password, $adminUser->get('password_hash'))) {
                $request->setSession('admin_user_id', $adminUser->getId());
                $request->setSession('admin_user_email', $adminUser->get('email'));
                return true;
            }
            
            throw new \Exception('Invalid login credentials.');
        } catch (\Throwable $e) {
            throw new \Exception('Invalid login credentials.');
        }
    }

    /**
     * Logout the current admin user
     *
     * @return void
     */
    public static function logout(): void
    {
        $request = static::getRequest();
        $request->setSession('admin_user_id', null);
        $request->setSession('admin_user_email', null);
        
        // Clear the session completely
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}