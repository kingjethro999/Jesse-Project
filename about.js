/**
 * ABOUT PAGE FUNCTIONALITY
 * Interactive features for the about page including animations and statistics
 */

/**
 * About Page Manager Class
 */
class AboutPageManager {
    constructor() {
        this.statsCounters = [];
        this.timelineItems = [];
        this.init();
    }

    /**
     * Initialize about page
     */
    init() {
        try {
            this.initStatistics();
            this.initTimeline();
            this.initScrollAnimations();
            this.initEventListeners();
            
            console.log('About page manager initialized successfully');
        } catch (error) {
            console.error('Failed to initialize about page manager:', error);
        }
    }

    /**
     * Initialize statistics counters
     */
    initStatistics() {
        this.statsCounters = document.querySelectorAll('.stat-number[data-count]');
        
        if (this.statsCounters.length === 0) return;

        // Create intersection observer for stats section
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateCounters();
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            statsObserver.observe(statsSection);
        }
    }

    /**
     * Animate statistics counters
     */
    animateCounters() {
        this.statsCounters.forEach(counter => {
            const target = parseInt(counter.dataset.count);
            const duration = 2000; // 2 seconds
            const increment = target / (duration / 16); // 60fps
            let current = 0;

            const timer = setInterval(() => {
                current += increment;
                
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                
                counter.textContent = Math.floor(current).toLocaleString();
            }, 16);
        });
    }

    /**
     * Initialize timeline functionality
     */
    initTimeline() {
        this.timelineItems = document.querySelectorAll('.timeline-item');
        
        if (this.timelineItems.length === 0) return;

        // Create intersection observer for timeline
        const timelineObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 200);
                    timelineObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });

        this.timelineItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(50px)';
            item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            timelineObserver.observe(item);
        });
    }

    /**
     * Initialize scroll animations
     */
    initScrollAnimations() {
        // Animate elements on scroll
        const animateElements = document.querySelectorAll('.value-card, .team-member');
        
        const animationObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        animateElements.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            element.style.transitionDelay = `${index * 0.1}s`;
            animationObserver.observe(element);
        });
    }

    /**
     * Initialize event listeners
     */
    initEventListeners() {
        // Team member hover effects
        this.initTeamMemberEffects();
        
        // Value card interactions
        this.initValueCardEffects();
        
        // Story image parallax
        this.initStoryParallax();
        
        // CTA button tracking
        this.initCTATracking();
    }

    /**
     * Initialize team member hover effects
     */
    initTeamMemberEffects() {
        const teamMembers = document.querySelectorAll('.team-member');
        
        teamMembers.forEach(member => {
            member.addEventListener('mouseenter', () => {
                const avatar = member.querySelector('.team-avatar');
                if (avatar) {
                    avatar.style.transform = 'scale(1.1)';
                    avatar.style.transition = 'transform 0.3s ease';
                }
            });
            
            member.addEventListener('mouseleave', () => {
                const avatar = member.querySelector('.team-avatar');
                if (avatar) {
                    avatar.style.transform = 'scale(1)';
                }
            });
        });
    }

    /**
     * Initialize value card effects
     */
    initValueCardEffects() {
        const valueCards = document.querySelectorAll('.value-card');
        
        valueCards.forEach(card => {
            const icon = card.querySelector('.value-icon');
            
            card.addEventListener('mouseenter', () => {
                if (icon) {
                    icon.style.transform = 'scale(1.1) rotate(5deg)';
                    icon.style.transition = 'transform 0.3s ease';
                }
            });
            
            card.addEventListener('mouseleave', () => {
                if (icon) {
                    icon.style.transform = 'scale(1) rotate(0deg)';
                }
            });
        });
    }

    /**
     * Initialize story image parallax
     */
    initStoryParallax() {
        const storyImage = document.querySelector('.story-image img');
        
        if (!storyImage) return;

        window.addEventListener('scroll', PerformanceUtils.throttle(() => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.3;
            
            if (scrolled > 500 && scrolled < 1500) {
                storyImage.style.transform = `translateY(${rate}px)`;
            }
        }, 16));
    }

    /**
     * Initialize CTA button tracking
     */
    initCTATracking() {
        const ctaButtons = document.querySelectorAll('.cta-btn');
        
        ctaButtons.forEach(button => {
            button.addEventListener('click', () => {
                const action = button.textContent.trim();
                this.trackCTAClick(action);
            });
        });
    }

    /**
     * Track CTA button clicks
     */
    trackCTAClick(action) {
        console.log('CTA clicked:', action);
        
        // Track with analytics manager if available
        if (window.gufStoreApp?.analytics) {
            window.gufStoreApp.analytics.trackEvent('about_cta_click', { action });
        }
    }

    /**
     * Initialize smooth scrolling for anchor links
     */
    initSmoothScrolling() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    AnimationUtils.smoothScrollTo(target, 80);
                }
            });
        });
    }

    /**
     * Initialize reading progress indicator
     */
    initReadingProgress() {
        const progressBar = document.createElement('div');
        progressBar.style.cssText = `
            position: fixed;
            top: 76px;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            z-index: 1000;
            transition: width 0.3s ease;
        `;
        document.body.appendChild(progressBar);

        window.addEventListener('scroll', PerformanceUtils.throttle(() => {
            const scrollTop = window.pageYOffset;
            const docHeight = document.body.scrollHeight - window.innerHeight;
            const scrollPercent = (scrollTop / docHeight) * 100;
            
            progressBar.style.width = `${Math.min(scrollPercent, 100)}%`;
        }, 16));
    }

    /**
     * Initialize lazy loading for images
     */
    initLazyLoading() {
        const images = document.querySelectorAll('img[data-src]');
        
        if (images.length === 0) return;

        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        images.forEach(img => {
            imageObserver.observe(img);
        });
    }

    /**
     * Initialize section visibility tracking
     */
    initSectionTracking() {
        const sections = document.querySelectorAll('section');
        
        const sectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const sectionName = entry.target.className.split(' ')[0];
                    this.trackSectionView(sectionName);
                }
            });
        }, { threshold: 0.5 });

        sections.forEach(section => {
            sectionObserver.observe(section);
        });
    }

    /**
     * Track section views
     */
    trackSectionView(sectionName) {
        console.log('Section viewed:', sectionName);
        
        // Track with analytics manager if available
        if (window.gufStoreApp?.analytics) {
            window.gufStoreApp.analytics.trackEvent('about_section_view', { section: sectionName });
        }
    }

    /**
     * Initialize print functionality
     */
    initPrintFunctionality() {
        // Add print button if needed
        const printButton = document.createElement('button');
        printButton.innerHTML = '<i class="fas fa-print me-2"></i>Print Page';
        printButton.className = 'btn btn-outline-secondary position-fixed';
        printButton.style.cssText = `
            bottom: 20px;
            left: 20px;
            z-index: 1000;
            display: none;
        `;
        
        printButton.addEventListener('click', () => {
            window.print();
        });
        
        document.body.appendChild(printButton);

        // Show print button on larger screens
        if (window.innerWidth > 768) {
            printButton.style.display = 'block';
        }

        window.addEventListener('resize', () => {
            printButton.style.display = window.innerWidth > 768 ? 'block' : 'none';
        });
    }

    /**
     * Initialize accessibility features
     */
    initAccessibility() {
        // Add skip to content link
        const skipLink = document.createElement('a');
        skipLink.href = '#main-content';
        skipLink.textContent = 'Skip to main content';
        skipLink.className = 'skip-link';
        skipLink.style.cssText = `
            position: absolute;
            top: -40px;
            left: 6px;
            background: var(--primary-color);
            color: white;
            padding: 8px;
            text-decoration: none;
            border-radius: 4px;
            z-index: 10000;
            transition: top 0.3s;
        `;
        
        skipLink.addEventListener('focus', () => {
            skipLink.style.top = '6px';
        });
        
        skipLink.addEventListener('blur', () => {
            skipLink.style.top = '-40px';
        });
        
        document.body.insertBefore(skipLink, document.body.firstChild);

        // Add main content ID
        const mainContent = document.querySelector('.about-hero');
        if (mainContent) {
            mainContent.id = 'main-content';
        }

        // Improve keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', () => {
            document.body.classList.remove('keyboard-navigation');
        });
    }
}

// Initialize about page manager when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Wait for main app to be ready
    if (window.gufStoreApp) {
        window.aboutPageManager = new AboutPageManager();
    } else {
        // Wait for main app
        const checkApp = setInterval(() => {
            if (window.gufStoreApp) {
                window.aboutPageManager = new AboutPageManager();
                clearInterval(checkApp);
            }
        }, 100);
    }
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { AboutPageManager };
}
