-- Migration: Add authentication and new features
-- Version: 001
-- Created: 2024-11-02

-- Admin users table for authentication
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    active TINYINT(1) DEFAULT 1,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_admin_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add 'enabled' column to heroes table if it doesn't exist
SET @dbname = DATABASE();
SET @tablename = 'heroes';
SET @columnname = 'enabled';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' TINYINT(1) DEFAULT 1')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Add 'enabled' column to episodes table if it doesn't exist
SET @tablename = 'episodes';
SET @columnname = 'enabled';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' TINYINT(1) DEFAULT 1')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Add 'archived' column to blog_posts table if it doesn't exist
SET @tablename = 'blog_posts';
SET @columnname = 'archived';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' TINYINT(1) DEFAULT 0')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- YouTube channel settings table
CREATE TABLE IF NOT EXISTS youtube_channel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    channel_name VARCHAR(255) NOT NULL,
    channel_url VARCHAR(500) NOT NULL,
    channel_handle VARCHAR(100) NOT NULL,
    description TEXT,
    subscriber_count VARCHAR(50),
    video_count VARCHAR(50),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default YouTube channel data
INSERT IGNORE INTO youtube_channel (id, channel_name, channel_url, channel_handle, description, subscriber_count, video_count) VALUES
(1, 'FireStormX Studios', 'https://www.youtube.com/@FireStormX-Tri', '@FireStormX-Tri', 'Official Skibidi Madness YouTube Channel', '10K+', '50+');

-- Social media links table
CREATE TABLE IF NOT EXISTS social_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    platform VARCHAR(100) NOT NULL,
    url VARCHAR(500) NOT NULL,
    icon_class VARCHAR(100),
    display_order INT DEFAULT 0,
    enabled TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default social links
INSERT IGNORE INTO social_links (id, platform, url, icon_class, display_order) VALUES
(1, 'YouTube', 'https://www.youtube.com/@FireStormX-Tri', 'fab fa-youtube', 1),
(2, 'Twitter', 'https://twitter.com/skibidimadness', 'fab fa-twitter', 2),
(3, 'Discord', 'https://discord.gg/skibidimadness', 'fab fa-discord', 3),
(4, 'TikTok', 'https://www.tiktok.com/@skibidimadness', 'fab fa-tiktok', 4);

-- YouTube click analytics table
CREATE TABLE IF NOT EXISTS youtube_clicks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clicked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_ip VARCHAR(45),
    user_agent VARCHAR(500),
    referrer VARCHAR(500),
    INDEX idx_youtube_clicks_date (clicked_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Visitor analytics table
CREATE TABLE IF NOT EXISTS visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    visited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_ip VARCHAR(45),
    user_agent VARCHAR(500),
    page_url VARCHAR(500),
    referrer VARCHAR(500),
    INDEX idx_visitors_date (visited_at),
    INDEX idx_visitors_ip (user_ip)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user (username: admin, password: admin123)
-- Password hash for 'admin123'
INSERT IGNORE INTO admin_users (id, username, email, password_hash) VALUES
(1, 'admin', 'admin@skibidimadness.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
