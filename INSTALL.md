# Installation Guide - Skibidi Madness

This guide will help you set up the Skibidi Madness website with PHP/MySQL backend.

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 7.4 or higher** with the following extensions:
  - PDO
  - pdo_mysql
  - mbstring
  - json
- **MySQL 5.7+ or MariaDB 10.3+**
- **Apache 2.4+** with mod_rewrite enabled
- **Composer** (for dependency management)

## Step-by-Step Installation

### 1. Clone the Repository

```bash
git clone https://github.com/skibimad/web.git
cd web
```

### 2. Install Dependencies

Run Composer to install PHP dependencies (currently just for autoloading):

```bash
composer install
```

This will create the `vendor` directory with the autoloader.

### 3. Set Up the Database

#### Option A: Using the Setup Script (Recommended)

Run the automated setup script:

```bash
chmod +x setup.sh
./setup.sh
```

The script will:
- Check for required tools
- Install Composer dependencies
- Create the MySQL database
- Create tables from schema.sql
- Seed the database with initial data
- Set up permissions
- Create a .env file

#### Option B: Manual Setup

1. **Create the database:**

```bash
mysql -u root -p
```

```sql
CREATE DATABASE skibidi_madness CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;
```

2. **Import the schema:**

```bash
mysql -u root -p skibidi_madness < database/schema.sql
```

3. **Seed initial data:**

```bash
mysql -u root -p skibidi_madness < database/seed.sql
```

4. **Create .env file** (optional):

```bash
cat > .env << EOF
DB_HOST=localhost
DB_NAME=skibidi_madness
DB_USER=root
DB_PASS=your_password
APP_URL=http://localhost:8000
EOF
```

### 4. Configure Database Connection

If you didn't use the .env file, edit the database configuration:

```bash
nano config/database.php
```

Update the credentials:

```php
return [
    'host' => 'localhost',      // Your MySQL host
    'database' => 'skibidi_madness',  // Database name
    'username' => 'root',        // Your MySQL username
    'password' => 'yourpassword', // Your MySQL password
    // ... rest of config
];
```

### 5. Set Up Apache

#### Option A: Using PHP Built-in Server (Development)

For development/testing, you can use PHP's built-in server:

```bash
cd public
php -S localhost:8000
```

Then visit: http://localhost:8000

#### Option B: Apache Virtual Host (Production)

1. **Create a virtual host configuration:**

```bash
sudo nano /etc/apache2/sites-available/skibidi-madness.conf
```

2. **Add the following configuration:**

```apache
<VirtualHost *:80>
    ServerName skibidi-madness.local
    ServerAlias www.skibidi-madness.local
    
    DocumentRoot /path/to/web/public
    
    <Directory /path/to/web/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/skibidi-error.log
    CustomLog ${APACHE_LOG_DIR}/skibidi-access.log combined
</VirtualHost>
```

Replace `/path/to/web` with the actual path to your project.

3. **Enable the site and mod_rewrite:**

```bash
sudo a2enmod rewrite
sudo a2ensite skibidi-madness.conf
sudo systemctl restart apache2
```

4. **Add to hosts file (for local development):**

```bash
sudo nano /etc/hosts
```

Add:
```
127.0.0.1    skibidi-madness.local
```

### 6. Set Permissions

Ensure the uploads directory is writable:

```bash
chmod -R 755 uploads/
chmod -R 755 public/
```

### 7. Verify Installation

1. **Access the website:**
   - Homepage: `http://localhost:8000` or `http://skibidi-madness.local`

2. **Access admin panel:**
   - Admin: `http://localhost:8000/admin`
   - Default credentials:
     - Username: `fsx`
     - Password: `111111`

## Default Admin Account

The setup creates one admin account:

- **Username:** fsx
- **Password:** 111111 (hashed using bcrypt)

⚠️ **Important:** Change the default password immediately after first login!

## Directory Structure

```
web/
├── app/                  # Application code
│   ├── Controllers/     # MVC Controllers
│   ├── Models/          # Database Models
│   ├── Views/           # PHTML Templates
│   ├── Core/            # Framework Core
│   ├── Middleware/      # Middleware
│   └── Helpers/         # Helper Functions
├── config/              # Configuration
├── database/            # SQL Files
├── public/              # Web Root (DocumentRoot)
│   ├── index.php       # Entry Point
│   ├── .htaccess       # Rewrite Rules
│   ├── res/            # Images/Videos
│   ├── styles/         # CSS
│   └── scripts/        # JavaScript
├── uploads/             # Uploaded Files
└── vendor/              # Composer Dependencies
```

## Database Tables

The application creates the following tables:

- `admin_users` - Admin authentication
- `heroes` - Hero characters
- `episodes` - Video episodes
- `blog_posts` - Blog articles
- `landing_content` - Dynamic landing page content

## Initial Data

The database is seeded with:

1. **Admin User**
   - Username: fsx
   - Password: 111111 (bcrypt hashed)

2. **5 Heroes**
   - Titan Cameraman
   - Titan Speakerman
   - Titan TV Man
   - G-Man
   - Star Storage

3. **5 Episodes**
   - Episode 1: The Awakening
   - Episode 2: Multiverse Mayhem
   - Episode 3: The Supreme Leader Revealed
   - Episode 4: Sonic Showdown
   - Episode 5: Stellar Convergence

4. **Landing Page Content**
   - Hero section content
   - About section content
   - Channel section content

## Troubleshooting

### Database Connection Issues

**Error:** "Database connection failed"

**Solution:**
1. Check MySQL is running: `sudo systemctl status mysql`
2. Verify credentials in `config/database.php`
3. Ensure the database exists: `mysql -u root -p -e "SHOW DATABASES;"`

### Permission Issues

**Error:** "Failed to upload file" or "Permission denied"

**Solution:**
```bash
chmod -R 755 uploads/
chown -R www-data:www-data uploads/  # On Ubuntu/Debian
```

### Apache Mod_Rewrite Not Working

**Error:** "404 Not Found" for all routes except index

**Solution:**
1. Enable mod_rewrite:
   ```bash
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```
2. Ensure `AllowOverride All` is set in your Apache config
3. Check `.htaccess` files exist in root and `public/` directories

### White Screen / No Output

**Error:** Blank page with no errors

**Solution:**
1. Enable error reporting in `public/index.php`:
   ```php
   ini_set('display_errors', 1);
   error_reporting(E_ALL);
   ```
2. Check Apache error logs:
   ```bash
   tail -f /var/log/apache2/error.log
   ```

### Composer Not Found

**Error:** "composer: command not found"

**Solution:**
Install Composer:
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

## Admin Panel Features

After logging in, you can:

1. **Manage Heroes**
   - Create, edit, delete heroes
   - Upload hero images and videos
   - Set display order
   - Manage abilities

2. **Manage Episodes**
   - Create, edit, delete episodes
   - Upload thumbnails
   - Set video URLs
   - Configure episode details

3. **Manage Blog**
   - Create, edit, delete blog posts
   - Upload featured images
   - Publish/unpublish posts
   - Set publish dates

4. **Edit Landing Page**
   - Update hero section content
   - Modify about section
   - Change channel information
   - Upload new images/videos

5. **Account Settings**
   - Change admin password
   - View system information

## Security Notes

1. **Change Default Password**
   - Immediately change the default admin password after installation

2. **Database Credentials**
   - Never commit database credentials to version control
   - Use environment variables or .env files (which are git-ignored)

3. **File Uploads**
   - Only allowed file types can be uploaded (images: jpg, png, gif; videos: mp4, webm)
   - Files are stored outside the public directory for security

4. **SQL Injection Protection**
   - All database queries use prepared statements

5. **XSS Protection**
   - All output is escaped using `escape()` function

## Next Steps

After successful installation:

1. **Login to Admin Panel**
   - Go to `/admin`
   - Use credentials: fsx / 111111

2. **Change Password**
   - Navigate to Account Settings
   - Update to a secure password

3. **Customize Content**
   - Edit heroes, episodes, and blog posts
   - Update landing page content
   - Upload your own images and videos

4. **Configure YouTube Channel**
   - Update channel URL in `config/app.php` if needed

## Support

For issues or questions:
- Check the troubleshooting section above
- Review the SETUP_README.md for detailed documentation
- Check Apache/PHP error logs for specific errors

## Production Deployment

For production deployment:

1. Set `APP_URL` in config to your domain
2. Use a strong MySQL password
3. Enable HTTPS
4. Set proper file permissions (755 for directories, 644 for files)
5. Disable PHP error display
6. Set up regular database backups
7. Configure Apache with proper security headers

---

**Congratulations!** Your Skibidi Madness website is now ready to use.
