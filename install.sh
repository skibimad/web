#!/bin/bash

echo "========================================="
echo "  Skibidi Madness - Installation Script"
echo "========================================="
echo ""

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo -e "${RED}Error: PHP is not installed.${NC}"
    echo "Please install PHP 8.2 or higher."
    exit 1
fi

# Check PHP version
PHP_VERSION=$(php -r 'echo PHP_VERSION;')
echo -e "${GREEN}✓ PHP $PHP_VERSION detected${NC}"

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    echo -e "${YELLOW}Warning: Composer is not installed.${NC}"
    echo "Please install Composer from https://getcomposer.org/"
    exit 1
fi
echo -e "${GREEN}✓ Composer detected${NC}"

echo ""
echo "========================================="
echo "  Database Configuration"
echo "========================================="
echo ""

# Get database credentials
read -p "Enter MySQL host [localhost]: " DB_HOST
DB_HOST=${DB_HOST:-localhost}

read -p "Enter MySQL port [3306]: " DB_PORT
DB_PORT=${DB_PORT:-3306}

read -p "Enter database name [skibidi_madness]: " DB_NAME
DB_NAME=${DB_NAME:-skibidi_madness}

read -p "Enter MySQL username [root]: " DB_USER
DB_USER=${DB_USER:-root}

read -sp "Enter MySQL password: " DB_PASS
echo ""

# Test database connection
echo ""
echo "Testing database connection..."
mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USER" -p"$DB_PASS" -e "SELECT 1;" &> /dev/null

if [ $? -ne 0 ]; then
    echo -e "${RED}✗ Database connection failed!${NC}"
    echo "Please check your credentials and try again."
    exit 1
fi
echo -e "${GREEN}✓ Database connection successful${NC}"

# Create .env file
echo ""
echo "Creating .env file..."
cat > .env << EOF
DB_DRIVER=mysql
DB_HOST=$DB_HOST
DB_PORT=$DB_PORT
DB_NAME=$DB_NAME
DB_USER=$DB_USER
DB_PASS=$DB_PASS
EOF
echo -e "${GREEN}✓ .env file created${NC}"

# Install Composer dependencies
echo ""
echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

if [ $? -ne 0 ]; then
    echo -e "${RED}✗ Composer install failed!${NC}"
    exit 1
fi
echo -e "${GREEN}✓ Composer dependencies installed${NC}"

# Create database if it doesn't exist
echo ""
echo "Creating database..."
mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" &> /dev/null
echo -e "${GREEN}✓ Database created/verified${NC}"

# Run migrations
echo ""
echo "Running database migrations..."
php migrate.php

if [ $? -ne 0 ]; then
    echo -e "${RED}✗ Migration failed!${NC}"
    exit 1
fi
echo -e "${GREEN}✓ Migrations completed${NC}"

# Create uploads directory
echo ""
echo "Creating uploads directory..."
mkdir -p uploads/heroes uploads/blog uploads/episodes uploads/landing
chmod -R 755 uploads
echo -e "${GREEN}✓ Uploads directory created${NC}"

# Create fun videos directory
echo ""
echo "Creating res/video/fun directory..."
mkdir -p res/video/fun
chmod -R 755 res/video/fun
echo -e "${GREEN}✓ Fun videos directory created${NC}"

echo ""
echo "========================================="
echo "  Installation Complete!"
echo "========================================="
echo ""
echo -e "${GREEN}✓ Skibidi Madness has been successfully installed!${NC}"
echo ""
echo "Next steps:"
echo "  1. Start the development server:"
echo "     ${YELLOW}php -S localhost:8000 -t .${NC}"
echo ""
echo "  2. Visit the website:"
echo "     ${YELLOW}http://localhost:8000${NC}"
echo ""
echo "  3. Access the admin panel:"
echo "     ${YELLOW}http://localhost:8000/admin${NC}"
echo ""
echo "Admin Credentials:"
echo "  - Username: ${GREEN}admin${NC} / Password: ${GREEN}admin123${NC}"
echo "  - Username: ${GREEN}fsx${NC} / Password: ${GREEN}111111${NC}"
echo ""
echo "Optional: Add background videos to res/video/fun/ for error pages"
echo ""
