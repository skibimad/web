<?php

namespace App\Models;

use Core\Model;
use Core\Security;

/**
 * User Model
 */
class User extends Model {
    protected $table = 'users';

    public function findByUsername($username) {
        $sql = "SELECT * FROM {$this->table} WHERE username = ?";
        return $this->db->fetchOne($sql, [$username]);
    }

    public function updatePassword($id, $newPassword) {
        $hashedPassword = Security::hashPassword($newPassword);
        $sql = "UPDATE {$this->table} SET password = ? WHERE id = ?";
        return $this->db->execute($sql, [$hashedPassword, $id]);
    }
}
