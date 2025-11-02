<?php
require_once __DIR__ . '/../Model.php';

class User extends Model {
    protected $table = 'users';
    
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
    
    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    public function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }
    
    public function changePassword($userId, $newPassword) {
        $hash = $this->hashPassword($newPassword);
        return $this->update($userId, ['password' => $hash]);
    }
}
