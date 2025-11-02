const express = require('express');
const session = require('express-session');
const bodyParser = require('body-parser');
const multer = require('multer');
const bcrypt = require('bcrypt');
const sqlite3 = require('sqlite3').verbose();
const path = require('path');
const fs = require('fs');

const app = express();
const PORT = process.env.PORT || 3000;

// Database setup
const db = new sqlite3.Database('./database.sqlite', (err) => {
    if (err) {
        console.error('Error opening database:', err);
    } else {
        console.log('Connected to SQLite database');
    }
});

// Middleware
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(session({
    secret: 'skibidi-madness-secret-key-2024',
    resave: false,
    saveUninitialized: false,
    cookie: { maxAge: 24 * 60 * 60 * 1000 } // 24 hours
}));

// Static files
app.use(express.static('.'));
app.use('/uploads', express.static('uploads'));

// Create uploads directory if it doesn't exist
if (!fs.existsSync('./uploads')) {
    fs.mkdirSync('./uploads');
}

// Multer configuration for file uploads
const storage = multer.diskStorage({
    destination: function (req, file, cb) {
        cb(null, 'uploads/');
    },
    filename: function (req, file, cb) {
        const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9);
        cb(null, uniqueSuffix + path.extname(file.originalname));
    }
});

const upload = multer({
    storage: storage,
    limits: { fileSize: 10 * 1024 * 1024 }, // 10MB limit
    fileFilter: function (req, file, cb) {
        const allowedTypes = /jpeg|jpg|png|gif|webp|mp4/;
        const extname = allowedTypes.test(path.extname(file.originalname).toLowerCase());
        const mimetype = allowedTypes.test(file.mimetype);
        
        if (mimetype && extname) {
            return cb(null, true);
        } else {
            cb(new Error('Only images and videos are allowed'));
        }
    }
});

// Authentication middleware
function requireAuth(req, res, next) {
    if (req.session.userId) {
        next();
    } else {
        res.status(401).json({ error: 'Unauthorized' });
    }
}

// ==================== AUTH ROUTES ====================

// Login
app.post('/api/login', (req, res) => {
    const { username, password } = req.body;
    
    db.get('SELECT * FROM users WHERE username = ?', [username], async (err, user) => {
        if (err) {
            return res.status(500).json({ error: 'Database error' });
        }
        
        if (!user) {
            return res.status(401).json({ error: 'Invalid credentials' });
        }
        
        const validPassword = await bcrypt.compare(password, user.password);
        if (!validPassword) {
            return res.status(401).json({ error: 'Invalid credentials' });
        }
        
        req.session.userId = user.id;
        req.session.username = user.username;
        res.json({ success: true, username: user.username });
    });
});

// Logout
app.post('/api/logout', (req, res) => {
    req.session.destroy();
    res.json({ success: true });
});

// Check auth status
app.get('/api/auth/check', (req, res) => {
    if (req.session.userId) {
        res.json({ authenticated: true, username: req.session.username });
    } else {
        res.json({ authenticated: false });
    }
});

// Change password
app.post('/api/change-password', requireAuth, async (req, res) => {
    const { currentPassword, newPassword } = req.body;
    
    db.get('SELECT * FROM users WHERE id = ?', [req.session.userId], async (err, user) => {
        if (err) {
            return res.status(500).json({ error: 'Database error' });
        }
        
        const validPassword = await bcrypt.compare(currentPassword, user.password);
        if (!validPassword) {
            return res.status(401).json({ error: 'Current password is incorrect' });
        }
        
        const hashedPassword = await bcrypt.hash(newPassword, 10);
        
        db.run('UPDATE users SET password = ? WHERE id = ?', [hashedPassword, req.session.userId], (err) => {
            if (err) {
                return res.status(500).json({ error: 'Failed to update password' });
            }
            res.json({ success: true });
        });
    });
});

// ==================== HEROES ROUTES ====================

app.get('/api/heroes', (req, res) => {
    db.all('SELECT * FROM heroes ORDER BY display_order', [], (err, rows) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json(rows.map(row => ({
            ...row,
            abilities: JSON.parse(row.abilities || '[]')
        })));
    });
});

app.post('/api/heroes', requireAuth, (req, res) => {
    const { name, slug, description, image, video, abilities, display_order } = req.body;
    
    const sql = `INSERT INTO heroes (name, slug, description, image, video, abilities, display_order) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)`;
    
    db.run(sql, [name, slug, description, image, video, JSON.stringify(abilities), display_order], function(err) {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json({ id: this.lastID, success: true });
    });
});

app.put('/api/heroes/:id', requireAuth, (req, res) => {
    const { name, slug, description, image, video, abilities, display_order } = req.body;
    
    const sql = `UPDATE heroes SET name = ?, slug = ?, description = ?, image = ?, video = ?, 
                 abilities = ?, display_order = ? WHERE id = ?`;
    
    db.run(sql, [name, slug, description, image, video, JSON.stringify(abilities), display_order, req.params.id], (err) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json({ success: true });
    });
});

app.delete('/api/heroes/:id', requireAuth, (req, res) => {
    db.run('DELETE FROM heroes WHERE id = ?', [req.params.id], (err) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json({ success: true });
    });
});

// ==================== EPISODES ROUTES ====================

app.get('/api/episodes', (req, res) => {
    db.all('SELECT * FROM episodes ORDER BY episode_number', [], (err, rows) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json(rows);
    });
});

app.post('/api/episodes', requireAuth, (req, res) => {
    const { episode_number, title, description, thumbnail, video_url, duration, release_date } = req.body;
    
    const sql = `INSERT INTO episodes (episode_number, title, description, thumbnail, video_url, duration, release_date) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)`;
    
    db.run(sql, [episode_number, title, description, thumbnail, video_url, duration, release_date], function(err) {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json({ id: this.lastID, success: true });
    });
});

app.put('/api/episodes/:id', requireAuth, (req, res) => {
    const { episode_number, title, description, thumbnail, video_url, duration, release_date } = req.body;
    
    const sql = `UPDATE episodes SET episode_number = ?, title = ?, description = ?, thumbnail = ?, 
                 video_url = ?, duration = ?, release_date = ? WHERE id = ?`;
    
    db.run(sql, [episode_number, title, description, thumbnail, video_url, duration, release_date, req.params.id], (err) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json({ success: true });
    });
});

app.delete('/api/episodes/:id', requireAuth, (req, res) => {
    db.run('DELETE FROM episodes WHERE id = ?', [req.params.id], (err) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json({ success: true });
    });
});

// ==================== BLOG ROUTES ====================

app.get('/api/blog', (req, res) => {
    const sql = 'SELECT * FROM blog_posts WHERE published = 1 ORDER BY date DESC';
    
    db.all(sql, [], (err, rows) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json(rows);
    });
});

app.get('/api/blog/all', requireAuth, (req, res) => {
    db.all('SELECT * FROM blog_posts ORDER BY date DESC', [], (err, rows) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json(rows);
    });
});

app.post('/api/blog', requireAuth, (req, res) => {
    const { title, slug, image, excerpt, content, author, date, published } = req.body;
    
    const sql = `INSERT INTO blog_posts (title, slug, image, excerpt, content, author, date, published) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)`;
    
    db.run(sql, [title, slug, image, excerpt, content, author, date, published ? 1 : 0], function(err) {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json({ id: this.lastID, success: true });
    });
});

app.put('/api/blog/:id', requireAuth, (req, res) => {
    const { title, slug, image, excerpt, content, author, date, published } = req.body;
    
    const sql = `UPDATE blog_posts SET title = ?, slug = ?, image = ?, excerpt = ?, content = ?, 
                 author = ?, date = ?, published = ? WHERE id = ?`;
    
    db.run(sql, [title, slug, image, excerpt, content, author, date, published ? 1 : 0, req.params.id], (err) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json({ success: true });
    });
});

app.delete('/api/blog/:id', requireAuth, (req, res) => {
    db.run('DELETE FROM blog_posts WHERE id = ?', [req.params.id], (err) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json({ success: true });
    });
});

// ==================== STATIC CONTENT ROUTES ====================

app.get('/api/content', (req, res) => {
    db.all('SELECT * FROM static_content', [], (err, rows) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        const content = {};
        rows.forEach(row => {
            content[row.key] = row.value;
        });
        res.json(content);
    });
});

app.put('/api/content/:key', requireAuth, (req, res) => {
    const { value } = req.body;
    
    const sql = `INSERT OR REPLACE INTO static_content (key, value) VALUES (?, ?)`;
    
    db.run(sql, [req.params.key, value], (err) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json({ success: true });
    });
});

// ==================== FILE UPLOAD ROUTE ====================

app.post('/api/upload', requireAuth, upload.single('file'), (req, res) => {
    if (!req.file) {
        return res.status(400).json({ error: 'No file uploaded' });
    }
    
    const filePath = '/uploads/' + req.file.filename;
    res.json({ success: true, path: filePath });
});

// Start server
app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});

// Graceful shutdown
process.on('SIGINT', () => {
    db.close((err) => {
        if (err) {
            console.error(err.message);
        }
        console.log('Database connection closed');
        process.exit(0);
    });
});
