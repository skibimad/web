<?php

namespace App\Models;

use App\Core\Model;

/**
 * Hero Model
 */
class Hero extends Model
{
    protected $table = 'heroes';
    
    /**
     * Get abilities as array
     */
    public function getAbilities(): array
    {
        if (empty($this->abilities)) {
            return [];
        }
        return explode(',', $this->abilities);
    }
    
    /**
     * Set abilities from array
     */
    public function setAbilities(array $abilities): void
    {
        $this->abilities = implode(',', $abilities);
    }
    
    /**
     * Get all heroes ordered by display_order
     */
    public static function allOrdered()
    {
        $instance = new static();
        $stmt = $instance->db->query("SELECT * FROM {$instance->table} ORDER BY display_order ASC");
        $results = $stmt->fetchAll();
        
        return new \App\Core\Collection(array_map(function($row) {
            return new static($row);
        }, $results));
    }
}
