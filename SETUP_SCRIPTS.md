# Setup Scripts Documentation

This directory contains automated setup scripts for quick installation of the Skibidi Madness Laravel application.

## Available Scripts

### Unix/Linux/macOS: `setup.sh`

Bash script for Unix-based systems.

**Basic Usage:**
```bash
chmod +x setup.sh
./setup.sh
```

**With Options:**
```bash
# Use MySQL instead of SQLite
./setup.sh --mysql

# Skip database seeding
./setup.sh --no-seed

# Skip composer install (if dependencies already installed)
./setup.sh --skip-deps

# Combine options
./setup.sh --mysql --no-seed
```

### Windows: `setup.bat`

Batch script for Windows systems.

**Basic Usage:**
```cmd
setup.bat
```

**With Options:**
```cmd
REM Use MySQL instead of SQLite
setup.bat --mysql

REM Skip database seeding
setup.bat --no-seed

REM Skip composer install
setup.bat --skip-deps

REM Combine options
setup.bat --mysql --no-seed
```

## What These Scripts Do

Both scripts perform the following steps automatically:

1. **✓ Check Prerequisites**
   - Verify PHP 8.2+ is installed
   - Verify Composer is installed
   - Check MySQL if --mysql option is used

2. **✓ Install Dependencies**
   - Run `composer install` with optimized settings
   - Can be skipped with `--skip-deps` flag

3. **✓ Environment Setup**
   - Copy `.env.example` to `.env`
   - Generate application key with `php artisan key:generate`

4. **✓ Database Configuration**
   - **SQLite (default)**: Create `database/database.sqlite` file
   - **MySQL (--mysql flag)**: Interactive prompt for credentials
     - Host (default: 127.0.0.1)
     - Port (default: 3306)
     - Database name (default: skibidi_madness)
     - Username (default: root)
     - Password

5. **✓ Storage Setup**
   - Create storage directories (cache, sessions, views, logs)
   - Set proper permissions (Unix only)

6. **✓ Database Migration**
   - Run `php artisan migrate --force`
   - Create tables: heroes, episodes, blog_posts

7. **✓ Database Seeding** (optional)
   - Populate database with default data
   - 5 heroes (Titan Cameraman, Titan Speakerman, etc.)
   - 5 episodes
   - Skip with `--no-seed` flag

8. **✓ Cache Clearing**
   - Clear config, route, view, and application caches

9. **✓ Server Startup** (optional)
   - Offers to start `php artisan serve`
   - Access application at http://localhost:8000

## Script Options

| Option | Description |
|--------|-------------|
| `--mysql` | Use MySQL database instead of SQLite |
| `--no-seed` | Skip database seeding (useful for empty database) |
| `--skip-deps` | Skip `composer install` (use if dependencies already installed) |
| `--help` | Display help message with all options |

## Example Scenarios

### Scenario 1: Quick Start (SQLite)
```bash
# Linux/macOS
./setup.sh

# Windows
setup.bat
```
**Result**: Complete setup with SQLite, seeded data, ready to serve

### Scenario 2: Production Setup (MySQL)
```bash
# Linux/macOS
./setup.sh --mysql --no-seed

# Windows
setup.bat --mysql --no-seed
```
**Result**: MySQL configuration, empty database, ready for production data

### Scenario 3: Reinstall (keep dependencies)
```bash
# Linux/macOS
./setup.sh --skip-deps

# Windows
setup.bat --skip-deps
```
**Result**: Skip composer install, reconfigure everything else

### Scenario 4: Development Reset
```bash
# Linux/macOS
./setup.sh --no-seed --skip-deps

# Windows
setup.bat --no-seed --skip-deps
```
**Result**: Fresh database without seed data, dependencies unchanged

## Troubleshooting

### Permission Denied (Unix)
```bash
chmod +x setup.sh
./setup.sh
```

### PHP Not Found
- **Unix**: Install PHP 8.2+ via package manager (apt, yum, brew)
- **Windows**: Download from https://windows.php.net/download/

### Composer Not Found
- Install from https://getcomposer.org/download/

### MySQL Connection Failed
- Verify MySQL is running
- Check credentials
- Ensure database exists: `CREATE DATABASE skibidi_madness;`

### SQLite Permission Issues
```bash
# Unix/Linux
chmod 775 database
chmod 664 database/database.sqlite

# Or give write permission to web server user
sudo chown -R www-data:www-data database
```

### Migration Errors
```bash
# Clear cache and retry
php artisan config:clear
php artisan migrate:fresh --seed
```

## Manual Setup Alternative

If you prefer manual setup or the script fails, follow these steps:

```bash
# 1. Install dependencies
composer install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Create database
touch database/database.sqlite

# 4. Run migrations
php artisan migrate

# 5. Seed database
php artisan db:seed

# 6. Start server
php artisan serve
```

See [QUICKSTART.md](QUICKSTART.md) for detailed manual instructions.

## Post-Setup

After successful setup:

### Access the Application
- **Homepage**: http://localhost:8000
- **Blog**: http://localhost:8000/blog
- **Admin Panel**: http://localhost:8000/admin

### Test the API
```bash
# Get all heroes
curl http://localhost:8000/api/heroes

# Get all episodes
curl http://localhost:8000/api/episodes

# Get recent blog posts
curl http://localhost:8000/api/blog-posts-recent
```

### Next Steps
1. Read [README-LARAVEL.md](README-LARAVEL.md) for full documentation
2. Explore the admin panel to manage content
3. Check [PACKAGE_USAGE.md](PACKAGE_USAGE.md) to use as a package
4. See [MIGRATION_GUIDE.md](MIGRATION_GUIDE.md) for migration details

## Requirements

- **PHP**: 8.2 or higher
- **Composer**: Latest version
- **Database**: SQLite (default) or MySQL 5.7+
- **Disk Space**: ~100MB for dependencies
- **Memory**: 512MB minimum

## What Gets Installed

- Laravel 11 framework
- All Composer dependencies (~70MB)
- Database tables (heroes, episodes, blog_posts)
- Default seeded data (if not skipped)
- All public assets (images, videos, CSS, JS)

## Safety Features

- ✓ Checks prerequisites before starting
- ✓ Creates backups of existing .env (manual backup recommended)
- ✓ Exits on error (won't partially install)
- ✓ Colored output for easy reading (Unix only)
- ✓ Confirmation before starting server
- ✓ Non-destructive (won't delete existing data)

## Support

If you encounter issues:

1. Check the troubleshooting section above
2. Review [QUICKSTART.md](QUICKSTART.md) for manual setup
3. Open an issue on GitHub
4. Check Laravel documentation: https://laravel.com/docs

---

**Made with ❤️ by FireStormX Studios**

*Where Chaos Meets Destiny*
