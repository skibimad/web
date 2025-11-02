# 🎬 Skibidi Madness - Official Website

![Skibidi Madness](res/img/all-together.png)

## 🌟 Overview

**Skibidi Madness** is an epic multi-universe animation series created by **FireStormX Studios** that transcends the boundaries of the original Skibidi Toilet universe. This is the official website with a full-featured admin panel for managing content.

## 🚀 Quick Start

### Prerequisites
- Node.js 14+ and npm
- SQLite3

### Installation

```bash
# Clone the repository
git clone https://github.com/skibimad/web.git
cd web

# Install dependencies
npm install

# Initialize the database with demo data
npm run init-db

# Start the server
npm start
```

The server will start on `http://localhost:3000`

### Development Mode

```bash
# Start with auto-restart on file changes
npm run dev
```

## 🔐 Admin Access

**Default Credentials:**
- Username: `fsx`
- Password: `111111`

**Admin Panel:** http://localhost:3000/login.html

After logging in, you can:
- Manage hero cards
- Manage featured episodes
- Write and publish blog posts
- Edit static landing page content
- Upload images and videos
- Change your password

## 📁 Project Structure

```
skibidi-madness-web/
├── server.js              # Express server with API endpoints
├── init-db.js             # Database initialization script
├── package.json           # Dependencies and scripts
├── database.sqlite        # SQLite database (auto-created)
│
├── index.html             # Main landing page
├── blog.html              # Blog listing page
├── login.html             # Admin login page
│
├── admin.html             # Admin dashboard
├── admin-heroes.html      # Heroes management
├── admin-episodes.html    # Episodes management
├── admin-blog.html        # Blog management
│
├── styles/
│   ├── main.css           # Main stylesheet
│   └── admin.css          # Admin panel styles
│
├── scripts/
│   ├── main.js            # Main site JavaScript
│   ├── blog.js            # Blog display logic
│   ├── admin-common.js    # Shared admin functions (DEPRECATED - use API)
│   ├── admin-dashboard.js # Dashboard logic
│   ├── admin-heroes.js    # Heroes CRUD
│   ├── admin-episodes.js  # Episodes CRUD
│   └── admin-blog.js      # Blog CRUD
│
├── res/                   # Static resources
│   ├── img/               # Images
│   │   ├── all-together.png
│   │   └── heroes/promo/  # Hero images
│   └── video/             # Videos
│       ├── all-together.mp4
│       └── heroes/promo/  # Hero videos
│
└── uploads/               # User-uploaded files (auto-created)
```

## 🎨 Features

### Front-End
- ✅ **Responsive Design**: Mobile-first approach, works on all devices
- ✅ **Post-Apocalyptic Theme**: Dark backgrounds with neon accents
- ✅ **Dynamic Content**: All content loaded from SQLite database
- ✅ **Interactive Hero Cards**: Video preview on hover
- ✅ **Blog System**: Full blog with featured images and excerpts
- ✅ **SEO Optimized**: Meta tags and semantic HTML

### Admin Panel
- ✅ **Secure Authentication**: Session-based login with bcrypt
- ✅ **Heroes Management**: Add/edit/delete hero cards
- ✅ **Episodes Management**: Manage featured episodes
- ✅ **Blog Management**: Write and publish blog posts
- ✅ **Static Content Editor**: Edit landing page text and images
- ✅ **File Upload**: Upload images and videos through the interface
- ✅ **Password Management**: Change admin password

## 🗄️ Database Schema

### Users Table
```sql
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

### Heroes Table
```sql
CREATE TABLE heroes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    slug TEXT UNIQUE NOT NULL,
    description TEXT,
    image TEXT,
    video TEXT,
    abilities TEXT,  -- JSON array
    display_order INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

### Episodes Table
```sql
CREATE TABLE episodes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    episode_number INTEGER NOT NULL,
    title TEXT NOT NULL,
    description TEXT,
    thumbnail TEXT,
    video_url TEXT,
    duration TEXT,
    release_date DATE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

### Blog Posts Table
```sql
CREATE TABLE blog_posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    slug TEXT UNIQUE NOT NULL,
    image TEXT,
    excerpt TEXT,
    content TEXT,
    author TEXT DEFAULT 'FireStormX Studios',
    date DATE,
    published INTEGER DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

### Static Content Table
```sql
CREATE TABLE static_content (
    key TEXT PRIMARY KEY,
    value TEXT,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

## 🔌 API Endpoints

### Authentication
- `POST /api/login` - User login
- `POST /api/logout` - User logout
- `GET /api/auth/check` - Check auth status
- `POST /api/change-password` - Change password (auth required)

### Heroes
- `GET /api/heroes` - Get all heroes
- `POST /api/heroes` - Create hero (auth required)
- `PUT /api/heroes/:id` - Update hero (auth required)
- `DELETE /api/heroes/:id` - Delete hero (auth required)

### Episodes
- `GET /api/episodes` - Get all episodes
- `POST /api/episodes` - Create episode (auth required)
- `PUT /api/episodes/:id` - Update episode (auth required)
- `DELETE /api/episodes/:id` - Delete episode (auth required)

### Blog
- `GET /api/blog` - Get published posts
- `GET /api/blog/all` - Get all posts (auth required)
- `POST /api/blog` - Create post (auth required)
- `PUT /api/blog/:id` - Update post (auth required)
- `DELETE /api/blog/:id` - Delete post (auth required)

### Static Content
- `GET /api/content` - Get all static content
- `PUT /api/content/:key` - Update content (auth required)

### File Upload
- `POST /api/upload` - Upload file (auth required)

## 🎯 Content Management

### Managing Heroes
1. Login to admin panel
2. Navigate to "Heroes" section
3. Click "+ Add New Hero"
4. Fill in hero details:
   - Name, slug, description
   - Upload image and video
   - Add 3 abilities
   - Set display order
5. Save

### Managing Episodes
1. Login to admin panel
2. Navigate to "Episodes" section
3. Click "+ Add New Episode"
4. Fill in episode details:
   - Episode number and title
   - Description and thumbnail
   - YouTube URL
   - Duration and release date
5. Save

### Managing Blog
1. Login to admin panel
2. Navigate to "Blog" section
3. Click "+ Write New Post"
4. Fill in post details:
   - Title and slug
   - Upload featured image
   - Write excerpt and content
   - Set publish status
5. Save

### Editing Static Content
1. Login to admin panel
2. Navigate to "Content Editor"
3. Edit any landing page text
4. Upload new images
5. Save changes

## 🎨 Design System

**Color Palette:**
- Primary Red: `#ff3366` - Action, energy
- Secondary Cyan: `#00ffcc` - Technology, future
- Accent Yellow: `#ffcc00` - Highlights
- Accent Purple: `#9933ff` - Mystery, power
- Dark Backgrounds: `#0a0a0f`, `#141419`, `#1e1e28`

**Typography:**
- Headings: **Orbitron** (futuristic, tech-inspired)
- Body: **Rajdhani** (modern, highly readable)

## 📱 Browser Compatibility

| Browser | Minimum Version |
|---------|----------------|
| Chrome  | 90+ |
| Firefox | 88+ |
| Safari  | 14+ |
| Edge    | 90+ |

## 🔒 Security Features

- ✅ Bcrypt password hashing (10 rounds)
- ✅ Session-based authentication
- ✅ Protected admin endpoints
- ✅ File upload validation
- ✅ SQL injection prevention (parameterized queries)
- ✅ CORS protection
- ✅ 24-hour session timeout

## 🚢 Deployment

### Heroku
```bash
# Add Procfile
echo "web: node server.js" > Procfile

# Deploy
heroku create your-app-name
git push heroku main
```

### DigitalOcean / VPS
```bash
# Clone repository
git clone https://github.com/skibimad/web.git
cd web

# Install dependencies
npm install

# Initialize database
npm run init-db

# Start with PM2
pm2 start server.js --name skibidi-madness
pm2 save
pm2 startup
```

### Environment Variables
```bash
PORT=3000  # Server port (default: 3000)
```

## 📝 License

See [LICENSE](LICENSE) file for details.

## ⚠️ Disclaimer

**Skibidi Madness** is a fan-created series inspired by the Skibidi Toilet universe created by DaFuq!?Boom!. This project is not officially affiliated with the original creator. All trademarks and copyrights belong to their respective owners.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 🎬 The Story

### Synopsis

In **Skibidi Madness**, a new story unfolds featuring the chaos and fury of the evil forces known as the **Asotra**. Unlike the original series where heroes battled entire armies, this saga focuses on a single, formidable enemy: the **Supreme Leader**.

This isn't just about the Skibidi Toilet universe from various stories. Skibidi Madness encompasses **everything that exists**: Marvel, Stranger Things, DC, Star Wars, Minecraft, and countless other universes collide in an unprecedented multiverse event.

### The Heroes

Five legendary champions stand against the darkness:

- **Titan Cameraman** - Tactical Vision
- **Titan Speakerman** - Sonic Devastation
- **Titan TV Man** - Reality Manipulation
- **G-Man** - Strategic Leadership
- **Star Storage** - Cosmic Power

Together, they face the greatest threat the multiverse has ever known.

## 📞 Contact & Support

- **YouTube**: [@FireStormX!?](https://www.youtube.com/@FireStormX!?)
- **Original Creator**: [@DaFuqBoom](https://www.youtube.com/@DaFuqBoom)
- **Issues**: Use GitHub Issues for bug reports

---

**Made with ❤️ by FireStormX Studios**

*Where Chaos Meets Destiny*
