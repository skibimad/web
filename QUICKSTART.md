# 🚀 Quick Start Guide - Skibidi Madness Laravel

Get up and running with Skibidi Madness in 5 minutes!

## Prerequisites

Make sure you have installed:
- PHP 8.2 or higher
- Composer
- SQLite or MySQL

Check your PHP version:
```bash
php -v
```

## Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/skibimad/web.git skibidi-madness
cd skibidi-madness
```

### 2. Install Laravel Dependencies

```bash
composer install
```

> **Note**: If you don't have Laravel installed yet, Composer will download all required packages.

### 3. Set Up Environment

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Create Database

**For SQLite (Recommended for development):**
```bash
touch database/database.sqlite
```

**For MySQL:**
```bash
# Create database
mysql -u root -p -e "CREATE DATABASE skibidi_madness"

# Update .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=skibidi_madness
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run Migrations & Seed Data

```bash
php artisan migrate --seed
```

This will:
- Create `heroes`, `episodes`, and `blog_posts` tables
- Populate with 5 heroes and 5 episodes

### 6. Start Development Server

```bash
php artisan serve
```

### 7. Open in Browser

Visit: **http://localhost:8000**

🎉 **You're done!**

## What You Have Now

### Frontend Pages
- **Homepage**: http://localhost:8000
- **Blog**: http://localhost:8000/blog
- **Admin Dashboard**: http://localhost:8000/admin
- **Manage Heroes**: http://localhost:8000/admin/heroes
- **Manage Episodes**: http://localhost:8000/admin/episodes
- **Manage Blog**: http://localhost:8000/admin/blog

### API Endpoints
- **Heroes API**: http://localhost:8000/api/heroes
- **Episodes API**: http://localhost:8000/api/episodes
- **Blog Posts API**: http://localhost:8000/api/blog-posts

## Testing the API

### Get All Heroes
```bash
curl http://localhost:8000/api/heroes
```

### Get All Episodes
```bash
curl http://localhost:8000/api/episodes
```

### Get Recent Blog Posts
```bash
curl http://localhost:8000/api/blog-posts-recent
```

### Create a Blog Post
```bash
curl -X POST http://localhost:8000/api/blog-posts \
  -H "Content-Type: application/json" \
  -d '{
    "title": "My First Post",
    "slug": "my-first-post",
    "content": "This is my first blog post!",
    "published": true,
    "published_at": "2024-01-01"
  }'
```

## Using the Admin Panel

1. Navigate to http://localhost:8000/admin
2. Click on "Heroes", "Episodes", or "Blog" to manage content
3. Add, edit, or delete entries
4. Changes are automatically saved to the database

## Common Commands

### Database

```bash
# Reset database and reseed
php artisan migrate:fresh --seed

# Check migration status
php artisan migrate:status

# Rollback last migration
php artisan migrate:rollback
```

### Cache

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Development

```bash
# Watch for changes
php artisan serve

# Run on different port
php artisan serve --port=8080

# Run on specific host
php artisan serve --host=0.0.0.0
```

## Customization

### Change Default Language

Edit `config/skibidi-madness.php`:
```php
'frontend' => [
    'default_language' => 'es', // Spanish
],
```

### Change Pagination

Edit `config/skibidi-madness.php`:
```php
'pagination' => [
    'blog_posts_per_page' => 20,
],
```

### Add Your Own Hero

```bash
php artisan tinker
```

```php
App\Models\Hero::create([
    'name' => 'Your Hero Name',
    'slug' => 'your-hero-name',
    'description' => 'Hero description',
    'image_path' => 'res/img/heroes/promo/your-hero.png',
    'video_path' => 'res/video/heroes/promo/your-hero.mp4',
    'abilities' => ['Ability 1', 'Ability 2', 'Ability 3'],
    'order' => 6,
    'active' => true,
]);
```

## Troubleshooting

### "Class not found" errors
```bash
composer dump-autoload
```

### Database connection errors
```bash
# Check .env file
cat .env | grep DB_

# Verify database exists
php artisan migrate:status
```

### Permission errors
```bash
chmod -R 775 storage bootstrap/cache
```

### Port already in use
```bash
# Use different port
php artisan serve --port=8001
```

### Assets not loading
```bash
# Clear browser cache
# Or use Ctrl+Shift+R (hard refresh)
```

## Next Steps

### 1. Read Full Documentation
- [README-LARAVEL.md](README-LARAVEL.md) - Complete guide
- [PACKAGE_USAGE.md](PACKAGE_USAGE.md) - Use as package
- [MIGRATION_GUIDE.md](MIGRATION_GUIDE.md) - Migration details

### 2. Add Authentication (Optional)
```bash
composer require laravel/breeze
php artisan breeze:install
npm install && npm run dev
php artisan migrate
```

### 3. Deploy to Production
See deployment section in [README-LARAVEL.md](README-LARAVEL.md)

### 4. Customize Frontend
- Edit Blade templates in `resources/views/`
- Modify CSS in `public/styles/main.css`
- Update JavaScript in `public/scripts/`

### 5. Extend the API
- Add new models in `app/Models/`
- Create controllers in `app/Http/Controllers/`
- Define routes in `routes/api.php`

## Getting Help

- **Documentation**: See all .md files in root directory
- **Laravel Docs**: https://laravel.com/docs
- **Issues**: https://github.com/skibimad/web/issues

## Quick Reference

### File Locations
```
📁 Models: app/Models/
📁 Controllers: app/Http/Controllers/
📁 Migrations: database/migrations/
📁 Seeders: database/seeders/
📁 Views: resources/views/
📁 Routes: routes/
📁 Config: config/
📁 Public: public/
```

### Default Data
- 5 Heroes seeded
- 5 Episodes seeded
- Blog ready (empty)

### Database
- SQLite: `database/database.sqlite`
- Tables: `heroes`, `episodes`, `blog_posts`

---

**Happy coding! 🎬**

Made with ❤️ by FireStormX Studios
