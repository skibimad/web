-- Migration: Add authentication and new features
-- Version: 001
-- Created: 2024-11-02

-- Admin users table for authentication
CREATE TABLE IF NOT EXISTS admin_users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    active INTEGER DEFAULT 1,
    last_login DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS idx_admin_username ON admin_users(username);

-- Add 'enabled' column to heroes table
ALTER TABLE heroes ADD COLUMN enabled INTEGER DEFAULT 1;

-- Add 'enabled' column to episodes table
ALTER TABLE episodes ADD COLUMN enabled INTEGER DEFAULT 1;

-- Add 'archived' column to blog_posts table (in addition to published)
ALTER TABLE blog_posts ADD COLUMN archived INTEGER DEFAULT 0;

-- YouTube channel settings table
CREATE TABLE IF NOT EXISTS youtube_channel (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    channel_name TEXT NOT NULL,
    channel_url TEXT NOT NULL,
    channel_handle TEXT NOT NULL,
    description TEXT,
    subscriber_count TEXT,
    video_count TEXT,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insert default YouTube channel data
INSERT INTO youtube_channel (channel_name, channel_url, channel_handle, description, subscriber_count, video_count) VALUES
('FireStormX Studios', 'https://www.youtube.com/@FireStormX-Tri', '@FireStormX-Tri', 'Official Skibidi Madness YouTube Channel', '10K+', '50+');

-- Social media links table
CREATE TABLE IF NOT EXISTS social_links (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    platform TEXT NOT NULL,
    url TEXT NOT NULL,
    icon_class TEXT,
    display_order INTEGER DEFAULT 0,
    enabled INTEGER DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insert default social links
INSERT INTO social_links (platform, url, icon_class, display_order) VALUES
('YouTube', 'https://www.youtube.com/@FireStormX-Tri', 'fab fa-youtube', 1),
('Twitter', 'https://twitter.com/skibidimadness', 'fab fa-twitter', 2),
('Discord', 'https://discord.gg/skibidimadness', 'fab fa-discord', 3),
('TikTok', 'https://www.tiktok.com/@skibidimadness', 'fab fa-tiktok', 4);

-- YouTube click analytics table
CREATE TABLE IF NOT EXISTS youtube_clicks (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    clicked_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_ip TEXT,
    user_agent TEXT,
    referrer TEXT
);

CREATE INDEX IF NOT EXISTS idx_youtube_clicks_date ON youtube_clicks(clicked_at);

-- Visitor analytics table
CREATE TABLE IF NOT EXISTS visitors (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    visited_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_ip TEXT,
    user_agent TEXT,
    page_url TEXT,
    referrer TEXT
);

CREATE INDEX IF NOT EXISTS idx_visitors_date ON visitors(visited_at);
CREATE INDEX IF NOT EXISTS idx_visitors_ip ON visitors(user_ip);

-- Insert default admin user (username: admin, password: admin123)
-- Password hash for 'admin123'
INSERT INTO admin_users (username, email, password_hash) VALUES
('admin', 'admin@skibidimadness.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
