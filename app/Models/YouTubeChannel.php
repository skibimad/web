<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Collection;

class YouTubeChannel extends Model
{
    protected static $table = 'youtube_channel';

    public static function get(): ?object
    {
        $data = static::query("SELECT * FROM " . static::$table . " LIMIT 1")->fetch();
        return $data ? (object)$data : null;
    }

    public static function update(array $data): bool
    {
        $db = static::getDb();
        return $db->query(
            "UPDATE " . static::$table . " SET 
                channel_name = ?,
                channel_url = ?,
                channel_handle = ?,
                description = ?,
                subscriber_count = ?,
                video_count = ?,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = 1",
            [
                $data['channel_name'],
                $data['channel_url'],
                $data['channel_handle'],
                $data['description'] ?? '',
                $data['subscriber_count'] ?? '',
                $data['video_count'] ?? ''
            ]
        )->rowCount() > 0;
    }
}
