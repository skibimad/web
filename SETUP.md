# Skibidi Madness - Setup Guide

## Quick Setup Instructions

### 1. Prerequisites

Ensure you have the following installed:
- Apache Web Server (2.4+)
- PHP (8.1+)
- MySQL (5.7+)

### 2. Installation Steps

#### Step 1: Clone or Download

Download this repository to your web server directory (e.g., `/var/www/html/skibidi-madness`).

#### Step 2: Configure Apache

Copy the provided virtual host configuration:

```bash
sudo cp setup/apache-vhost.conf /etc/apache2/sites-available/skibidi-madness.conf
```

Edit the file to match your directory:

```bash
sudo nano /etc/apache2/sites-available/skibidi-madness.conf
```

Enable the site and required modules:

```bash
sudo a2ensite skibidi-madness
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### Step 3: Run Database Setup

Execute the installation script:

```bash
cd setup
chmod +x install.sh
./install.sh
```

The script will prompt you for:
- MySQL host (default: localhost)
- MySQL username (default: root)
- MySQL password

It will then:
- Create the `skibidi_madness` database
- Set up all tables
- Insert demo data
- Create config.php

#### Step 4: Set Permissions

Make sure the uploads directory is writable:

```bash
chmod -R 755 uploads
sudo chown -R www-data:www-data uploads
```

#### Step 5: Access Your Site

- **Website**: http://localhost/ (or your configured domain)
- **Admin Panel**: http://localhost/admin/

### 3. First Login

Use these credentials to access the admin panel:

```
Username: fsx
Password: 111111
```

**IMPORTANT**: Change this password immediately in Admin → Settings!

### 4. Manual Database Setup (Alternative)

If the install script doesn't work, you can manually set up the database:

```bash
mysql -u root -p
```

Then run the SQL commands from `setup/database.sql`:

```sql
source setup/database.sql;
```

Create `config.php` by copying `config.example.php` and updating the database credentials.

### 5. Troubleshooting

#### Database Connection Error

Check `config.php` and ensure:
- Database credentials are correct
- MySQL service is running
- Database user has proper permissions

#### Upload Directory Not Writable

```bash
sudo chown -R www-data:www-data uploads
chmod -R 755 uploads
```

#### Apache Rewrite Not Working

Enable mod_rewrite:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### Admin Panel Shows 404

Check that `.htaccess` files exist in both root and admin directories.

### 6. Next Steps

After installation:

1. Login to admin panel
2. Change the default password
3. Review and customize the landing page content
4. Add/edit heroes and episodes
5. Create blog posts
6. Upload custom images

## Support

For issues or questions, please check the main README.md file or create an issue on GitHub.
