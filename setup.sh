#!/bin/bash

###############################################################################
# Skibidi Madness - Automated Setup Script
# 
# This script automates the complete setup process for the Laravel application
# including dependency installation, environment configuration, database setup,
# migrations, seeding, and server startup.
#
# Usage:
#   chmod +x setup.sh
#   ./setup.sh
#
# Options:
#   ./setup.sh --mysql          Use MySQL instead of SQLite
#   ./setup.sh --no-seed        Skip database seeding
#   ./setup.sh --skip-deps      Skip composer install (if already installed)
#   ./setup.sh --help           Show this help message
###############################################################################

set -e  # Exit on error

# Color codes for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Default options
USE_MYSQL=false
SKIP_SEED=false
SKIP_DEPS=false

# Parse command line arguments
while [[ $# -gt 0 ]]; do
    case $1 in
        --mysql)
            USE_MYSQL=true
            shift
            ;;
        --no-seed)
            SKIP_SEED=true
            shift
            ;;
        --skip-deps)
            SKIP_DEPS=true
            shift
            ;;
        --help)
            echo "Skibidi Madness - Automated Setup Script"
            echo ""
            echo "Usage: ./setup.sh [OPTIONS]"
            echo ""
            echo "Options:"
            echo "  --mysql        Use MySQL instead of SQLite"
            echo "  --no-seed      Skip database seeding"
            echo "  --skip-deps    Skip composer install"
            echo "  --help         Show this help message"
            echo ""
            exit 0
            ;;
        *)
            echo -e "${RED}Unknown option: $1${NC}"
            echo "Use --help for usage information"
            exit 1
            ;;
    esac
done

# Print colored output
print_step() {
    echo -e "${BLUE}==>${NC} ${GREEN}$1${NC}"
}

print_info() {
    echo -e "${YELLOW}ℹ${NC}  $1"
}

print_error() {
    echo -e "${RED}✗${NC}  $1"
}

print_success() {
    echo -e "${GREEN}✓${NC}  $1"
}

# Display banner
echo -e "${GREEN}"
cat << "EOF"
╔═══════════════════════════════════════════════════════════╗
║                                                           ║
║        SKIBIDI MADNESS - Laravel Setup Script            ║
║                                                           ║
║        Where Chaos Meets Destiny                         ║
║                                                           ║
╚═══════════════════════════════════════════════════════════╝
EOF
echo -e "${NC}"

# Step 1: Check prerequisites
print_step "Checking prerequisites..."

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    print_error "PHP is not installed. Please install PHP 8.2 or higher."
    exit 1
fi

# Check PHP version
PHP_VERSION=$(php -r "echo PHP_VERSION;")
PHP_MAJOR=$(php -r "echo PHP_MAJOR_VERSION;")
PHP_MINOR=$(php -r "echo PHP_MINOR_VERSION;")

if [ "$PHP_MAJOR" -lt 8 ] || ([ "$PHP_MAJOR" -eq 8 ] && [ "$PHP_MINOR" -lt 2 ]); then
    print_error "PHP version $PHP_VERSION detected. PHP 8.2 or higher is required."
    exit 1
fi
print_success "PHP $PHP_VERSION detected"

# Check if Composer is installed
if ! command -v composer &> /dev/null; then
    print_error "Composer is not installed. Please install Composer first."
    print_info "Visit: https://getcomposer.org/download/"
    exit 1
fi
print_success "Composer detected"

# Check for MySQL if requested
if [ "$USE_MYSQL" = true ]; then
    if ! command -v mysql &> /dev/null; then
        print_error "MySQL is not installed but --mysql option was specified."
        exit 1
    fi
    print_success "MySQL detected"
fi

# Step 2: Install Composer dependencies
if [ "$SKIP_DEPS" = false ]; then
    print_step "Installing Composer dependencies..."
    if composer install --no-interaction --prefer-dist --optimize-autoloader; then
        print_success "Dependencies installed successfully"
    else
        print_error "Failed to install dependencies"
        exit 1
    fi
else
    print_info "Skipping dependency installation (--skip-deps)"
fi

# Step 3: Setup environment file
print_step "Setting up environment configuration..."

if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        cp .env.example .env
        print_success "Environment file created from .env.example"
    else
        print_error ".env.example file not found"
        exit 1
    fi
else
    print_info "Environment file already exists, skipping..."
fi

# Step 4: Generate application key
print_step "Generating application key..."
if php artisan key:generate --ansi; then
    print_success "Application key generated"
else
    print_error "Failed to generate application key"
    exit 1
fi

# Step 5: Configure database
print_step "Configuring database..."

if [ "$USE_MYSQL" = true ]; then
    print_info "MySQL configuration selected"
    
    # Prompt for MySQL credentials
    read -p "Enter MySQL host [127.0.0.1]: " DB_HOST
    DB_HOST=${DB_HOST:-127.0.0.1}
    
    read -p "Enter MySQL port [3306]: " DB_PORT
    DB_PORT=${DB_PORT:-3306}
    
    read -p "Enter database name [skibidi_madness]: " DB_DATABASE
    DB_DATABASE=${DB_DATABASE:-skibidi_madness}
    
    read -p "Enter MySQL username [root]: " DB_USERNAME
    DB_USERNAME=${DB_USERNAME:-root}
    
    read -sp "Enter MySQL password: " DB_PASSWORD
    echo ""
    
    # Update .env file
    sed -i "s/DB_CONNECTION=.*/DB_CONNECTION=mysql/" .env
    sed -i "s/# DB_HOST=.*/DB_HOST=$DB_HOST/" .env
    sed -i "s/# DB_PORT=.*/DB_PORT=$DB_PORT/" .env
    sed -i "s/# DB_DATABASE=.*/DB_DATABASE=$DB_DATABASE/" .env
    sed -i "s/# DB_USERNAME=.*/DB_USERNAME=$DB_USERNAME/" .env
    sed -i "s/# DB_PASSWORD=.*/DB_PASSWORD=$DB_PASSWORD/" .env
    
    # Try to create database
    print_info "Creating MySQL database..."
    mysql -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USERNAME" -p"$DB_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS $DB_DATABASE;" 2>/dev/null || {
        print_error "Failed to create database. Please create it manually:"
        echo "  mysql -u root -p -e \"CREATE DATABASE $DB_DATABASE;\""
    }
    
    print_success "MySQL configured"
else
    # SQLite configuration (default)
    print_info "SQLite configuration selected (default)"
    
    # Create database directory if it doesn't exist
    mkdir -p database
    
    # Create SQLite database file
    if [ ! -f database/database.sqlite ]; then
        touch database/database.sqlite
        print_success "SQLite database file created"
    else
        print_info "SQLite database file already exists"
    fi
fi

# Step 6: Create storage directories and set permissions
print_step "Setting up storage directories..."
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p storage/logs
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
print_success "Storage directories created"

# Step 7: Run migrations
print_step "Running database migrations..."
if php artisan migrate --force --no-interaction; then
    print_success "Database migrations completed"
else
    print_error "Failed to run migrations"
    exit 1
fi

# Step 8: Seed database (if not skipped)
if [ "$SKIP_SEED" = false ]; then
    print_step "Seeding database with default data..."
    if php artisan db:seed --force --no-interaction; then
        print_success "Database seeded successfully"
        print_info "  → 5 heroes added"
        print_info "  → 5 episodes added"
    else
        print_error "Failed to seed database"
        exit 1
    fi
else
    print_info "Skipping database seeding (--no-seed)"
fi

# Step 9: Clear caches
print_step "Clearing application caches..."
php artisan config:clear > /dev/null 2>&1 || true
php artisan route:clear > /dev/null 2>&1 || true
php artisan view:clear > /dev/null 2>&1 || true
php artisan cache:clear > /dev/null 2>&1 || true
print_success "Caches cleared"

# Step 10: Display summary
echo ""
echo -e "${GREEN}╔═══════════════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║                                                           ║${NC}"
echo -e "${GREEN}║          🎉  SETUP COMPLETED SUCCESSFULLY! 🎉            ║${NC}"
echo -e "${GREEN}║                                                           ║${NC}"
echo -e "${GREEN}╚═══════════════════════════════════════════════════════════╝${NC}"
echo ""

print_success "Skibidi Madness is ready to use!"
echo ""

# Display application information
echo -e "${BLUE}Application Information:${NC}"
echo "  • PHP Version: $PHP_VERSION"
echo "  • Database: $([ "$USE_MYSQL" = true ] && echo "MySQL ($DB_DATABASE)" || echo "SQLite")"
echo "  • Environment: $(grep APP_ENV .env | cut -d '=' -f2)"
echo ""

echo -e "${BLUE}What's Next?${NC}"
echo ""
echo "1. Start the development server:"
echo -e "   ${YELLOW}php artisan serve${NC}"
echo ""
echo "2. Access the application:"
echo -e "   ${YELLOW}http://localhost:8000${NC}"
echo ""
echo "3. Available pages:"
echo "   • Homepage:       http://localhost:8000"
echo "   • Blog:           http://localhost:8000/blog"
echo "   • Admin Panel:    http://localhost:8000/admin"
echo "   • Manage Heroes:  http://localhost:8000/admin/heroes"
echo "   • Manage Episodes: http://localhost:8000/admin/episodes"
echo "   • Manage Blog:    http://localhost:8000/admin/blog"
echo ""
echo "4. API Endpoints:"
echo "   • Heroes API:     http://localhost:8000/api/heroes"
echo "   • Episodes API:   http://localhost:8000/api/episodes"
echo "   • Blog Posts API: http://localhost:8000/api/blog-posts"
echo ""

# Offer to start the server
echo -e "${YELLOW}Would you like to start the development server now? (y/n)${NC}"
read -r START_SERVER

if [[ "$START_SERVER" =~ ^[Yy]$ ]]; then
    echo ""
    print_step "Starting development server..."
    echo -e "${GREEN}Server running at http://localhost:8000${NC}"
    echo -e "${YELLOW}Press Ctrl+C to stop the server${NC}"
    echo ""
    php artisan serve
else
    echo ""
    print_info "You can start the server later with: php artisan serve"
    echo ""
fi

exit 0
