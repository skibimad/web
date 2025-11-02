<?php

namespace App\Models;

use App\Core\Model;

class AdminUser extends Model
{
    protected $table = 'admin_users';
    
    public function findByUsername($username)
    {
        return $this->findBy('username', $username);
    }
    
    public function verifyPassword($username, $password)
    {
        $user = $this->findByUsername($username);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    public function updatePassword($id, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($id, ['password' => $hashedPassword]);
    }
}
