<?php

namespace App\Models;

use App\Core\Model;

class LandingContent extends Model
{
    protected $table = 'landing_content';
    
    public function getBySection($section)
    {
        return $this->where('section', $section);
    }
    
    public function getValue($section, $key)
    {
        $item = $this->db->fetchOne(
            "SELECT content_value FROM {$this->table} WHERE section = ? AND content_key = ?",
            [$section, $key]
        );
        
        return $item ? $item['content_value'] : null;
    }
    
    public function updateValue($section, $key, $value)
    {
        return $this->db->query(
            "UPDATE {$this->table} SET content_value = ? WHERE section = ? AND content_key = ?",
            [$value, $section, $key]
        );
    }
}
