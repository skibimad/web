<?php
require_once __DIR__ . '/../Model.php';

class LandingContent extends Model {
    protected $table = 'landing_content';
    
    public function findBySection($section) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE section = ?");
        $stmt->execute([$section]);
        return $stmt->fetch();
    }
    
    public function updateBySection($section, $data) {
        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE section = ?");
        $stmt->execute([$section]);
        $row = $stmt->fetch();
        
        if ($row) {
            return $this->update($row['id'], $data);
        } else {
            $data['section'] = $section;
            return $this->create($data);
        }
    }
}
