#!/bin/bash

# Skibidi Madness Installation Script
# This script sets up the MySQL database and configures the application

echo "================================"
echo "Skibidi Madness Setup"
echo "================================"
echo ""

# Check if MySQL is installed
if ! command -v mysql &> /dev/null; then
    echo "ERROR: MySQL is not installed. Please install MySQL first."
    exit 1
fi

echo "This script will:"
echo "1. Create the database 'skibidi_madness'"
echo "2. Set up all tables"
echo "3. Seed initial demo data"
echo ""

# Prompt for MySQL credentials
read -p "MySQL host [localhost]: " DB_HOST
DB_HOST=${DB_HOST:-localhost}

read -p "MySQL username [root]: " DB_USER
DB_USER=${DB_USER:-root}

read -sp "MySQL password: " DB_PASS
echo ""
echo ""

# Test MySQL connection
echo "Testing MySQL connection..."
mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" -e "SELECT 1;" > /dev/null 2>&1

if [ $? -ne 0 ]; then
    echo "ERROR: Could not connect to MySQL. Please check your credentials."
    exit 1
fi

echo "Connection successful!"
echo ""

# Run the database setup
echo "Creating database and tables..."
mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" < setup/database.sql

if [ $? -eq 0 ]; then
    echo "✓ Database created successfully!"
else
    echo "ERROR: Failed to create database"
    exit 1
fi

# Update config.php with database credentials
echo ""
echo "Updating configuration file..."

# Create config.php if it doesn't exist or update it
cat > config.php << EOL
<?php
// Database Configuration
define('DB_HOST', '$DB_HOST');
define('DB_NAME', 'skibidi_madness');
define('DB_USER', '$DB_USER');
define('DB_PASS', '$DB_PASS');
define('DB_CHARSET', 'utf8mb4');

// Application Settings
define('APP_NAME', 'Skibidi Madness');
define('BASE_URL', '');  // Leave empty for auto-detection or set your domain
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('UPLOAD_URL', '/uploads/');

// Session Settings
define('SESSION_NAME', 'skibidi_admin');
define('SESSION_LIFETIME', 7200); // 2 hours

// Timezone
date_default_timezone_set('UTC');

// Error Reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
EOL

echo "✓ Configuration updated!"

# Create uploads directory with proper permissions
echo ""
echo "Setting up uploads directory..."
mkdir -p uploads/heroes uploads/episodes uploads/blog
chmod -R 755 uploads

echo "✓ Uploads directory created!"

echo ""
echo "================================"
echo "Installation Complete!"
echo "================================"
echo ""
echo "Next steps:"
echo "1. Configure your Apache virtual host to point to this directory"
echo "2. Enable mod_rewrite in Apache"
echo "3. Access the admin panel at: http://your-domain/admin/"
echo ""
echo "Default admin credentials:"
echo "  Username: fsx"
echo "  Password: 111111"
echo ""
echo "IMPORTANT: Change the admin password after first login!"
echo ""
