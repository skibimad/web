# Skibidi Madness - MVC Architecture Documentation

## 🏗️ Architecture Overview

This project follows a clean MVC (Model-View-Controller) architecture with SOLID principles, implementing a custom PHP framework for maximum flexibility and minimal dependencies.

### Key Features

✅ **Single Entry Points**: All requests go through `public/index.php`  
✅ **SEO-Friendly URLs**: Clean URLs via `.htaccess` (e.g., `/blog`, `/admin/heroes`)  
✅ **Separated Concerns**: PHP logic and HTML templates are completely separated  
✅ **SOLID Principles**: Single Responsibility, Dependency Inversion, etc.  
✅ **DRY Code**: No repeated includes or duplicate logic  
✅ **Security First**: CSRF protection, input sanitization, bcrypt passwords  

---

## 📁 Directory Structure

```
/
├── public/                     # Document root (web-accessible only)
│   ├── index.php              # Front controller (entry point)
│   ├── .htaccess              # URL rewriting rules
│   ├── assets/                # Static assets
│   │   ├── css/               # Stylesheets
│   │   │   ├── main.css       # Main site styles
│   │   │   └── admin.css      # Admin panel styles
│   │   ├── js/                # JavaScript files
│   │   │   ├── main.js        # Main site scripts
│   │   │   └── blog.js        # Blog scripts
│   │   └── images/            # Images and media
│   │       ├── img/           # Site images
│   │       └── video/         # Site videos
│   ├── uploads/               # User-uploaded files
│   │   └── .gitkeep
│   └── admin/                 # Admin area (optional redirect)
│
├── app/                       # Application code (NOT web-accessible)
│   ├── Controllers/           # Request handlers
│   │   ├── HomeController.php
│   │   ├── BlogController.php
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── HeroController.php
│   │   ├── EpisodeController.php
│   │   ├── BlogAdminController.php
│   │   ├── ContentController.php
│   │   └── UploadController.php
│   ├── Models/                # Data models
│   │   ├── User.php
│   │   ├── Hero.php
│   │   ├── Episode.php
│   │   ├── BlogPost.php
│   │   └── StaticContent.php
│   └── Views/                 # HTML templates (to be created in Phase 2)
│       ├── layouts/
│       ├── home/
│       ├── blog/
│       └── admin/
│
├── core/                      # Framework core (custom MVC)
│   ├── Application.php        # Bootstrap & autoloader
│   ├── Router.php             # URL routing engine
│   ├── Request.php            # HTTP request wrapper
│   ├── Response.php           # HTTP response helper
│   ├── Controller.php         # Base controller
│   ├── Model.php              # Base model
│   ├── View.php               # View renderer
│   ├── Database.php           # SQLite PDO wrapper
│   └── Security.php           # Auth & validation
│
├── config/                    # Configuration files
│   ├── config.php             # Application config
│   └── routes.php             # Route definitions
│
└── database/                  # Database files
    ├── schema.sql             # Database schema
    ├── seed.php               # Data seeder
    └── skibidi_madness.db     # SQLite database (gitignored)
```

---

## 🌐 URL Routing

### Public URLs

| URL | Controller | Action | Description |
|-----|------------|--------|-------------|
| `/` | HomeController | index | Landing page |
| `/blog` | BlogController | index | Blog listing |
| `/blog/{slug}` | BlogController | show | Single blog post |

### Admin URLs

| URL | Controller | Action | Description |
|-----|------------|--------|-------------|
| `/admin/login` | AuthController | showLogin/login | Login page |
| `/admin/logout` | AuthController | logout | Logout |
| `/admin` | DashboardController | index | Dashboard |
| `/admin/heroes` | HeroController | index | List heroes |
| `/admin/heroes/create` | HeroController | create | Add hero form |
| `/admin/heroes/{id}/edit` | HeroController | edit | Edit hero form |
| `/admin/episodes` | EpisodeController | index | List episodes |
| `/admin/blog` | BlogAdminController | index | Manage blog |
| `/admin/content` | ContentController | index | Edit static content |
| `/admin/upload` | UploadController | upload | File upload API |

---

## 🚀 Getting Started

### Prerequisites

- PHP 7.4 or higher
- SQLite3 extension enabled
- Apache with mod_rewrite (or nginx with proper config)

### Installation

1. **Clone the repository:**
   ```bash
   cd /path/to/web/server/root
   git clone <repo-url> skibidi-madness
   ```

2. **Initialize database:**
   ```bash
   cd skibidi-madness
   php database/seed.php
   ```

3. **Configure web server:**

   **Option A: PHP Built-in Server (Development)**
   ```bash
   cd public
   php -S localhost:8000
   ```
   Access at: http://localhost:8000

   **Option B: Apache**
   - Point document root to `public/` folder
   - Ensure mod_rewrite is enabled
   - `.htaccess` file handles URL rewriting

   **Option C: Nginx**
   ```nginx
   server {
       root /path/to/skibidi-madness/public;
       index index.php;
       
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }
       
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
           fastcgi_index index.php;
           include fastcgi_params;
       }
   }
   ```

4. **Login to admin:**
   - URL: http://your-domain/admin/login
   - Username: `fsx`
   - Password: `111111`

---

## 🔐 Security Features

### Authentication
- Bcrypt password hashing (cost: 12)
- Session-based authentication
- 24-hour session timeout
- Automatic logout on inactivity

### Request Security
- CSRF token validation on all forms
- Input sanitization (XSS prevention)
- SQL injection prevention (prepared statements)
- File upload validation (type, size, MIME)

### Middleware
- Authentication middleware on admin routes
- Automatic redirect for unauthenticated users

---

## 🎨 MVC Pattern

### Controllers
- Handle HTTP requests and responses
- No business logic (kept in models)
- Return views or JSON responses
- Example:
  ```php
  class HomeController extends Controller {
      public function index() {
          $heroModel = new Hero();
          $data = ['heroes' => $heroModel->findAll()];
          $this->view('home/index', $data);
      }
  }
  ```

### Models
- Handle data operations (CRUD)
- Interact with database
- No HTML or presentation logic
- Example:
  ```php
  $heroModel = new Hero();
  $heroes = $heroModel->findAll();
  $hero = $heroModel->find(1);
  $heroModel->create(['name' => 'New Hero']);
  ```

### Views
- Pure HTML templates with minimal PHP
- Receive data from controllers
- No database queries
- Use `<?= $this->e($variable) ?>` for safe output

---

## 📝 Adding New Features

### 1. Add a New Route

Edit `config/routes.php`:
```php
$router->get('/new-page', 'NewController@index');
```

### 2. Create Controller

Create `app/Controllers/NewController.php`:
```php
<?php
class NewController extends Controller {
    public function index() {
        $this->view('new/index', ['data' => 'value']);
    }
}
```

### 3. Create View

Create `app/Views/new/index.php`:
```php
<h1>New Page</h1>
<p><?= $this->e($data) ?></p>
```

---

## 🛠️ Development Guidelines

### SOLID Principles

**Single Responsibility:**
- Each class has one reason to change
- Controllers handle requests, Models handle data

**Open/Closed:**
- Extend base classes, don't modify them
- Add new features through inheritance

**Liskov Substitution:**
- All controllers work with base Controller
- All models work with base Model

**Interface Segregation:**
- Clean, focused interfaces
- No unnecessary dependencies

**Dependency Inversion:**
- Depend on abstractions, not concretions
- Controllers don't know about database details

### DRY (Don't Repeat Yourself)

- Autoloading eliminates repeated `require_once`
- Base classes provide common functionality
- Layouts prevent duplicate HTML
- Utilities centralized in core classes

### KISS (Keep It Simple, Stupid)

- Clear, readable code
- Minimal abstraction layers
- Intuitive file organization
- Simple routing configuration

---

## 📊 Database Schema

### Tables

1. **users** - Admin authentication
2. **heroes** - Hero characters
3. **episodes** - Featured episodes
4. **blog_posts** - Blog content
5. **static_content** - Editable page content

See `database/schema.sql` for complete schema.

---

## 🧪 Testing

### Manual Testing

1. **Public Pages:**
   - Visit `/` - Should load landing page
   - Visit `/blog` - Should show blog listing
   - Click hero cards - Should show hover videos

2. **Admin Area:**
   - Visit `/admin` - Should redirect to `/admin/login`
   - Login with fsx/111111
   - Try CRUD operations on heroes, episodes, blog

3. **File Upload:**
   - Edit a hero in admin
   - Click "Upload" button
   - Select image - Should upload and populate path

### URL Testing

Test clean URLs work:
```bash
curl http://localhost:8000/
curl http://localhost:8000/blog
curl http://localhost:8000/admin
```

---

## 📦 Deployment

### Production Checklist

- [ ] Change default admin password
- [ ] Set proper file permissions (755 for directories, 644 for files)
- [ ] Ensure `public/uploads/` is writable
- [ ] Configure proper error reporting (turn off in production)
- [ ] Set up HTTPS
- [ ] Configure database backups
- [ ] Test all routes and functionality

### File Permissions

```bash
chmod 755 public/
chmod 644 public/index.php
chmod 755 public/uploads/
chmod 644 database/skibidi_madness.db
chmod 666 database/skibidi_madness.db  # If web server needs to write
```

---

## 🐛 Troubleshooting

### URLs not working (404 errors)

- **Check mod_rewrite**: `apache2ctl -M | grep rewrite`
- **Verify .htaccess**: Ensure it exists in `public/`
- **Check AllowOverride**: Apache config should have `AllowOverride All`

### Database errors

- **Check SQLite**: `php -m | grep sqlite`
- **Reinitialize**: `rm database/*.db && php database/seed.php`
- **Permissions**: Ensure database file is writable

### File upload not working

- **Check upload directory**: `chmod 755 public/uploads`
- **PHP upload limit**: Check `php.ini` for `upload_max_filesize`
- **Web server user**: Ensure uploads folder owned by web server user

### Autoloading not working

- **Check paths**: Verify `Application.php` autoloader paths
- **Class names**: Ensure class names match file names exactly

---

## 📚 Additional Resources

- **PHP Manual**: https://www.php.net/manual/
- **SQLite Documentation**: https://www.sqlite.org/docs.html
- **SOLID Principles**: https://en.wikipedia.org/wiki/SOLID
- **PSR Standards**: https://www.php-fig.org/psr/

---

## 👥 Credits

- **Original Concept**: DaFuq!?Boom! (Skibidi Toilet)
- **Development**: FireStormX Studios (@FireStormX!?)
- **Architecture**: Custom PHP MVC Framework

---

## 📄 License

See LICENSE file for details.
