# 🎬 Skibidi Madness - Official Landing Page

![Skibidi Madness](res/img/all-together.png)

## 🌟 Overview

**Skibidi Madness** is an epic multi-universe animation series created by **FireStormX Studios** that transcends the boundaries of the original Skibidi Toilet universe. This landing page showcases the revolutionary fusion of multiple dimensions, timelines, and realities where heroes unite against the forces of chaos.

### 🎯 Key Features

- **Multi-language Support**: Available in English, Spanish, French, and German
- **Responsive Design**: Optimized for all devices from mobile to desktop
- **Post-Apocalyptic Theme**: Dark, gritty aesthetics with neon accents
- **Interactive Hero Gallery**: Hover effects and video previews
- **Video Integration**: Embedded promo videos and YouTube links
- **Smooth Animations**: Professional transitions and scroll effects
- **SEO Optimized**: Meta tags and semantic HTML structure

## 🚀 Quick Start

### Option 1: Direct Access (Recommended)

Simply open `index.html` in your web browser:

```bash
# Navigate to the project directory
cd /path/to/skibidi-madness-web

# Open in your default browser
# On macOS:
open index.html

# On Linux:
xdg-open index.html

# On Windows:
start index.html
```

### Option 2: Local Server

For the best experience with video playback:

```bash
# Using Python 3
python -m http.server 8000

# Using Python 2
python -m SimpleHTTPServer 8000

# Using Node.js (if you have http-server installed)
npx http-server -p 8000

# Using PHP
php -S localhost:8000
```

Then open `http://localhost:8000` in your browser.

## 📁 Project Structure

```
skibidi-madness-web/
├── index.html                  # Main HTML file
├── README.md                   # This file
├── LICENSE                     # License information
├── styles/
│   └── main.css               # Main stylesheet
├── scripts/
│   ├── translations.js        # Multi-language translations
│   └── main.js                # Main JavaScript functionality
└── res/                       # Resources directory
    ├── img/
    │   ├── all-together.png   # Main hero image
    │   └── heroes/
    │       └── promo/         # Individual hero images
    │           ├── g-man.png
    │           ├── star-storage.png
    │           ├── titan-camera.png
    │           ├── titan-speaker.png
    │           └── titan-tv.png
    └── video/
        ├── all-together.mp4   # Main promo video
        └── heroes/
            └── promo/         # Individual hero videos
                ├── g-man.mp4
                ├── star-storage.mp4
                ├── titan-camera.mp4
                ├── titan-speaker.mp4
                └── titan-tv.mp4
```

## 🎨 Design & Theme

### Color Palette

The landing page uses a **post-apocalyptic fantasy** color scheme:

- **Primary Red**: `#ff3366` - Action, danger, energy
- **Secondary Cyan**: `#00ffcc` - Technology, future
- **Accent Yellow**: `#ffcc00` - Highlights, warnings
- **Accent Purple**: `#9933ff` - Mystery, power
- **Dark Backgrounds**: `#0a0a0f`, `#141419`, `#1e1e28`

### Typography

- **Headings**: [Orbitron](https://fonts.google.com/specimen/Orbitron) - Futuristic, tech-inspired
- **Body Text**: [Rajdhani](https://fonts.google.com/specimen/Rajdhani) - Modern, readable

## 🌍 Multi-Language Support

The site supports four languages:

| Language | Code | Status |
|----------|------|--------|
| English  | `en` | ✅ Complete |
| Spanish  | `es` | ✅ Complete |
| French   | `fr` | ✅ Complete |
| German   | `de` | ✅ Complete |

Language can be changed using:
- Language selector buttons in the top-right corner
- Keyboard shortcut: Press `L` key
- Preference is saved in browser's localStorage

## 🎭 Featured Heroes

### 1. Titan Cameraman
The vigilant guardian with unmatched surveillance capabilities and devastating firepower.

### 2. Titan Speakerman
Master of sonic devastation who channels raw sound energy into overwhelming force.

### 3. Titan TV Man
The hypnotic warrior whose screen broadcasts reality-altering frequencies.

### 4. G-Man
The enigmatic leader whose true power remains shrouded in mystery.

### 5. Star Storage
The cosmic keeper who harnesses stellar energy from across galaxies.

## 📺 YouTube Integration

### Official Channels & References

- **FireStormX Studios**: [@FirestomX-Tri](https://www.youtube.com/@FirestomX-Tri) - Original content creator
- **DaFuq!?Boom!**: [@DaFuqBoom](https://www.youtube.com/@DaFuqBoom) - Original Skibidi Toilet creator
- **DOM Studio**: [@DOMSTUDIO](https://www.youtube.com/@DOMSTUDIO) - Community contributor
- **Virlance**: [@virlance](https://www.youtube.com/@virlance) - Community contributor
- **Maxedy**: [@MaxedyYT](https://www.youtube.com/@MaxedyYT) - Community contributor

## 🛠️ Technologies Used

- **HTML5**: Semantic markup, video support
- **CSS3**: Flexbox, Grid, animations, custom properties
- **JavaScript (ES6+)**: Modern features, no frameworks required
- **Google Fonts**: Orbitron & Rajdhani
- **Responsive Design**: Mobile-first approach

## 📱 Browser Compatibility

| Browser | Minimum Version |
|---------|----------------|
| Chrome  | 90+ |
| Firefox | 88+ |
| Safari  | 14+ |
| Edge    | 90+ |

## ⚡ Performance Optimizations

- **Lazy Loading**: Images load only when needed
- **Video Optimization**: Compressed MP4 format with efficient codecs
- **CSS Animations**: Hardware-accelerated transforms
- **Minimal Dependencies**: No heavy frameworks
- **Responsive Images**: Appropriate sizing for different viewports

## 🎮 Interactive Features

### Keyboard Shortcuts

- `H` - Scroll to home/top
- `L` - Cycle through languages

### Mobile Support

- Touch-enabled hero cards
- Responsive hamburger menu
- Optimized video playback
- Smooth scrolling

### Desktop Enhancements

- Parallax effects
- Hover video previews
- Advanced animations
- Glitch effects

## 📊 SEO & Metadata

The page includes comprehensive SEO optimization:

- Meta descriptions
- Open Graph tags
- Semantic HTML structure
- Keyword optimization
- Accessibility features

## 🔧 Customization

### Changing Colors

Edit CSS variables in `styles/main.css`:

```css
:root {
    --color-primary: #ff3366;
    --color-secondary: #00ffcc;
    /* etc. */
}
```

### Adding New Languages

Add translations in `scripts/translations.js`:

```javascript
translations.newLang = {
    nav: { /* ... */ },
    hero: { /* ... */ },
    // etc.
};
```

### Modifying Content

Edit `index.html` directly. All translatable text uses `data-i18n` attributes.

## 🌐 Deployment

### GitHub Pages

```bash
# Enable GitHub Pages in repository settings
# Select main branch and root directory
# Access at: https://yourusername.github.io/repository-name
```

### Netlify

```bash
# Drag and drop the project folder to Netlify
# Or connect your GitHub repository
```

### Vercel

```bash
# Import your GitHub repository
# Build command: (leave empty)
# Output directory: .
```

### Traditional Hosting

Upload all files to your web server via FTP/SFTP. Ensure relative paths are maintained.

## 📄 File Paths

All resource paths are **relative** for portability:

```html
<!-- Images -->
<img src="res/img/all-together.png">

<!-- Videos -->
<video src="res/video/all-together.mp4">

<!-- Stylesheets -->
<link href="styles/main.css">

<!-- Scripts -->
<script src="scripts/main.js">
```

The entire project can be moved to any directory without breaking links.

## 🎥 Media Credits

All hero images and videos are located in the `res/` directory:

- Hero promo images: `res/img/heroes/promo/`
- Hero promo videos: `res/video/heroes/promo/`
- Combined visuals: `res/img/all-together.png` and `res/video/all-together.mp4`

## 🤝 Contributing

This is a fan-created project. Contributions are welcome!

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test across browsers
5. Submit a pull request

## 📜 License

See [LICENSE](LICENSE) file for details.

## ⚠️ Disclaimer

**Skibidi Madness** is a fan-created series inspired by the Skibidi Toilet universe. This project is not officially affiliated with the original creators (DaFuq!?Boom! or other community creators). All trademarks and copyrights belong to their respective owners.

This landing page is created for entertainment and promotional purposes.

## 🎬 The Story

### Synopsis

In **Skibidi Madness**, a new story unfolds featuring the chaos and fury of the evil forces known as the **Asotra**. Unlike the original series where heroes battled entire armies, this saga focuses on a single, formidable enemy: the **Supreme Leader**.

This isn't just about the Skibidi Toilet universe from various stories like DOM Studio, Virlance, or Maxedy. Skibidi Madness encompasses **everything that exists**: Marvel, Stranger Things, DC, Star Wars, Minecraft, and countless other universes collide in an unprecedented multiverse event.

### The Heroes

Five legendary champions stand against the darkness:

- **Titan Cameraman** - Tactical Vision
- **Titan Speakerman** - Sonic Devastation
- **Titan TV Man** - Reality Manipulation
- **G-Man** - Strategic Leadership
- **Star Storage** - Cosmic Power

Together, they face the greatest threat the multiverse has ever known.

## 📞 Contact & Support

- **YouTube**: [@FirestomX-Tri](https://www.youtube.com/@FirestomX-Tri)
- **Issues**: Use GitHub Issues for bug reports
- **Discussions**: Use GitHub Discussions for questions

## 🎉 Special Thanks

- DaFuq!?Boom! for creating the original Skibidi Toilet universe
- DOM Studio, Virlance, Maxedy for expanding the community
- All fans and supporters of the series

---

**Made with ❤️ by FireStormX Studios**

*Where Chaos Meets Destiny*
