<?php

namespace App\Models;

use Core\Model;

/**
 * BlogPost Model
 */
class BlogPost extends Model {
    protected $table = 'blog_posts';

    public function findPublished($limit = null) {
        $sql = "SELECT * FROM {$this->table} WHERE is_published = 1 ORDER BY publish_date DESC";
        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }
        return $this->db->fetchAll($sql);
    }

    public function findBySlug($slug) {
        $sql = "SELECT * FROM {$this->table} WHERE slug = ?";
        return $this->db->fetchOne($sql, [$slug]);
    }
}
