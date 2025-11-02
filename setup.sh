#!/bin/bash
# Setup script for Skibidi Madness MVC Application

echo "🎬 Skibidi Madness - Setup Script"
echo "=================================="
echo ""

# Check PHP version
echo "Checking PHP version..."
PHP_VERSION=$(php -r 'echo PHP_VERSION;')
echo "PHP version: $PHP_VERSION"

if php -r 'exit(version_compare(PHP_VERSION, "8.2.0", "<") ? 1 : 0);'; then
    echo "✅ PHP version is >= 8.2"
else
    echo "❌ PHP version must be >= 8.2"
    exit 1
fi

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install composer first."
    exit 1
fi
echo "✅ Composer is installed"

# Install dependencies
echo ""
echo "Installing dependencies..."
composer install --no-interaction

# Setup database
echo ""
echo "Setting up database..."
DB_FILE="database/skibidi_madness.db"

if [ -f "$DB_FILE" ]; then
    read -p "Database already exists. Do you want to recreate it? (y/N) " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        rm "$DB_FILE"
        sqlite3 "$DB_FILE" < database/schema_sqlite.sql
        echo "✅ Database recreated successfully"
    else
        echo "ℹ️  Using existing database"
    fi
else
    sqlite3 "$DB_FILE" < database/schema_sqlite.sql
    echo "✅ Database created successfully"
fi

# Verify database
HERO_COUNT=$(sqlite3 "$DB_FILE" "SELECT COUNT(*) FROM heroes;")
EPISODE_COUNT=$(sqlite3 "$DB_FILE" "SELECT COUNT(*) FROM episodes;")
BLOG_COUNT=$(sqlite3 "$DB_FILE" "SELECT COUNT(*) FROM blog_posts;")

echo ""
echo "Database statistics:"
echo "  - Heroes: $HERO_COUNT"
echo "  - Episodes: $EPISODE_COUNT"
echo "  - Blog Posts: $BLOG_COUNT"

echo ""
echo "✅ Setup complete!"
echo ""
echo "To start the development server, run:"
echo "  php -S localhost:8000 -t ."
echo ""
echo "Then open http://localhost:8000 in your browser"
echo ""
echo "Admin panel: http://localhost:8000/admin"
