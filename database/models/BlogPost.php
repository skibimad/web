<?php
require_once __DIR__ . '/../Model.php';

class BlogPost extends Model {
    protected $table = 'blog_posts';
    
    public function getPublished($orderBy = 'created_at DESC') {
        return $this->findWhere(['published' => 1], $orderBy);
    }
    
    public function getLatest($limit = 3) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE published = 1 ORDER BY created_at DESC LIMIT ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function findBySlug($slug) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
}
