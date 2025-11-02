-- Skibidi Madness Database Schema

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Heroes table
CREATE TABLE IF NOT EXISTS heroes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    slug TEXT UNIQUE NOT NULL,
    description TEXT,
    image_path TEXT,
    video_path TEXT,
    ability1 TEXT,
    ability2 TEXT,
    ability3 TEXT,
    display_order INTEGER DEFAULT 0
);

-- Episodes table
CREATE TABLE IF NOT EXISTS episodes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    episode_number INTEGER NOT NULL,
    title TEXT NOT NULL,
    description TEXT,
    thumbnail_path TEXT,
    youtube_url TEXT,
    duration TEXT,
    release_date DATE
);

-- Blog posts table
CREATE TABLE IF NOT EXISTS blog_posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    slug TEXT UNIQUE NOT NULL,
    featured_image TEXT,
    excerpt TEXT,
    content TEXT,
    author TEXT DEFAULT 'FireStormX Studios',
    publish_date DATE,
    is_published INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Static content table
CREATE TABLE IF NOT EXISTS static_content (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    content_key TEXT UNIQUE NOT NULL,
    content_value TEXT
);
