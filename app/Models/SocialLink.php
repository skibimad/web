<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Collection;

class SocialLink extends Model
{
    protected static string $table = 'social_links';

    public static function enabled(): Collection
    {
        return new Collection(
            static::query(
                "SELECT * FROM " . static::$table . " WHERE enabled = 1 ORDER BY display_order ASC"
            )->fetchAll(),
            static::class
        );
    }

    public function save(): bool
    {
        $db = static::getDb();
        
        if (isset($this->id) && $this->id) {
            // Update
            return $db->query(
                "UPDATE " . static::$table . " SET 
                    platform = ?, url = ?, icon_class = ?, display_order = ?, enabled = ?, updated_at = CURRENT_TIMESTAMP
                WHERE id = ?",
                [$this->platform, $this->url, $this->icon_class, $this->display_order, $this->enabled, $this->id]
            )->rowCount() > 0;
        } else {
            // Insert
            $result = $db->query(
                "INSERT INTO " . static::$table . " (platform, url, icon_class, display_order, enabled) 
                VALUES (?, ?, ?, ?, ?)",
                [$this->platform, $this->url, $this->icon_class, $this->display_order, $this->enabled ?? 1]
            );
            $this->id = $db->getPdo()->lastInsertId();
            return $this->id > 0;
        }
    }
}
