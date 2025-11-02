// Skibidi Madness - Main JavaScript

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initNavigation();
    initHeroCards();
    initScrollAnimations();
    initVideoAutoplay();
    initSmoothScroll();
    updateCopyrightYear();
});

// Navigation - Hamburger Menu
function initNavigation() {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    const navLinks = document.querySelectorAll('.nav-menu a');
    
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
    }
    
    // Close menu when clicking on a link
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (hamburger) {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            }
        });
    });
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 100) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
}

// Hero Cards - Video autoplay on hover
function initHeroCards() {
    const heroCards = document.querySelectorAll('.hero-card');
    
    heroCards.forEach(card => {
        const video = card.querySelector('.hero-video');
        
        if (video) {
            card.addEventListener('mouseenter', function() {
                video.play();
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
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe elements with fade-in-section class
    document.querySelectorAll('.hero-card, .video-card, .blog-card').forEach(el => {
        observer.observe(el);
    });
}

// Video autoplay with mute
function initVideoAutoplay() {
    const videos = document.querySelectorAll('video[autoplay]');
    
    videos.forEach(video => {
        video.muted = true;
        video.play().catch(error => {
            console.log('Autoplay prevented:', error);
        });
    });
}

// Smooth scrolling for anchor links
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            
            // Don't prevent default for just "#"
            if (href === '#') return;
            
            e.preventDefault();
            const target = document.querySelector(href);
            
            if (target) {
                const offsetTop = target.offsetTop - 80; // Account for fixed navbar
                
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Scroll indicator
    const scrollIndicator = document.querySelector('.scroll-indicator');
    if (scrollIndicator) {
        scrollIndicator.addEventListener('click', function() {
            const aboutSection = document.querySelector('#about');
            if (aboutSection) {
                aboutSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }
}

// Update copyright year dynamically
function updateCopyrightYear() {
    const footerBottom = document.querySelector('.footer-bottom p');
    if (footerBottom) {
        const currentYear = new Date().getFullYear();
        // Only replace the year in the copyright notice
        footerBottom.innerHTML = footerBottom.innerHTML.replace(/©\s*\d{4}/, `© ${currentYear}`);
    }
}

// Performance optimization: Lazy load images
if ('loading' in HTMLImageElement.prototype) {
    const images = document.querySelectorAll('img[loading="lazy"]');
    images.forEach(img => {
        img.src = img.dataset.src;
    });
} else {
    // Fallback for browsers that don't support lazy loading
    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
    document.body.appendChild(script);
}

// Parallax effect for hero section
window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset;
    const heroBackground = document.querySelector('.hero-background');
    
    if (heroBackground) {
        heroBackground.style.transform = `translateY(${scrolled * 0.5}px)`;
    }
});

// Console easter egg
const styles = {
    title: 'color: var(--color-primary, #ff3366); font-size: 24px; font-weight: bold; text-shadow: 2px 2px 0px var(--color-secondary, #00ffcc);',
    subtitle: 'color: var(--color-secondary, #00ffcc); font-size: 16px;',
    link: 'color: var(--color-accent, #ffcc00); font-size: 14px;'
};

console.log('%c🎬 Skibidi Madness 🎬', styles.title);
console.log('%cWelcome to the Multiverse!', styles.subtitle);
console.log('%cSubscribe to FireStormX Studios: https://www.youtube.com/@FireStormX!?', styles.link);

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // H key - go to home
    if (e.key === 'h' || e.key === 'H') {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});
