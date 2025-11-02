# 🎬 Skibidi Madness - PHP/MySQL Implementation

![Skibidi Madness](public/res/img/all-together.png)

## 🌟 Overview

**Skibidi Madness** is an epic multi-universe animation series website with a custom PHP MVC framework, MySQL database backend, and comprehensive admin panel.

### ✨ Key Features

- **Custom MVC Framework**: Built from scratch with SOLID principles
- **PSR-Compatible**: Container, Middleware, HTTP messages
- **MySQL Database**: Full data persistence with seeded initial data
- **Admin Panel**: Complete CRUD operations with authentication
- **Image Upload**: Support for managing media files
- **Landing Page Editor**: Dynamic content management
- **Clean URLs**: Apache .htaccess rewriting
- **Security**: Protected admin area, password hashing, SQL injection prevention

## 🚀 Quick Setup

### Prerequisites

- **PHP 7.4+** (with PDO MySQL extension)
- **MySQL 5.7+** or **MariaDB 10.3+**
- **Apache 2.4+** (with mod_rewrite enabled)
- **Composer** (for autoloading)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/skibimad/web.git
   cd web
   ```

2. **Run the setup script**
   ```bash
   ./setup.sh
   ```
   
   The script will:
   - Install Composer dependencies
   - Create the MySQL database
   - Create tables with schema
   - Seed initial data
   - Set up permissions

3. **Configure your web server**

   **Option A: PHP Built-in Server (Development)**
   ```bash
   cd public
   php -S localhost:8000
   ```
   
   **Option B: Apache (Production)**
   
   Set your DocumentRoot to the `public` directory:
   ```apache
   <VirtualHost *:80>
       ServerName skibidi-madness.local
       DocumentRoot /path/to/web/public
       
       <Directory /path/to/web/public>
           Options Indexes FollowSymLinks
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```

4. **Access the application**
   - Homepage: `http://localhost:8000`
   - Admin Panel: `http://localhost:8000/admin`
   
   **Default Admin Credentials:**
   - Username: `fsx`
   - Password: `111111`

## 📁 Project Structure

```
web/
├── app/
│   ├── Controllers/          # Application controllers
│   │   ├── HomeController.php
│   │   ├── AdminController.php
│   │   ├── AdminHeroController.php
│   │   ├── AdminEpisodeController.php
│   │   └── AdminBlogController.php
│   ├── Models/              # Database models
│   │   ├── Hero.php
│   │   ├── Episode.php
│   │   ├── BlogPost.php
│   │   ├── AdminUser.php
│   │   └── LandingContent.php
│   ├── Views/               # PHTML templates
│   │   ├── layouts/
│   │   ├── home/
│   │   ├── admin/
│   │   └── errors/
│   ├── Core/                # Framework core
│   │   ├── Database.php     # Singleton database connection
│   │   ├── Router.php       # Dynamic routing
│   │   ├── Request.php      # PSR-7 compatible request
│   │   ├── Response.php     # PSR-7 compatible response
│   │   ├── Controller.php   # Base controller
│   │   └── Model.php        # Base model
│   ├── Middleware/          # Middleware classes
│   │   └── AuthMiddleware.php
│   └── Helpers/             # Helper functions
│       ├── FileUpload.php
│       └── functions.php
├── config/                  # Configuration files
│   ├── app.php             # Application config
│   └── database.php        # Database config
├── database/               # Database files
│   ├── schema.sql          # Database schema
│   └── seed.sql            # Seed data
├── public/                 # Web root (DocumentRoot)
│   ├── index.php           # Front controller
│   ├── .htaccess           # URL rewriting rules
│   ├── res/                # Static resources
│   ├── styles/             # CSS files
│   └── scripts/            # JavaScript files
├── uploads/                # Uploaded files
│   ├── heroes/
│   ├── episodes/
│   ├── blog/
│   └── landing/
├── vendor/                 # Composer dependencies
├── .htaccess              # Root htaccess
├── composer.json          # Composer configuration
└── setup.sh               # Installation script
```

## 🏗️ Architecture

### Custom MVC Framework

The application follows a custom MVC (Model-View-Controller) architecture:

#### Core Components

1. **Database (Singleton)**
   - Single PDO instance for the entire application
   - Prepared statements for security
   - Helper methods for CRUD operations

2. **Router (Dynamic)**
   - Pattern-based routing
   - Parameter extraction from URLs
   - Middleware support
   - No manual route configuration needed

3. **Request & Response (PSR-compatible)**
   - Object-oriented HTTP handling
   - Body parsing (JSON, form data)
   - File upload support

4. **Controller (Base Class)**
   - Dependency injection via constructor
   - View rendering methods
   - JSON response helpers
   - Redirect helpers

5. **Model (Active Record Pattern)**
   - Base CRUD operations
   - Database abstraction
   - Custom query methods

### Dependency Injection

The framework uses constructor injection:

```php
class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->db is automatically available
    }
}
```

### Middleware

Middleware can be attached to routes:

```php
$router->get('/admin/heroes', 'AdminHeroController@index', [AuthMiddleware::class]);
```

## 🗄️ Database Schema

### Tables

- **admin_users**: Admin authentication
- **heroes**: Hero characters
- **episodes**: Video episodes
- **blog_posts**: Blog content
- **landing_content**: Dynamic landing page content

### Initial Data

The database is seeded with:
- 1 admin user (fsx/111111)
- 5 heroes (Titan Cameraman, Titan Speakerman, Titan TV Man, G-Man, Star Storage)
- 5 episodes
- Landing page content

## 🔐 Security Features

- **Password Hashing**: bcrypt with cost factor 10
- **SQL Injection Prevention**: Prepared statements only
- **XSS Protection**: Output escaping
- **Authentication**: Session-based admin protection
- **CSRF**: Ready for token implementation
- **File Upload Validation**: Type and size checking

## 🛠️ Admin Panel Features

### Dashboard (`/admin`)
- Overview statistics
- Quick action buttons
- System information

### Heroes Management (`/admin/heroes`)
- List all heroes
- Create new hero
- Edit hero (with image/video upload)
- Delete hero
- Reorder display

### Episodes Management (`/admin/episodes`)
- List all episodes
- Create new episode
- Edit episode (with thumbnail upload)
- Delete episode
- Manage video URLs

### Blog Management (`/admin/blog`)
- List all posts
- Create new post
- Edit post (with image upload)
- Delete post
- Publish/unpublish

### Landing Page Editor (`/admin/landing`)
- Edit hero section
- Edit about section
- Edit channel section
- Upload images and videos

### Settings
- Change password
- Update admin credentials

## 🎨 Frontend

The frontend maintains the original design with:
- Responsive design
- Post-apocalyptic theme
- Hero cards with video previews
- Smooth animations
- SEO optimized

**Notable Changes:**
- ❌ Removed multi-language support (English only)
- ✅ Updated YouTube channel: `@FirestomX-Tri`
- ✅ Reordered: "Featured Episodes" before "Heroes"
- ✅ Simplified "Inspired by" section (DaFuq!?Boom! only)

## 📝 Usage Examples

### Creating a New Hero

```php
$heroModel = new Hero();
$heroModel->create([
    'slug' => 'new-hero',
    'name' => 'New Hero',
    'description' => 'Description here',
    'image' => 'uploads/heroes/image.png',
    'video' => 'uploads/heroes/video.mp4',
    'abilities' => json_encode(['Ability 1', 'Ability 2']),
    'display_order' => 6
]);
```

### Querying Data

```php
// Get all heroes ordered
$heroModel = new Hero();
$heroes = $heroModel->getAllOrdered();

// Find by ID
$hero = $heroModel->find(1);

// Find by slug
$hero = $heroModel->findBySlug('titan-camera');
```

### File Upload

```php
if ($request->hasFile('image')) {
    $upload = FileUpload::upload($_FILES['image'], 'heroes');
    if ($upload['success']) {
        $imagePath = $upload['path'];
    }
}
```

## 🧪 Testing

Manual testing checklist:

- [ ] Home page loads correctly
- [ ] Blog page shows posts
- [ ] Admin login works
- [ ] Admin dashboard displays stats
- [ ] Hero CRUD operations
- [ ] Episode CRUD operations
- [ ] Blog CRUD operations
- [ ] Image upload works
- [ ] Password change works
- [ ] Landing page editor works

## 🔧 Configuration

### Environment Variables

Create a `.env` file (optional, defaults work):

```env
DB_HOST=localhost
DB_NAME=skibidi_madness
DB_USER=root
DB_PASS=yourpassword
APP_URL=http://localhost
```

### Application Config

Edit `config/app.php`:

```php
return [
    'app_name' => 'Skibidi Madness',
    'app_url' => getenv('APP_URL') ?: 'http://localhost',
    'youtube_channel' => 'https://www.youtube.com/@FirestomX-Tri',
    // ... more config
];
```

## 📦 Deployment

### Production Checklist

1. Set up Apache/Nginx with proper DocumentRoot
2. Enable mod_rewrite (Apache)
3. Set proper file permissions (755 for directories, 644 for files)
4. Create .env file with production database credentials
5. Update APP_URL in config
6. Enable HTTPS
7. Set up database backups
8. Configure error logging

### Apache Configuration

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/skibidi-madness/public
    
    <Directory /var/www/skibidi-madness/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/skibidi-error.log
    CustomLog ${APACHE_LOG_DIR}/skibidi-access.log combined
</VirtualHost>
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

See [LICENSE](LICENSE) file for details.

## 🎬 About

**Skibidi Madness** is a fan-created series inspired by the Skibidi Toilet universe. This project is not officially affiliated with the original creators.

### YouTube Channel
[FirestomX-Tri](https://www.youtube.com/@FirestomX-Tri)

### Original Creator
[DaFuq!?Boom!](https://www.youtube.com/@DaFuqBoom)

---

**Made with ❤️ by FireStormX Studios**

*Where Chaos Meets Destiny*
