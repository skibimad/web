<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Collection;

class SocialLink extends Model
{
    protected static $table = 'social_links';

    public static function enabled(): Collection
    {
        $results = static::query(
            "SELECT * FROM " . static::$table . " WHERE enabled = 1 ORDER BY display_order ASC"
        )->fetchAll();
        
        return new Collection(array_map(function($row) {
            return new static($row);
        }, $results));
    }

    public function save(): bool
    {
        $db = static::getDb();
        
        if (isset($this->attributes['id']) && $this->attributes['id']) {
            // Update
            $stmt = $db->prepare(
                "UPDATE " . static::$table . " SET 
                    platform = ?, url = ?, icon_class = ?, display_order = ?, enabled = ?, updated_at = CURRENT_TIMESTAMP
                WHERE id = ?"
            );
            return $stmt->execute([
                $this->attributes['platform'], 
                $this->attributes['url'], 
                $this->attributes['icon_class'], 
                $this->attributes['display_order'], 
                $this->attributes['enabled'], 
                $this->attributes['id']
            ]);
        } else {
            // Insert
            $stmt = $db->prepare(
                "INSERT INTO " . static::$table . " (platform, url, icon_class, display_order, enabled) 
                VALUES (?, ?, ?, ?, ?)"
            );
            $result = $stmt->execute([
                $this->attributes['platform'], 
                $this->attributes['url'], 
                $this->attributes['icon_class'], 
                $this->attributes['display_order'], 
                $this->attributes['enabled'] ?? 1
            ]);
            if ($result) {
                $this->attributes['id'] = $db->lastInsertId();
            }
            return $result;
        }
    }
}
