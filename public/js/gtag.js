// Google Analytics Event Tracking
// Skibidi Madness - GA4 Event Tracking Implementation

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

// Initialize Google Analytics Event Tracking
function initAnalyticsTracking() {
    // Track navigation menu clicks
    const navLinks = document.querySelectorAll('.nav-menu a');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            const linkText = this.textContent.trim();
            const linkHref = this.getAttribute('href');
            trackEvent('navigation_click', {
                link_text: linkText,
                link_url: linkHref,
                link_location: 'main_menu'
            });
        });
    });
    
    // Track hamburger menu toggle
    const hamburger = document.querySelector('.hamburger');
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            trackEvent('menu_toggle', {
                action: this.classList.contains('active') ? 'close' : 'open'
            });
        });
    }
    
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

// Initialize analytics tracking when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initAnalyticsTracking();
});
