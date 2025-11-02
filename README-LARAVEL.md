# 🎬 Skibidi Madness - Laravel Application

![Skibidi Madness](public/res/img/all-together.png)

## 🌟 Overview

**Skibidi Madness** is now a full Laravel-based web application with a RESTful API backend. This is a complete refactor from the original static HTML site to a modern Laravel framework with database persistence, service providers, and proper MVC architecture.

## 🚀 Quick Start

### Prerequisites

- PHP 8.2 or higher
- Composer
- SQLite (default) or MySQL/PostgreSQL

### Installation

1. **Clone the repository**
```bash
git clone https://github.com/skibimad/web.git
cd web
```

2. **Install dependencies**
```bash
composer install
```

3. **Set up environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Create the database**
```bash
touch database/database.sqlite
```

5. **Run migrations and seed data**
```bash
php artisan migrate --seed
```

6. **Start the development server**
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser!

## 📁 Project Structure

```
skibidi-madness/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── HeroController.php
│   │       ├── EpisodeController.php
│   │       └── BlogPostController.php
│   └── Models/
│       ├── Hero.php
│       ├── Episode.php
│       └── BlogPost.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_heroes_table.php
│   │   ├── 2024_01_01_000002_create_episodes_table.php
│   │   └── 2024_01_01_000003_create_blog_posts_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── HeroSeeder.php
│       └── EpisodeSeeder.php
├── public/
│   ├── index.php (Laravel entry point)
│   ├── res/ (images and videos)
│   ├── scripts/ (JavaScript files)
│   └── styles/ (CSS files)
├── resources/
│   └── views/
│       └── layouts/
│           └── app.blade.php
├── routes/
│   ├── web.php (Web routes)
│   ├── api.php (API routes)
│   └── console.php (Artisan commands)
└── config/ (Laravel configuration)
```

## 🎯 Features

### Backend (Laravel)

- **RESTful API**: Full CRUD operations for Heroes, Episodes, and Blog Posts
- **Database Models**: Eloquent ORM models with relationships
- **Migrations**: Database schema version control
- **Seeders**: Default data population
- **Service Providers**: Modular architecture
- **Route Model Binding**: Automatic model resolution
- **Validation**: Request validation for all inputs

### Frontend

- **Multi-language Support**: English, Spanish, French, German
- **Responsive Design**: Mobile-first approach
- **Admin Panel**: Manage heroes, episodes, and blog posts
- **Blog System**: Full-featured blog with publishing
- **Video Integration**: YouTube embeds and local videos
- **Smooth Animations**: Professional UI effects

## 🔌 API Endpoints

### Heroes

```
GET    /api/heroes          - List all active heroes
POST   /api/heroes          - Create a new hero
GET    /api/heroes/{hero}   - Get hero details
PUT    /api/heroes/{hero}   - Update hero
DELETE /api/heroes/{hero}   - Delete hero
```

### Episodes

```
GET    /api/episodes            - List published episodes
POST   /api/episodes            - Create new episode
GET    /api/episodes/{episode}  - Get episode details
PUT    /api/episodes/{episode}  - Update episode
DELETE /api/episodes/{episode}  - Delete episode
```

### Blog Posts

```
GET    /api/blog-posts              - List published posts
GET    /api/blog-posts?all=1        - List all posts (including drafts)
POST   /api/blog-posts              - Create new post
GET    /api/blog-posts/{post}       - Get post details
PUT    /api/blog-posts/{post}       - Update post
DELETE /api/blog-posts/{post}       - Delete post
GET    /api/blog-posts-recent       - Get recent posts (for homepage)
```

## 🎨 Frontend Pages

- `/` - Homepage
- `/blog` - Blog listing
- `/admin` - Admin dashboard
- `/admin/heroes` - Manage heroes
- `/admin/episodes` - Manage episodes
- `/admin/blog` - Manage blog posts

## 🗄️ Database Schema

### Heroes Table

| Column      | Type    | Description                      |
|-------------|---------|----------------------------------|
| id          | bigint  | Primary key                      |
| name        | string  | Hero name                        |
| slug        | string  | URL-friendly identifier (unique) |
| description | text    | Hero description                 |
| image_path  | string  | Path to hero image               |
| video_path  | string  | Path to hero video               |
| abilities   | json    | Array of abilities               |
| order       | integer | Display order                    |
| active      | boolean | Active status                    |

### Episodes Table

| Column         | Type      | Description                      |
|----------------|-----------|----------------------------------|
| id             | bigint    | Primary key                      |
| title          | string    | Episode title                    |
| slug           | string    | URL-friendly identifier (unique) |
| description    | text      | Episode description              |
| thumbnail      | string    | Thumbnail image path             |
| video_url      | string    | YouTube or video URL             |
| episode_number | integer   | Episode number (unique)          |
| published_at   | timestamp | Publication date                 |
| featured       | boolean   | Featured status                  |

### Blog Posts Table

| Column       | Type      | Description                      |
|--------------|-----------|----------------------------------|
| id           | bigint    | Primary key                      |
| title        | string    | Post title                       |
| slug         | string    | URL-friendly identifier (unique) |
| excerpt      | text      | Short excerpt                    |
| content      | longtext  | Full content                     |
| image        | string    | Featured image path              |
| author       | string    | Author name                      |
| published_at | timestamp | Publication date                 |
| published    | boolean   | Published status                 |

## 🔧 Configuration

### Database

By default, the application uses SQLite. To use MySQL/PostgreSQL:

1. Update `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=skibidi_madness
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

2. Create the database:
```bash
mysql -u root -p -e "CREATE DATABASE skibidi_madness"
```

3. Run migrations:
```bash
php artisan migrate --seed
```

### CORS (for API access)

If you need to access the API from a different domain, install Laravel CORS:

```bash
composer require fruitcake/laravel-cors
```

## 📦 Package Usage

This Laravel application can also be used as a package. To include it in another Laravel project:

1. Add to your `composer.json`:
```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/skibimad/web"
        }
    ],
    "require": {
        "skibimad/skibidi-madness": "dev-main"
    }
}
```

2. Run `composer update`

3. Publish migrations:
```bash
php artisan vendor:publish --tag=skibidi-migrations
```

4. Run migrations:
```bash
php artisan migrate
```

## 🧪 Development

### Running Tests

```bash
php artisan test
```

### Code Style

```bash
./vendor/bin/pint
```

### Clear Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 🌐 Deployment

### Production Setup

1. Set environment to production in `.env`:
```env
APP_ENV=production
APP_DEBUG=false
```

2. Optimize for production:
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Set up web server (Nginx/Apache) to point to `public/` directory

### Example Nginx Configuration

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/skibidi-madness/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

See [LICENSE](LICENSE) file for details.

## ⚠️ Disclaimer

**Skibidi Madness** is a fan-created series inspired by the Skibidi Toilet universe. This project is not officially affiliated with the original creators (DaFuq!?Boom! or other community creators). All trademarks and copyrights belong to their respective owners.

## 📞 Support

- **YouTube**: [@FireStormX!?](https://www.youtube.com/@FireStormX!?)
- **Issues**: Use GitHub Issues for bug reports
- **Discussions**: Use GitHub Discussions for questions

---

**Made with ❤️ by FireStormX Studios**

*Where Chaos Meets Destiny*
