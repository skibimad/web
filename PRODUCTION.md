# Production Deployment Guide

This guide explains how to deploy the Skibidi Madness web application to a production environment.

## Prerequisites

- PHP 7.4 or higher
- MySQL/MariaDB database
- Web server (Apache/Nginx)
- Composer installed

## Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/skibimad/web.git
cd web
```

### 2. Install Dependencies

```bash
composer install --no-dev --optimize-autoloader
```

The `--no-dev` flag ensures development dependencies are not installed in production.

### 3. Configure Environment Variables

Set the following environment variables in your web server configuration:

#### For Apache (.htaccess or VirtualHost):
```apache
SetEnv APP_DEBUG "false"
SetEnv DB_HOST "localhost"
SetEnv DB_PORT "3306"
SetEnv DB_USER "your_db_user"
SetEnv DB_PASSWORD "your_secure_password"
SetEnv DB_NAME "skibidi_madness"
```

#### For Nginx (in your site configuration):
```nginx
location ~ \.php$ {
    fastcgi_param APP_DEBUG "false";
    fastcgi_param DB_HOST "localhost";
    fastcgi_param DB_PORT "3306";
    fastcgi_param DB_USER "your_db_user";
    fastcgi_param DB_PASSWORD "your_secure_password";
    fastcgi_param DB_NAME "skibidi_madness";
    # ... other fastcgi_params
}
```

#### Alternative: Using System Environment Variables

You can also set these in your system environment (e.g., in `/etc/environment` or shell profile):

```bash
export APP_DEBUG=false
export DB_HOST=localhost
export DB_PORT=3306
export DB_USER=your_db_user
export DB_PASSWORD=your_secure_password
export DB_NAME=skibidi_madness
```

### 4. Configure Local Overrides (Optional)

If you prefer not to use environment variables, you can create a local configuration file:

```bash
cp etc/config.php.example etc/config.php.local.php
```

Then edit `etc/config.php.local.php` with your production settings. This file is ignored by git and will override the default configuration.

### 5. Set Directory Permissions

```bash
# Make upload directories writable
chmod 755 public/uploads
chmod 755 public/attachments

# Ensure proper ownership (replace www-data with your web server user)
chown -R www-data:www-data public/uploads
chown -R www-data:www-data public/attachments
```

### 6. Configure Database

Run the database migrations:

```bash
php bin/cli migrate
```

Or import the SQL schema directly into your database.

### 7. Configure Web Server

#### Apache

Ensure the `.htaccess` file in the `public` directory is being read. Your VirtualHost should point to the `public` directory:

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /path/to/web/public
    
    <Directory /path/to/web/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    # Set environment variables
    SetEnv APP_DEBUG "false"
    SetEnv DB_HOST "localhost"
    SetEnv DB_USER "your_db_user"
    SetEnv DB_PASSWORD "your_secure_password"
    SetEnv DB_NAME "skibidi_madness"
</VirtualHost>
```

#### Nginx

Configure your site to route all requests through `index.php`:

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/web/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        
        # Environment variables
        fastcgi_param APP_DEBUG "false";
        fastcgi_param DB_HOST "localhost";
        fastcgi_param DB_USER "your_db_user";
        fastcgi_param DB_PASSWORD "your_secure_password";
        fastcgi_param DB_NAME "skibidi_madness";
        
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Security Checklist

- [ ] **Debug mode disabled**: Ensure `APP_DEBUG=false`
- [ ] **Error display off**: Production should not display errors to users
- [ ] **Database credentials secure**: Use strong passwords and never commit them to git
- [ ] **HTTPS enabled**: Always use SSL/TLS certificates in production
- [ ] **Security headers enabled**: The SecurityHeadersMiddleware is included in global middleware
- [ ] **File permissions**: Upload directories should be writable but not executable
- [ ] **Regular updates**: Keep PHP, dependencies, and server software up to date

## Configuration Options

### Debug Mode

- **Development**: `APP_DEBUG=true` - Enables detailed error messages and debug information
- **Production**: `APP_DEBUG=false` - Disables error display, errors are logged instead

### Database Configuration

All database settings can be configured via environment variables:
- `DB_HOST`: Database server hostname (default: localhost)
- `DB_PORT`: Database server port (default: 3306)
- `DB_USER`: Database username
- `DB_PASSWORD`: Database password
- `DB_NAME`: Database name

### Middleware Configuration

The application includes several middleware components enabled in production:

1. **SecurityHeadersMiddleware** (Global): Adds security headers to all responses
2. **AuthMiddleware** (Admin routes): Protects admin area
3. Additional middleware can be configured in `etc/config.php`

See [QUICK_START.md](QUICK_START.md) for middleware configuration details.

## Monitoring and Logs

### Error Logging

When `APP_DEBUG=false`, errors are logged instead of displayed. Configure PHP error logging:

```ini
; In php.ini or .user.ini
log_errors = On
error_log = /var/log/php/error.log
```

### Access Logs

Monitor web server access logs:
- Apache: `/var/log/apache2/access.log`
- Nginx: `/var/log/nginx/access.log`

## Performance Optimization

### Composer Autoloader

The application is configured with optimized autoloading:

```json
"config": {
    "optimize-autoloader": true,
    "sort-packages": true
}
```

### PHP OpCache

Enable PHP OpCache for better performance:

```ini
; In php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
opcache.fast_shutdown=1
```

## Troubleshooting

### Issue: 500 Internal Server Error

1. Check PHP error logs
2. Verify file permissions
3. Ensure all environment variables are set correctly
4. Check database connection

### Issue: Database Connection Failed

1. Verify database credentials in environment variables
2. Check database server is running
3. Ensure database user has proper permissions
4. Test connection manually: `mysql -h $DB_HOST -u $DB_USER -p $DB_NAME` (password will be prompted)

### Issue: Upload/File Permissions Error

1. Check directory ownership: `ls -la public/uploads`
2. Set proper permissions: `chmod 755 public/uploads`
3. Change owner if needed: `chown www-data:www-data public/uploads`

## Backup and Maintenance

### Database Backups

Regular database backups are essential:

```bash
# Daily backup example (password will be prompted)
mysqldump -u $DB_USER -p $DB_NAME > backup-$(date +%Y%m%d).sql

# Or use a more secure method with a config file
# Create ~/.my.cnf with:
# [client]
# user=your_user
# password=your_password
# Then run:
mysqldump $DB_NAME > backup-$(date +%Y%m%d).sql
```

### Update Procedure

1. Backup database and files
2. Pull latest code: `git pull`
3. Update dependencies: `composer install --no-dev --optimize-autoloader`
4. Run migrations if any: `php bin/cli migrate`
5. Clear any caches if applicable
6. Test the application

## Support

For issues or questions:
- Review the [QUICK_START.md](QUICK_START.md) guide
- Check the [MIDDLEWARE.md](MIDDLEWARE.md) documentation
- Review application logs

## Additional Resources

- [Middleware System Guide](MIDDLEWARE.md)
- [Middleware Examples](MIDDLEWARE_EXAMPLES.md)
- [Architecture Overview](ARCHITECTURE.md)
