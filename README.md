# Skibidi Madness - PHP/MySQL MVC Website

Complete PHP 8.2+ MVC application with admin CMS, authentication, analytics, and file uploads.

## Features

### Core Framework
- ✅ MVC architecture following SOLID, DRY, KISS principles
- ✅ PSR-4 autoloading with Composer
- ✅ Dynamic routing with URL rewriting
- ✅ Active Record pattern for models
- ✅ Collection classes (Iterable, Countable, ArrayAccess)
- ✅ PHTML view templates

### Database & Migrations
- ✅ MySQL database support
- ✅ Automated migration system with version control
- ✅ Easy setup with install script

### Authentication & Security
- ✅ Session-based authentication
- ✅ Bcrypt password hashing
- ✅ Protected admin routes
- ✅ CSRF protection ready
- ✅ SQL injection prevention (PDO prepared statements)

### Admin CMS
- ✅ **Heroes Management** - Add, edit, delete, enable/disable heroes
- ✅ **Episodes Management** - Add, edit, delete, enable/disable episodes
- ✅ **Blog Management** - Add, edit, delete, archive posts
- ✅ **Landing Page Editor** - Edit hero, about, and channel sections
- ✅ **YouTube Channel Settings** - Manage channel info site-wide
- ✅ **Social Links Manager** - Manage footer social media links
- ✅ **Analytics Dashboard** - YouTube clicks and visitor stats (day/week/month/year)

### File Upload System
- ✅ Modern drag-and-drop uploader
- ✅ Image preview functionality
- ✅ File validation (type, size)
- ✅ Supports JPEG, PNG, GIF, WEBP, MP4, WEBM
- ✅ Organized storage by category

### Error Handling
- ✅ Custom 404/500 pages
- ✅ Random background videos from res/video/fun/
- ✅ Themed error messages

## Requirements

- **PHP**: >= 8.2
- **MySQL**: >= 5.7 or MariaDB >= 10.2
- **Composer**: Latest version
- **Apache/Nginx**: With mod_rewrite enabled

## Installation

### Quick Install (Recommended)

Run the automated installation script:

```bash
chmod +x install.sh
./install.sh
```

The script will:
1. Check PHP and Composer installation
2. Prompt for MySQL credentials
3. Test database connection
4. Create .env file with your settings
5. Install Composer dependencies
6. Create database and run migrations
7. Set up directory permissions

### Manual Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/skibimad/web.git
   cd web
   ```

2. **Configure environment**
   ```bash
   cp .env.example .env
   ```
   
   Edit `.env` with your database credentials:
   ```env
   DB_DRIVER=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_NAME=skibidi_madness
   DB_USER=root
   DB_PASS=your_password
   ```
   
   **Note:** Use `127.0.0.1` instead of `localhost` to avoid socket connection issues.

3. **Install dependencies**
   ```bash
   composer install
   ```

4. **Create database**
   ```bash
   mysql -u root -p
   CREATE DATABASE skibidi_madness CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   EXIT;
   ```

5. **Run migrations**
   ```bash
   php migrate.php
   ```

6. **Create upload directories**
   ```bash
   mkdir -p uploads/{heroes,blog,episodes,landing}
   mkdir -p res/video/fun
   chmod -R 755 uploads res/video/fun
   ```

7. **Start development server**
   ```bash
   php -S localhost:8000 -t .
   ```

## Usage

### Access the Website

- **Frontend**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin

### Admin Credentials

- **User 1**: Username: `admin` / Password: `admin123`
- **User 2**: Username: `fsx` / Password: `111111`

### Admin Features

#### Dashboard (`/admin`)
- View analytics (YouTube clicks, visitor count)
- Quick access to Heroes, Episodes, and Blog management
- Statistics by day, week, month, year

#### Heroes Management (`/admin/heroes/heroes`)
- View all heroes with status badges
- Add new heroes with image and video uploads
- Edit hero details (name, description, abilities)
- Delete heroes
- Enable/disable heroes

#### Episodes Management (`/admin/episodes/episodes`)
- View all episodes
- Add new episodes
- Delete episodes
- Enable/disable episodes

#### Blog Management (`/admin/blog/blog`)
- View all blog posts with status
- Add new posts with featured image
- Edit existing posts
- Delete posts
- Archive/unarchive posts

#### Landing Page Editor (`/admin/landing/landing`)
- Edit Hero section (title, subtitle, description)
- Edit About section (title, subtitle)
- Edit Channel section (title, description)

#### YouTube Channel (`/admin/youtube/channel`)
- Edit channel name, URL, handle
- Update description
- Set subscriber and video counts
- Used site-wide

#### Social Links (`/admin/social/links`)
- Manage social media links
- Set platform, URL, icon
- Control display order
- Enable/disable links
- Appears in footer automatically

## Project Structure

```
web/
├── app/
│   ├── Admin/              # Admin controllers
│   │   ├── Blog/          # Blog CRUD
│   │   ├── Episodes/      # Episodes CRUD
│   │   ├── Heroes/        # Heroes CRUD
│   │   ├── Landing/       # Landing page editor
│   │   ├── Social/        # Social links manager
│   │   └── Youtube/       # YouTube channel settings
│   ├── Api/               # API endpoints
│   ├── Controllers/       # Frontend controllers
│   ├── Core/              # Framework core
│   │   ├── Auth.php       # Authentication
│   │   ├── Collection.php # Collections
│   │   ├── Controller.php # Base controller
│   │   ├── Database.php   # Database singleton
│   │   ├── ErrorHandler.php # Error handling
│   │   ├── FileUploader.php # File uploads
│   │   ├── Migration.php  # Migration system
│   │   ├── Model.php      # Active Record base
│   │   ├── Request.php    # HTTP requests
│   │   └── Router.php     # Dynamic routing
│   ├── Models/            # Data models
│   └── Views/             # PHTML templates
├── config/                # Configuration files
├── database/
│   ├── migrations/        # Migration files
│   └── schema.sql         # MySQL schema
├── public/                # Static assets (images, CSS, JS)
├── res/                   # Resources (images, videos)
├── scripts/               # JavaScript files
├── styles/                # CSS files
├── uploads/               # Uploaded files (gitignored)
├── .htaccess              # URL rewriting
├── index.php              # Front controller
├── migrate.php            # Migration runner
├── install.sh             # Installation script
└── composer.json          # Dependencies
```

## Database Schema

### Core Tables
- `heroes` - Hero characters with abilities
- `episodes` - Episode information
- `blog_posts` - Blog content
- `landing_page_content` - Landing page sections
- `youtube_channel` - YouTube channel settings
- `social_links` - Social media links

### System Tables
- `admin_users` - Admin authentication
- `youtube_clicks` - Click tracking
- `visitors` - Visitor tracking
- `migrations` - Migration history

## Troubleshooting

### Database Connection Error: "No such file or directory"

This error typically occurs when PHP tries to connect to MySQL via a Unix socket instead of TCP/IP.

**Solution:**
- Use `127.0.0.1` instead of `localhost` for DB_HOST in your `.env` file
- The install script now defaults to `127.0.0.1`
- If you need to use `localhost`, specify the socket path:
  ```env
  DB_HOST=localhost:/var/run/mysqld/mysqld.sock
  ```

**Alternative Solutions:**
1. **Check MySQL is running:**
   ```bash
   sudo service mysql status
   # or
   sudo systemctl status mysql
   ```

2. **Find your MySQL socket:**
   ```bash
   mysql_config --socket
   # or check MySQL config
   grep socket /etc/my.cnf
   ```

3. **Test connection manually:**
   ```bash
   mysql -h 127.0.0.1 -P 3306 -u root -p
   ```

### Static $table Property Error

If you see "Cannot redeclare non static" error:
- This has been fixed in the latest version
- Make sure all model classes use `protected static $table`

### Database Connection Failed (Other Reasons)

- Check MySQL is running: `sudo service mysql status`
- Verify credentials in `.env` file
- Ensure database exists: `mysql -u root -p -e "SHOW DATABASES;"`
- Check port is correct (usually 3306)
- Verify user has proper permissions

### Permission Denied on Uploads

```bash
chmod -R 755 uploads
chmod -R 755 res/video/fun
```

### 404 on All Pages

- Check `.htaccess` exists
- Enable mod_rewrite: `sudo a2enmod rewrite`
- Restart Apache: `sudo service apache2 restart`

## Production Deployment

1. **Disable debug mode**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Set proper permissions**
   ```bash
   chmod -R 755 .
   chmod -R 775 uploads
   chmod 644 .env
   ```

3. **Run Composer for production**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

4. **Backup database regularly**
   ```bash
   mysqldump -u user -p skibidi_madness > backup.sql
   ```

## License

All rights reserved - Fire Storm X Studios

## Support

For issues or questions:
- GitHub Issues: https://github.com/skibimad/web/issues
- YouTube: [@FireStormX-Tri](https://www.youtube.com/@FireStormX-Tri)

---

**Made with ❤️ following SOLID, DRY, and KISS principles**
