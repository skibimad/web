<?php

namespace App\Models;

use App\Core\Model;

/**
 * Episode Model
 */
class Episode extends Model
{
    protected $table = 'episodes';
    
    /**
     * Get all episodes ordered by episode number
     */
    public static function allOrdered()
    {
        $instance = new static();
        $stmt = $instance->db->query("SELECT * FROM {$instance->table} ORDER BY episode_number ASC");
        $results = $stmt->fetchAll();
        
        return new \App\Core\Collection(array_map(function($row) {
            return new static($row);
        }, $results));
    }
    
    /**
     * Format release date
     */
    public function getFormattedDate(): string
    {
        if (empty($this->release_date)) {
            return '';
        }
        return date('F j, Y', strtotime($this->release_date));
    }
}
