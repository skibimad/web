<?php

namespace App\Models;

use App\Core\Model;

class Hero extends Model
{
    protected $table = 'heroes';
    
    public function getAllOrdered()
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY display_order ASC");
    }
    
    public function findBySlug($slug)
    {
        return $this->findBy('slug', $slug);
    }
}
