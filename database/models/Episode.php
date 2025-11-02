<?php
require_once __DIR__ . '/../Model.php';

class Episode extends Model {
    protected $table = 'episodes';
    
    public function getAllOrdered() {
        return $this->findAll('episode_number ASC');
    }
    
    public function getLatest($limit = 5) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY release_date DESC, episode_number DESC LIMIT ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
