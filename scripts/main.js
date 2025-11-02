/**
 * Skibidi Madness - Main JavaScript
 * English Only Version
 */

document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
    }

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                    // Close mobile menu if open
                    if (navMenu.classList.contains('active')) {
                        navMenu.classList.remove('active');
                        mobileMenuToggle.classList.remove('active');
                    }
                }
            }
        });
    });

    // Parallax effect for hero video
    const heroSection = document.querySelector('.hero-section');
    const heroVideo = document.querySelector('.hero-video');
    
    if (heroSection && heroVideo) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const rate = scrolled * 0.5;
            heroVideo.style.transform = `translate3d(0, ${rate}px, 0)`;
        });
    }

    // Hero video preview on hover
    const heroCards = document.querySelectorAll('.hero-card');
    
    heroCards.forEach(card => {
        const image = card.querySelector('.hero-image');
        const video = card.querySelector('.hero-video-preview');
        
        if (image && video) {
            card.addEventListener('mouseenter', function() {
                video.style.opacity = '1';
                video.play().catch(e => console.log('Video play failed:', e));
            });
            
            card.addEventListener('mouseleave', function() {
                video.style.opacity = '0';
                video.pause();
                video.currentTime = 0;
            });
        }
    });

    // Scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe elements
    document.querySelectorAll('.hero-card, .episode-card, .blog-card, .stat-item').forEach(el => {
        observer.observe(el);
    });

    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    let lastScroll = 0;

    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 100) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        lastScroll = currentScroll;
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // H key - scroll to home
        if (e.key === 'h' || e.key === 'H') {
            if (!e.target.matches('input, textarea')) {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    });

    // Console message
    console.log('%c🎬 SKIBIDI MADNESS 🎬', 'color: #ff3366; font-size: 24px; font-weight: bold;');
    console.log('%cWelcome to the Multiverse!', 'color: #00ffcc; font-size: 16px;');
    console.log('%cFireStormX Studios © ' + new Date().getFullYear(), 'color: #ffcc00; font-size: 12px;');
});
