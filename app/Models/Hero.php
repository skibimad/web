<?php
require_once __DIR__ . '/../core/Model.php';

/**
 * Hero Model
 */
class Hero extends Model {
    protected $table = 'heroes';

    public function findAll($orderBy = 'display_order ASC') {
        return parent::findAll($orderBy);
    }

    public function findBySlug($slug) {
        $sql = "SELECT * FROM {$this->table} WHERE slug = ?";
        return $this->db->fetchOne($sql, [$slug]);
    }
}
