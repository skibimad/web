<?php
require_once __DIR__ . '/../Model.php';

class Hero extends Model {
    protected $table = 'heroes';
    
    public function getAllOrdered() {
        return $this->findAll('display_order ASC');
    }
    
    public function findBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
}
