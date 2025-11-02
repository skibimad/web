# Composer Autoloader Integration

## Overview

The project now uses **Composer's PSR-4 autoloader** instead of a custom autoloading solution. This enables:

- ✅ **Package Management**: Easy installation of external libraries via Composer
- ✅ **PSR-4 Compliance**: Industry-standard autoloading
- ✅ **Performance**: Optimized class loading with classmap generation
- ✅ **Future-Proof**: Ready for package additions and updates

## Installation

### Initial Setup

```bash
# Install Composer (if not already installed)
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install dependencies
composer install --optimize-autoloader
```

### Development

```bash
# Install dependencies
composer install

# Update dependencies
composer update

# Regenerate autoloader after adding new classes
composer dump-autoload --optimize
```

## Project Structure

The autoloader is configured to load classes from these namespaces:

```json
{
    "autoload": {
        "psr-4": {
            "App\\Controllers\\": "app/Controllers/",
            "App\\Models\\": "app/Models/",
            "Core\\": "core/",
            "Config\\": "config/"
        }
    }
}
```

## Class Naming Conventions

### Namespaces

All classes must declare their namespace:

```php
<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;

class AuthController extends Controller {
    // ...
}
```

### Class Locations

| Namespace | Directory | Example |
|-----------|-----------|---------|
| `Core\` | `core/` | `Core\Application` → `core/Application.php` |
| `App\Controllers\` | `app/Controllers/` | `App\Controllers\HomeController` → `app/Controllers/HomeController.php` |
| `App\Models\` | `app/Models/` | `App\Models\User` → `app/Models/User.php` |

## Adding External Packages

### Example: Adding a Package

```bash
# Add a package (e.g., PHPMailer for email)
composer require phpmailer/phpmailer

# Use in your code
use PHPMailer\PHPMailer\PHPMailer;
```

### Popular Packages You Can Add

**Email:**
```bash
composer require phpmailer/phpmailer
```

**Image Processing:**
```bash
composer require intervention/image
```

**PDF Generation:**
```bash
composer require dompdf/dompdf
```

**Date/Time:**
```bash
composer require nesbot/carbon
```

**Validation:**
```bash
composer require respect/validation
```

**Debugging:**
```bash
composer require --dev filp/whoops
```

**Testing:**
```bash
composer require --dev phpunit/phpunit
```

## Migration from Custom Autoloader

### What Changed

**Before (Custom Autoloader):**
```php
// Each file had manual requires
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Model.php';

class HomeController extends Controller {
    // ...
}
```

**After (Composer Autoloader):**
```php
namespace App\Controllers;

use Core\Controller;
use App\Models\Hero;

class HomeController extends Controller {
    // Classes auto-loaded by Composer
}
```

### Benefits

1. **No Manual Requires**: Classes loaded automatically
2. **Namespace Support**: Proper PSR-4 namespacing
3. **Package Management**: Easy third-party library integration
4. **Optimized Loading**: Classmap generation for production
5. **Standard Compliance**: Follows PHP community standards

## Entry Point

The front controller (`public/index.php`) loads Composer's autoloader:

```php
<?php

// Define paths
define('ROOT_PATH', dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);

// Load Composer's autoloader
require_once ROOT_PATH . '/vendor/autoload.php';

// Run application
use Core\Application;

$app = Application::getInstance();
$app->run();
```

## Performance

### Optimized Autoloader

For production, always use optimized autoloader:

```bash
composer dump-autoload --optimize
```

This generates a classmap for faster loading.

### Classmap

All 24 classes are registered in the optimized classmap:

- 9 Controllers
- 5 Models
- 9 Core classes
- 1 Config class

## Troubleshooting

### "Class not found" Error

1. Check namespace declaration in file
2. Verify file location matches namespace
3. Regenerate autoloader:
   ```bash
   composer dump-autoload
   ```

### PSR-4 Compliance

Ensure:
- Class name matches filename
- Namespace matches directory structure
- First character of namespace segments capitalized

### Clearing Cache

```bash
# Remove vendor and regenerate
rm -rf vendor/
composer install --optimize-autoloader
```

## Best Practices

1. **Always use namespaces** in new files
2. **Import classes** with `use` statements
3. **Regenerate autoloader** after adding files
4. **Optimize for production** with `--optimize-autoloader`
5. **Version control**: Commit `composer.json`, ignore `vendor/`

## Future Package Suggestions

Consider adding these packages as the project grows:

- **Logging**: `monolog/monolog`
- **Environment Config**: `vlucas/phpdotenv`
- **HTTP Client**: `guzzlehttp/guzzle`
- **Template Engine**: `twig/twig`
- **Caching**: `symfony/cache`
- **Queue**: `bernard/bernard`
- **Translation**: `symfony/translation`

## Documentation

- [Composer Documentation](https://getcomposer.org/doc/)
- [PSR-4 Specification](https://www.php-fig.org/psr/psr-4/)
- [Packagist (Package Repository)](https://packagist.org/)

## Summary

The project is now using industry-standard Composer autoloading, making it:

✅ **Professional** - Follows PHP community standards  
✅ **Maintainable** - Clean, organized code structure  
✅ **Extensible** - Easy to add third-party packages  
✅ **Performant** - Optimized class loading  
✅ **Future-Proof** - Ready for growth and scaling
