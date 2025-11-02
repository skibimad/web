# Skibidi Madness - PHP/SQLite Backend Setup

## Requirements

- PHP 7.4 or higher
- SQLite3 extension enabled
- Apache/Nginx web server (or PHP built-in server for development)

## Installation

1. **Check PHP and SQLite**:
```bash
php -v
php -m | grep sqlite
```

2. **Initialize Database**:
```bash
cd /path/to/web
php database/seed.php
```

This creates the SQLite database at `database/skibidi_madness.db` and populates it with demo data:
- Admin user: `fsx` / `111111`
- 5 Heroes (Titan Cameraman, Titan Speakerman, Titan TV Man, G-Man, Star Storage)
- 5 Episodes
- Static content for landing page

3. **Start Development Server**:
```bash
php -S localhost:8000
```

4. **Access the Site**:
- Main site: http://localhost:8000
- Admin panel: http://localhost:8000/admin/
- Login: http://localhost:8000/admin/login.php

## Project Structure

```
/
├── config/
│   └── config.php          # Application configuration
├── core/
│   ├── Database.php        # SQLite database wrapper
│   ├── Model.php           # Base model class
│   ├── Controller.php      # Base controller class
│   └── Security.php        # Authentication & security
├── models/
│   ├── User.php            # User model
│   ├── Hero.php            # Hero model
│   ├── Episode.php         # Episode model
│   ├── BlogPost.php        # Blog post model
│   └── StaticContent.php   # Static content model
├── controllers/
│   └── (To be created in Phase 2)
├── views/
│   └── (To be created in Phase 2)
├── database/
│   ├── schema.sql          # Database schema
│   ├── seed.php            # Data seeder
│   └── skibidi_madness.db  # SQLite database (auto-created)
├── uploads/                # User uploads directory
├── admin/                  # Admin panel files
│   └── (To be created in Phase 2)
└── index.php               # Front controller (To be created)
```

## Features

### Backend Infrastructure
- ✅ Custom MVC architecture
- ✅ SQLite database with prepared statements
- ✅ Bcrypt password hashing
- ✅ Session-based authentication
- ✅ CSRF protection
- ✅ Input sanitization (XSS prevention)
- ✅ File upload validation
- ✅ Clean separation of concerns

### Database Tables
- `users` - Admin authentication
- `heroes` - Hero cards with abilities
- `episodes` - Featured episodes
- `blog_posts` - Blog system
- `static_content` - Editable landing page content

### Security Features
- Password hashing with bcrypt (cost: 12)
- Session timeout (24 hours)
- CSRF token validation
- SQL injection prevention (prepared statements)
- XSS prevention (input sanitization)
- File upload validation (type, size)

## Next Steps

Phase 2 will include:
- Front-end PHP pages (index.php, blog.php)
- Admin panel pages (in admin/ folder)
- Controllers for all CRUD operations
- Views/templates
- File upload implementation
- Login page
- Static content editor

## Demo Data

The database comes pre-populated with:
- **Admin User**: fsx / 111111
- **5 Heroes**: Full details with abilities, images, videos
- **5 Episodes**: Complete with descriptions, thumbnails, YouTube links
- **Static Content**: All landing page texts (hero section, about section)

## Troubleshooting

**Permission Issues**:
```bash
chmod 755 database
chmod 644 database/skibidi_madness.db
chmod 755 uploads
```

**Database Errors**:
- Ensure SQLite3 PHP extension is installed
- Check file permissions on database directory
- Verify DB_PATH in config/config.php

**Upload Directory**:
```bash
mkdir -p uploads
chmod 755 uploads
```
