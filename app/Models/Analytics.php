<?php

namespace App\Models;

use App\Core\Model;

class Analytics extends Model
{
    /**
     * Track YouTube click
     */
    public static function trackYouTubeClick(string $ip, string $userAgent, string $referrer = ''): bool
    {
        $db = static::getDb();
        return $db->query(
            "INSERT INTO youtube_clicks (user_ip, user_agent, referrer) VALUES (?, ?, ?)",
            [$ip, $userAgent, $referrer]
        )->rowCount() > 0;
    }

    /**
     * Track visitor
     */
    public static function trackVisitor(string $ip, string $userAgent, string $pageUrl, string $referrer = ''): bool
    {
        $db = static::getDb();
        return $db->query(
            "INSERT INTO visitors (user_ip, user_agent, page_url, referrer) VALUES (?, ?, ?, ?)",
            [$ip, $userAgent, $pageUrl, $referrer]
        )->rowCount() > 0;
    }

    /**
     * Get YouTube click stats
     */
    public static function getYouTubeStats(string $period = 'day'): array
    {
        $db = static::getDb();
        
        $intervals = [
            'day' => "datetime('now', '-1 day')",
            'week' => "datetime('now', '-7 days')",
            'month' => "datetime('now', '-1 month')",
            'year' => "datetime('now', '-1 year')"
        ];
        
        $interval = $intervals[$period] ?? $intervals['day'];
        
        $result = $db->query(
            "SELECT COUNT(*) as count FROM youtube_clicks WHERE clicked_at >= $interval"
        )->fetch();
        
        return ['count' => $result['count'] ?? 0, 'period' => $period];
    }

    /**
     * Get visitor stats
     */
    public static function getVisitorStats(string $period = 'day'): array
    {
        $db = static::getDb();
        
        $intervals = [
            'day' => "datetime('now', '-1 day')",
            'week' => "datetime('now', '-7 days')",
            'month' => "datetime('now', '-1 month')",
            'year' => "datetime('now', '-1 year')"
        ];
        
        $interval = $intervals[$period] ?? $intervals['day'];
        
        $result = $db->query(
            "SELECT COUNT(DISTINCT user_ip) as count FROM visitors WHERE visited_at >= $interval"
        )->fetch();
        
        return ['count' => $result['count'] ?? 0, 'period' => $period];
    }
}
