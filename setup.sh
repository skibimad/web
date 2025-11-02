#!/bin/bash

# Skibidi Madness - Setup Script
# This script sets up the PHP/MySQL application

echo "========================================="
echo "Skibidi Madness - Installation Script"
echo "========================================="
echo ""

# Check for required tools
echo "Checking required tools..."

if ! command -v php &> /dev/null; then
    echo "ERROR: PHP is not installed. Please install PHP 7.4 or higher."
    exit 1
fi

if ! command -v mysql &> /dev/null; then
    echo "ERROR: MySQL is not installed. Please install MySQL."
    exit 1
fi

if ! command -v composer &> /dev/null; then
    echo "ERROR: Composer is not installed. Please install Composer."
    exit 1
fi

echo "✓ All required tools are installed"
echo ""

# Install dependencies
echo "Installing Composer dependencies..."
composer install
echo "✓ Dependencies installed"
echo ""

# Database setup
echo "Setting up database..."
read -p "MySQL root password (press Enter if no password): " MYSQL_PASSWORD

if [ -z "$MYSQL_PASSWORD" ]; then
    MYSQL_CMD="mysql -u root"
else
    MYSQL_CMD="mysql -u root -p${MYSQL_PASSWORD}"
fi

# Create database and tables
echo "Creating database schema..."
$MYSQL_CMD < database/schema.sql

if [ $? -ne 0 ]; then
    echo "ERROR: Failed to create database schema"
    exit 1
fi

echo "✓ Database schema created"

# Seed database
echo "Seeding database with initial data..."
$MYSQL_CMD < database/seed.sql

if [ $? -ne 0 ]; then
    echo "ERROR: Failed to seed database"
    exit 1
fi

echo "✓ Database seeded with initial data"
echo ""

# Create .env file if not exists
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cat > .env << EOF
DB_HOST=localhost
DB_NAME=skibidi_madness
DB_USER=root
DB_PASS=${MYSQL_PASSWORD}
APP_URL=http://localhost
EOF
    echo "✓ .env file created"
fi

# Set permissions
echo "Setting permissions..."
chmod -R 755 uploads/
chmod -R 755 public/

echo "✓ Permissions set"
echo ""

echo "========================================="
echo "Installation Complete!"
echo "========================================="
echo ""
echo "Default admin credentials:"
echo "  Username: fsx"
echo "  Password: 111111"
echo ""
echo "To start the development server:"
echo "  cd public"
echo "  php -S localhost:8000"
echo ""
echo "Then visit: http://localhost:8000"
echo "Admin area: http://localhost:8000/admin"
echo ""
