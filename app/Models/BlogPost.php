<?php

namespace App\Models;

use App\Core\Model;

class BlogPost extends Model
{
    protected $table = 'blog_posts';
    
    public function getAllPublished()
    {
        return $this->db->fetchAll(
            "SELECT * FROM {$this->table} WHERE published_at IS NOT NULL ORDER BY published_at DESC"
        );
    }
    
    public function getRecent($limit = 3)
    {
        return $this->db->fetchAll(
            "SELECT * FROM {$this->table} WHERE published_at IS NOT NULL ORDER BY published_at DESC LIMIT ?",
            [$limit]
        );
    }
    
    public function findBySlug($slug)
    {
        return $this->findBy('slug', $slug);
    }
}
