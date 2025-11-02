# Migration to SQLite Backend - Implementation Plan

## Overview
Converting from localStorage-based static site to full-stack application with SQLite backend.

## Completed (Step 1)
- [x] Created Node.js/Express server (`server.js`)
- [x] Created SQLite database initialization (`init-db.js`)
- [x] Created package.json with dependencies
- [x] Implemented authentication system (fsx/111111)
- [x] Created API endpoints for heroes, episodes, blog, static content
- [x] Implemented file upload functionality
- [x] Created login page (`login.html`)
- [x] Updated .gitignore

## Remaining Steps

### Step 2: Remove Multi-Language Support
- [ ] Remove language selector from index.html
- [ ] Remove translations.js
- [ ] Keep only English text in HTML
- [ ] Update navigation (remove language switching)

### Step 3: Reorder Sections
- [ ] Move Episodes section before Heroes section in index.html
- [ ] Update navigation order
- [ ] Update internal links

### Step 4: Simplify "Inspired By" Section
- [ ] Keep only DaFuq!?Boom! (Original Creator) link
- [ ] Remove DOM Studio, Virlance, Maxedy references
- [ ] Simplify section design

### Step 5: Create Static Content Editor
- [ ] Create admin-content.html page
- [ ] Add forms for editing:
  - Hero section (title, subtitle, description, video)
  - About section (title, paragraphs, image)
  - Other landing page texts
- [ ] Implement save functionality using /api/content endpoints

### Step 6: Update Admin Pages
- [ ] Update admin.html to check authentication
- [ ] Update admin-heroes.html to use API endpoints
- [ ] Update admin-episodes.html to use API endpoints
- [ ] Update admin-blog.html to use API endpoints
- [ ] Add file upload UI to all admin pages
- [ ] Add "Change Password" functionality

### Step 7: Update Front-End
- [ ] Update index.html to fetch data from API
- [ ] Update blog.html to fetch from API
- [ ] Remove localStorage dependencies
- [ ] Implement dynamic content loading

### Step 8: Documentation
- [ ] Update README.md with:
  - Installation instructions
  - npm install steps
  - Database initialization
  - Starting the server
  - Admin credentials
- [ ] Add deployment guide

## Technical Details

### Database Schema
```sql
- users (id, username, password, created_at)
- heroes (id, name, slug, description, image, video, abilities, display_order, created_at)
- episodes (id, episode_number, title, description, thumbnail, video_url, duration, release_date, created_at)
- blog_posts (id, title, slug, image, excerpt, content, author, date, published, created_at)
- static_content (key, value, updated_at)
```

### API Endpoints
```
POST /api/login
POST /api/logout
GET  /api/auth/check
POST /api/change-password

GET    /api/heroes
POST   /api/heroes
PUT    /api/heroes/:id
DELETE /api/heroes/:id

GET    /api/episodes
POST   /api/episodes
PUT    /api/episodes/:id
DELETE /api/episodes/:id

GET    /api/blog
GET    /api/blog/all (auth required)
POST   /api/blog
PUT    /api/blog/:id
DELETE /api/blog/:id

GET /api/content
PUT /api/content/:key

POST /api/upload (file upload)
```

### Running the Application
```bash
# Install dependencies
npm install

# Initialize database with demo data
npm run init-db

# Start server
npm start

# Development mode (with auto-restart)
npm run dev
```

### Default Credentials
- Username: fsx
- Password: 111111

## Notes
- All file uploads go to /uploads/ directory
- Images/videos can be uploaded through admin interface
- Database file: database.sqlite (excluded from git)
- Session timeout: 24 hours
