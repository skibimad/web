<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class LandingPage extends Model
{
    protected $table = 'landing_page_content';
    
    public function __construct(
        public ?int $id = null,
        public string $section = '',
        public string $key = '',
        public string $value = '',
        public ?string $created_at = null,
        public ?string $updated_at = null
    ) {
        parent::__construct();
    }
    
    /**
     * Get setting value by section and key
     */
    public static function get(string $section, string $key, string $default = ''): string
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('SELECT value FROM landing_page_content WHERE section = ? AND key = ? LIMIT 1');
        $stmt->execute([$section, $key]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return $result ? $result['value'] : $default;
    }
    
    /**
     * Set setting value
     */
    public static function set(string $section, string $key, string $value): bool
    {
        $db = Database::getInstance()->getConnection();
        
        // Check if exists
        $stmt = $db->prepare('SELECT id FROM landing_page_content WHERE section = ? AND key = ? LIMIT 1');
        $stmt->execute([$section, $key]);
        $existing = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($existing) {
            // Update
            $stmt = $db->prepare('UPDATE landing_page_content SET value = ?, updated_at = CURRENT_TIMESTAMP WHERE section = ? AND key = ?');
            return $stmt->execute([$value, $section, $key]);
        } else {
            // Insert
            $stmt = $db->prepare('INSERT INTO landing_page_content (section, key, value) VALUES (?, ?, ?)');
            return $stmt->execute([$section, $key, $value]);
        }
    }
    
    /**
     * Get all settings for a section
     */
    public static function getSection(string $section): array
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('SELECT key, value FROM landing_page_content WHERE section = ?');
        $stmt->execute([$section]);
        
        $settings = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $settings[$row['key']] = $row['value'];
        }
        
        return $settings;
    }
}
