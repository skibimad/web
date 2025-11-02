<?php

namespace App\Models;

use App\Core\Model;

/**
 * BlogPost Model
 */
class BlogPost extends Model
{
    protected $table = 'blog_posts';
    
    /**
     * Get published posts only
     */
    public static function published()
    {
        $instance = new static();
        $stmt = $instance->db->query("SELECT * FROM {$instance->table} WHERE published = 1 ORDER BY published_at DESC");
        $results = $stmt->fetchAll();
        
        return new \App\Core\Collection(array_map(function($row) {
            return new static($row);
        }, $results));
    }
    
    /**
     * Find by slug
     */
    public static function findBySlug(string $slug): ?self
    {
        $instance = new static();
        $stmt = $instance->db->prepare("SELECT * FROM {$instance->table} WHERE slug = ? LIMIT 1");
        $stmt->execute([$slug]);
        $result = $stmt->fetch();
        
        return $result ? new static($result) : null;
    }
    
    /**
     * Get formatted published date
     */
    public function getFormattedDate(): string
    {
        if (empty($this->published_at)) {
            return '';
        }
        return date('F j, Y', strtotime($this->published_at));
    }
    
    /**
     * Get excerpt (truncated content if no excerpt set)
     */
    public function getExcerpt(int $length = 150): string
    {
        if (!empty($this->excerpt)) {
            return $this->excerpt;
        }
        
        // Strip HTML tags and truncate content
        $clean = strip_tags($this->content);
        if (strlen($clean) <= $length) {
            return $clean;
        }
        return substr($clean, 0, $length) . '...';
    }
}
