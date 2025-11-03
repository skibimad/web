# 🎬 Skibidi Madness - PHP MVC Application

![Skibidi Madness](res/img/all-together.png)

## 🌟 Overview

**Skibidi Madness** is now a full-featured PHP/MySQL MVC application following **SOLID**, **DRY**, and **KISS** principles. This refactoring transforms the static website into a dynamic, database-driven content management system.

## 🏗️ Architecture

### MVC Pattern
- **Models**: Active Record pattern with Collections
- **Views**: PHTML template system
- **Controllers**: Dynamic routing based on URL structure

### Key Features
- ✅ PHP 8.2+ with modern features
- ✅ Composer PSR-4 autoloading
- ✅ Dynamic routing (URL to Controller mapping)
- ✅ Active Record models
- ✅ Collection class for model aggregates
- ✅ MySQL database with prepared statements
- ✅ PHTML view templates
- ✅ Admin panel for content management

## 📋 Requirements

- PHP >= 8.2
- MySQL >= 5.7 or MariaDB >= 10.2
- Apache with mod_rewrite enabled
- Composer

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/skibimad/web.git
cd web
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Database

Create a `.env` file or update `config/database.php`:

```bash
# Option 1: Using environment variables
export DB_HOST=localhost
export DB_NAME=skibidi_madness
export DB_USER=root
export DB_PASS=your_password

# Option 2: Edit config/database.php directly
```

### 4. Setup Database

```bash
# Create database and import schema
mysql -u root -p < database/schema.sql

# Or manually:
mysql -u root -p
> CREATE DATABASE skibidi_madness CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
> USE skibidi_madness;
> source database/schema.sql;
```

### 5. Configure Apache

Enable mod_rewrite:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Ensure `.htaccess` is processed (check your vhost configuration):
```apache
<Directory /path/to/web>
    AllowOverride All
</Directory>
```

### 6. Set Permissions

```bash
# Make sure Apache can read the files
chmod -R 755 /path/to/web
chown -R www-data:www-data /path/to/web  # On Ubuntu/Debian
```

## 🎯 Dynamic Routing

The application uses dynamic URL-to-Controller mapping:

| URL | Controller |
|-----|------------|
| `/` | `App\Controllers\HomeController::handle()` |
| `/blog` | `App\Controllers\BlogController::handle()` |
| `/admin` | `App\Admin\AdminController::handle()` |
| `/admin/heroes/heroes` | `App\Admin\Heroes\HeroesController::handle()` |
| `/admin/heroes/edit?id=1` | `App\Admin\Heroes\EditController::handle()` |
| `/admin/blog/edit?id=2` | `App\Admin\Blog\EditController::handle()` |
| `/foo/bar/baz/acme` | `App\Foo\Bar\Baz\AcmeController::handle()` |

### Routing Rules

1. Last URL segment becomes the Controller name (with `Controller` suffix)
2. Previous segments become the namespace
3. All controllers must extend `App\Core\Controller`
4. All controllers must implement a `handle(Request $request)` method

## 📁 Project Structure

```
web/
├── app/
│   ├── Admin/                  # Admin controllers
│   │   ├── AdminController.php
│   │   ├── Blog/
│   │   │   ├── BlogController.php
│   │   │   └── EditController.php
│   │   ├── Heroes/
│   │   │   ├── HeroesController.php
│   │   │   └── EditController.php
│   │   └── Episodes/
│   │       └── EpisodesController.php
│   ├── Controllers/            # Front-end controllers
│   │   ├── HomeController.php
│   │   └── BlogController.php
│   ├── Core/                   # Core MVC classes
│   │   ├── Collection.php      # Collection for models
│   │   ├── Controller.php      # Base controller
│   │   ├── Database.php        # Database singleton
│   │   ├── Model.php           # Active Record base
│   │   ├── Request.php         # HTTP request handler
│   │   └── Router.php          # Dynamic router
│   ├── Models/                 # Data models
│   │   ├── BlogPost.php
│   │   ├── Episode.php
│   │   └── Hero.php
│   └── Views/                  # PHTML templates
│       ├── admin/
│       │   ├── blog/
│       │   ├── heroes/
│       │   └── episodes/
│       ├── layouts/
│       │   ├── main.phtml
│       │   └── admin.phtml
│       ├── home.phtml
│       └── blog.phtml
├── config/
│   └── database.php            # Database configuration
├── database/
│   └── schema.sql              # Database schema
├── res/                        # Static resources
│   ├── img/
│   └── video/
├── styles/                     # CSS files
│   ├── main.css
│   └── admin.css
├── scripts/                    # JavaScript files
│   └── main.js
├── .htaccess                   # Apache rewrite rules
├── composer.json               # Composer configuration
└── index.php                   # Front controller
```

## 🎨 Design Principles

### SOLID
- **Single Responsibility**: Each class has one clear purpose
- **Open/Closed**: Extend functionality without modifying core
- **Liskov Substitution**: Models and controllers are substitutable
- **Interface Segregation**: Small, focused interfaces
- **Dependency Inversion**: Depend on abstractions, not implementations

### DRY (Don't Repeat Yourself)
- Shared layout templates
- Reusable base classes (Model, Controller, Collection)
- Common database operations in base Model

### KISS (Keep It Simple, Stupid)
- Clean, readable code
- Simple routing mechanism
- Straightforward Active Record pattern
- No unnecessary abstractions

## 🗄️ Database Models

### Active Record Pattern

Models extend `App\Core\Model` and provide Active Record functionality:

```php
// Find by ID
$hero = Hero::find(1);

// Find all
$heroes = Hero::all();

// Find by condition
$publishedPosts = BlogPost::where('published', 1);

// Create and save
$hero = new Hero();
$hero->name = 'New Hero';
$hero->slug = 'new-hero';
$hero->save();

// Update
$hero->name = 'Updated Name';
$hero->save();

// Delete
$hero->delete();
```

### Collections

Collections are iterable, countable, and array-accessible:

```php
$heroes = Hero::all();
count($heroes);                    // Count items
$heroes->first();                  // Get first item
$heroes->filter(fn($h) => ...);    // Filter collection
$heroes->map(fn($h) => ...);       // Map collection
foreach ($heroes as $hero) { }     // Iterate
```

## 🔧 Creating New Features

### Adding a New Controller

```php
<?php
namespace App\Custom\Path;

use App\Core\Controller;
use App\Core\Request;

class MyController extends Controller
{
    public function handle(Request $request): void
    {
        // Your logic here
        $this->view('my-view', ['data' => 'value']);
    }
}
```

Access at: `/custom/path/my`

### Adding a New Model

```php
<?php
namespace App\Models;

use App\Core\Model;

class MyModel extends Model
{
    protected $table = 'my_table';
    
    // Add custom methods
}
```

## 🎭 View Templates

Views use PHTML (PHP HTML) templates:

```php
<?php ob_start(); ?>

<h1><?= htmlspecialchars($title) ?></h1>

<?php foreach ($items as $item): ?>
    <div><?= htmlspecialchars($item->name) ?></div>
<?php endforeach; ?>

<?php 
$content = ob_get_clean();
require __DIR__ . '/layouts/main.phtml';
?>
```

## 🔒 Security

- Prepared statements for all database queries
- HTML escaping in views (`htmlspecialchars`)
- PDO with exception mode enabled
- Input validation in controllers

## 📊 Admin Panel

Access the admin panel at `/admin`:

- **Dashboard**: Overview of content counts
- **Heroes**: Manage hero characters
- **Episodes**: View episode list
- **Blog**: Create and edit blog posts

## 🌐 Deployment

### Production Checklist

1. Disable error display in production:
```php
// In index.php
error_reporting(0);
ini_set('display_errors', 0);
```

2. Set proper file permissions:
```bash
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
```

3. Configure database credentials securely
4. Enable HTTPS
5. Configure proper Apache security headers

## 📝 License

See [LICENSE](LICENSE) file for details.

## 🎬 Credits

**Made with ❤️ by FireStormX Studios**

## ⚠️ Disclaimer

**Skibidi Madness** is a fan-created series inspired by the Skibidi Toilet universe. This project is not officially affiliated with the original creators.
