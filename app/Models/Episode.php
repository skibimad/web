<?php

namespace App\Models;

use App\Core\Model;

class Episode extends Model
{
    protected $table = 'episodes';
    
    public function getAllOrdered()
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY display_order ASC");
    }
    
    public function findByNumber($number)
    {
        return $this->findBy('episode_number', $number);
    }
}
