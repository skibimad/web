// Skibidi Madness - Main JavaScript

// Google Analytics Event Tracking Helper
function trackEvent(eventName, eventParams = {}) {
    if (typeof gtag === 'function') {
        gtag('event', eventName, eventParams);
        // Debug logging (disabled in production)
        if (window.location.hostname === 'localhost' || window.location.hostname.includes('127.0.0.1')) {
            console.log('GA Event:', eventName, eventParams);
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize translations
    if (window.translations) {
        window.translations.init();
    }
    
    // Initialize all features
    initLanguageSelector();
    initNavigation();
    initHeroCards();
    initScrollAnimations();
    initVideoAutoplay();
    initSmoothScroll();
    initAnalyticsTracking();
});

// Language Selector
function initLanguageSelector() {
    const langButtons = document.querySelectorAll('.lang-btn');
    
    langButtons.forEach(button => {
        button.addEventListener('click', function() {
            const lang = this.getAttribute('data-lang');
            if (window.translations) {
                window.translations.change(lang);
            }
        });
    });
}

// Navigation - Hamburger Menu
function initNavigation() {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    const navLinks = document.querySelectorAll('.nav-menu a');
    
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
            
            // Track hamburger menu toggle
            trackEvent('menu_toggle', {
                action: this.classList.contains('active') ? 'open' : 'close'
            });
        });
    }
    
    // Close menu when clicking on a link
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Track navigation menu clicks
            const linkText = this.textContent.trim();
            const linkHref = this.getAttribute('href');
            trackEvent('navigation_click', {
                link_text: linkText,
                link_url: linkHref,
                link_location: 'main_menu'
            });
            
            if (hamburger) {
                hamburger.classList.remove('active');
            }
            if (navMenu) {
                navMenu.classList.remove('active');
            }
        });
    });
    
    // Navbar background on scroll
    const navbar = document.querySelector('.navbar');
    let lastScroll = 0;
    
    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 100) {
            navbar.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.8)';
        } else {
            navbar.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.5)';
        }
        
        lastScroll = currentScroll;
    });
}

// Hero Cards - Video Preview on Hover
function initHeroCards() {
    const heroCards = document.querySelectorAll('.hero-card');
    
    heroCards.forEach(card => {
        const video = card.querySelector('.hero-video-preview');
        
        if (video) {
            card.addEventListener('mouseenter', function() {
                video.play().catch(err => {
                    // Autoplay might be blocked, ignore the error
                    console.log('Video autoplay prevented:', err);
                });
            });
            
            card.addEventListener('mouseleave', function() {
                video.pause();
                video.currentTime = 0;
            });
        }
    });
}

// Scroll Animations
function initScrollAnimations() {
    // Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe sections
    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(section);
    });
    
    // Observe cards
    const cards = document.querySelectorAll('.hero-card, .video-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
}

// Video Autoplay for Channel Section
function initVideoAutoplay() {
    const videos = document.querySelectorAll('video[autoplay]');
    
    // Ensure videos play when visible
    const videoObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.play().catch(err => {
                    console.log('Video autoplay prevented:', err);
                });
            } else {
                entry.target.pause();
            }
        });
    }, { threshold: 0.5 });
    
    videos.forEach(video => {
        videoObserver.observe(video);
    });
}

// Smooth Scroll for Navigation Links
function initSmoothScroll() {
    const navLinks = document.querySelectorAll('a[href^="#"]');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            
            // Skip if it's just '#'
            if (targetId === '#') {
                return;
            }
            
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                e.preventDefault();
                
                const navbarHeight = document.querySelector('.navbar').offsetHeight;
                const targetPosition = targetElement.offsetTop - navbarHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Parallax effect for hero section
window.addEventListener('scroll', function() {
    const heroVideo = document.querySelector('.hero-video');
    const scrolled = window.pageYOffset;
    
    if (heroVideo) {
        heroVideo.style.transform = `translateY(${scrolled * 0.5}px)`;
    }
});

// Loading screen (optional - can be added if needed)
window.addEventListener('load', function() {
    const loading = document.querySelector('.loading');
    if (loading) {
        loading.classList.add('hidden');
    }
});

// Add glitch effect to title on hover
const glitchText = document.querySelector('.glitch-text');
if (glitchText) {
    glitchText.addEventListener('mouseenter', function() {
        this.style.animationDuration = '0.3s';
    });
    
    glitchText.addEventListener('mouseleave', function() {
        this.style.animationDuration = '2s';
    });
}

// Prevent right-click on videos (optional protection)
const allVideos = document.querySelectorAll('video');
allVideos.forEach(video => {
    video.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        return false;
    });
});

// Console easter egg - using design system colors
const styles = {
    title: 'color: var(--color-primary, #ff3366); font-size: 24px; font-weight: bold; text-shadow: 2px 2px 0px var(--color-secondary, #00ffcc);',
    subtitle: 'color: var(--color-secondary, #00ffcc); font-size: 16px;',
    link: 'color: var(--color-accent, #ffcc00); font-size: 14px;'
};

console.log('%c🎬 Skibidi Madness 🎬', styles.title);
console.log('%cWelcome to the Multiverse!', styles.subtitle);
console.log('%cSubscribe to FireStormX Studios: https://www.youtube.com/@FireStorm-Tri', styles.link);

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Press 'H' to go to home
    if (e.key === 'h' || e.key === 'H') {
        if (!e.ctrlKey && !e.metaKey && document.activeElement.tagName !== 'INPUT') {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
    
    // Press 'L' to change language
    if (e.key === 'l' || e.key === 'L') {
        if (!e.ctrlKey && !e.metaKey && document.activeElement.tagName !== 'INPUT') {
            const langButtons = document.querySelectorAll('.lang-btn');
            const activeLang = document.querySelector('.lang-btn.active');
            const currentIndex = Array.from(langButtons).indexOf(activeLang);
            const nextIndex = (currentIndex + 1) % langButtons.length;
            langButtons[nextIndex].click();
        }
    }
});

// Add dynamic copyright year
const footerBottom = document.querySelector('.footer-bottom p');
if (footerBottom) {
    const currentYear = new Date().getFullYear();
    // Only replace the year in the copyright notice
    footerBottom.innerHTML = footerBottom.innerHTML.replace(/©\s*\d{4}/, `© ${currentYear}`);
}

// Performance optimization: Lazy load images
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }
                imageObserver.unobserve(img);
            }
        });
    });
    
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Add touch support for hero cards on mobile
if ('ontouchstart' in window) {
    const heroCards = document.querySelectorAll('.hero-card');
    
    heroCards.forEach(card => {
        let touchStartTime;
        
        card.addEventListener('touchstart', function() {
            touchStartTime = Date.now();
        });
        
        card.addEventListener('touchend', function(e) {
            const touchDuration = Date.now() - touchStartTime;
            
            // If it's a quick tap (less than 200ms), toggle video
            if (touchDuration < 200) {
                const video = this.querySelector('.hero-video-preview');
                const image = this.querySelector('.hero-image');
                
                if (video && image) {
                    if (video.style.opacity === '1') {
                        video.style.opacity = '0';
                        video.pause();
                        video.currentTime = 0;
                        image.style.opacity = '1';
                    } else {
                        video.style.opacity = '1';
                        image.style.opacity = '0';
                        video.play().catch(err => {
                            console.log('Video play prevented:', err);
                        });
                    }
                }
            }
        });
    });
}

// Initialize Google Analytics Event Tracking
function initAnalyticsTracking() {
    // Track Hero Section CTA buttons
    const heroCTAs = document.querySelectorAll('.hero-buttons .btn');
    heroCTAs.forEach(btn => {
        btn.addEventListener('click', function() {
            const btnText = this.textContent.trim();
            const btnHref = this.getAttribute('href');
            trackEvent('cta_click', {
                button_text: btnText,
                button_url: btnHref,
                section: 'hero'
            });
        });
    });
    
    // Track Episode video play buttons
    const episodePlayButtons = document.querySelectorAll('.video-card .play-button');
    episodePlayButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const videoCard = this.closest('.video-card');
            const episodeTitle = videoCard ? videoCard.querySelector('h3')?.textContent.trim() : 'Unknown';
            const videoUrl = this.getAttribute('href');
            
            trackEvent('video_click', {
                video_title: episodeTitle,
                video_url: videoUrl,
                section: 'episodes'
            });
        });
    });
    
    // Track Footer links
    const footerLinks = document.querySelectorAll('.footer a');
    footerLinks.forEach(link => {
        link.addEventListener('click', function() {
            const linkText = this.textContent.trim();
            const linkHref = this.getAttribute('href');
            const footerColumn = this.closest('.footer-column');
            const columnTitle = footerColumn ? footerColumn.querySelector('h4')?.textContent.trim() : 'footer';
            
            trackEvent('footer_link_click', {
                link_text: linkText,
                link_url: linkHref,
                footer_section: columnTitle
            });
        });
    });
    
    // Track Channel section subscribe button
    const channelSubscribeBtn = document.querySelector('.channel-section .btn-channel');
    if (channelSubscribeBtn) {
        channelSubscribeBtn.addEventListener('click', function() {
            trackEvent('subscribe_click', {
                button_text: this.textContent.trim(),
                section: 'channel',
                button_url: this.getAttribute('href')
            });
        });
    }
    
    // Track "Watch Now" links in hero section
    const watchNowLinks = document.querySelectorAll('.hero-buttons a[href="#videos"]');
    watchNowLinks.forEach(link => {
        link.addEventListener('click', function() {
            trackEvent('internal_navigation', {
                link_text: this.textContent.trim(),
                target_section: 'videos',
                source_section: 'hero'
            });
        });
    });
    
    // Track original series reference links
    const referenceLinks = document.querySelectorAll('.reference-links a, .original-references a[target="_blank"]');
    referenceLinks.forEach(link => {
        link.addEventListener('click', function() {
            trackEvent('external_link_click', {
                link_text: this.textContent.trim(),
                link_url: this.getAttribute('href'),
                section: 'about'
            });
        });
    });
}
