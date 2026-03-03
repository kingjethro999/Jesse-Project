/**
 * PRELOADER SYSTEM
 * Handles page loading animation and progress tracking
 * Uses modern ES6+ features and smooth animations
 */

class Preloader {
    constructor() {
        this.preloader = document.getElementById('preloader');
        this.progressBar = document.querySelector('.loading-progress');
        this.loadingText = document.querySelector('.loading-text p');
        this.progress = 0;
        this.loadingMessages = [
            'Loading Elegance...',
            'Preparing Fabrics...',
            'Setting up Shop...',
            'Almost Ready...',
            'Welcome to GUF XTORE!'
        ];
        this.currentMessageIndex = 0;
        this.isLoading = true;
        
        this.init();
    }

    /**
     * Initialize the preloader
     */
    init() {
        if (!this.preloader) {
            console.warn('Preloader element not found');
            return;
        }

        this.bindEvents();
        this.startLoading();
        this.simulateProgress();
    }

    /**
     * Bind event listeners
     */
    bindEvents() {
        // Handle page visibility changes
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden && this.isLoading) {
                this.continueLoading();
            }
        });

        // Handle window load event
        window.addEventListener('load', () => {
            this.completeLoading();
        });

        // Handle beforeunload event
        window.addEventListener('beforeunload', () => {
            this.resetPreloader();
        });
    }

    /**
     * Start the loading process
     */
    startLoading() {
        this.isLoading = true;
        this.progress = 0;
        this.currentMessageIndex = 0;
        
        // Start with first message
        this.updateLoadingMessage();
        
        // Start progress simulation
        this.progressInterval = setInterval(() => {
            this.updateProgress();
        }, 50);

        // Start message rotation
        this.messageInterval = setInterval(() => {
            this.rotateLoadingMessage();
        }, 800);
    }

    /**
     * Simulate realistic loading progress
     */
    simulateProgress() {
        const progressSteps = [
            { progress: 15, delay: 200 },
            { progress: 35, delay: 400 },
            { progress: 55, delay: 600 },
            { progress: 75, delay: 800 },
            { progress: 90, delay: 1000 },
            { progress: 100, delay: 1200 }
        ];

        progressSteps.forEach((step, index) => {
            setTimeout(() => {
                if (this.isLoading) {
                    this.progress = step.progress;
                    this.updateProgressBar();
                    
                    if (step.progress === 100) {
                        this.completeLoading();
                    }
                }
            }, step.delay * (index + 1));
        });
    }

    /**
     * Update progress bar
     */
    updateProgress() {
        if (!this.isLoading) return;

        // Simulate realistic progress with slight randomness
        const increment = Math.random() * 2 + 0.5;
        this.progress = Math.min(this.progress + increment, 95);
        
        this.updateProgressBar();
    }

    /**
     * Update progress bar visual
     */
    updateProgressBar() {
        if (this.progressBar) {
            this.progressBar.style.width = `${this.progress}%`;
            
            // Add glow effect when nearing completion
            if (this.progress > 80) {
                this.progressBar.style.boxShadow = '0 0 20px rgba(255, 255, 255, 0.5)';
            }
        }
    }

    /**
     * Rotate loading messages
     */
    rotateLoadingMessage() {
        if (!this.isLoading || !this.loadingText) return;

        this.currentMessageIndex = (this.currentMessageIndex + 1) % this.loadingMessages.length;
        this.updateLoadingMessage();
    }

    /**
     * Update loading message with animation
     */
    updateLoadingMessage() {
        if (!this.loadingText) return;

        // Fade out current message
        this.loadingText.style.opacity = '0';
        this.loadingText.style.transform = 'translateY(10px)';

        setTimeout(() => {
            // Update message
            this.loadingText.textContent = this.loadingMessages[this.currentMessageIndex];
            
            // Fade in new message
            this.loadingText.style.opacity = '1';
            this.loadingText.style.transform = 'translateY(0)';
        }, 150);
    }

    /**
     * Continue loading if interrupted
     */
    continueLoading() {
        if (this.isLoading && this.progress < 100) {
            this.simulateProgress();
        }
    }

    /**
     * Complete the loading process
     */
    completeLoading() {
        if (!this.isLoading) return;

        this.isLoading = false;
        this.progress = 100;
        
        // Clear intervals
        if (this.progressInterval) {
            clearInterval(this.progressInterval);
        }
        if (this.messageInterval) {
            clearInterval(this.messageInterval);
        }

        // Final progress update
        this.updateProgressBar();
        this.updateLoadingMessage();

        // Add completion class for final animation
        this.preloader.classList.add('fade-out');

        // Remove preloader after animation
        setTimeout(() => {
            this.removePreloader();
        }, 500);

        // Trigger custom event
        this.dispatchLoadCompleteEvent();
    }

    /**
     * Remove preloader from DOM
     */
    removePreloader() {
        if (this.preloader) {
            this.preloader.style.display = 'none';
            document.body.classList.add('loaded');
        }
    }

    /**
     * Reset preloader for page refresh
     */
    resetPreloader() {
        this.isLoading = false;
        
        if (this.progressInterval) {
            clearInterval(this.progressInterval);
        }
        if (this.messageInterval) {
            clearInterval(this.messageInterval);
        }

        if (this.preloader) {
            this.preloader.classList.remove('fade-out');
            this.preloader.style.display = 'flex';
        }

        document.body.classList.remove('loaded');
    }

    /**
     * Dispatch load complete event
     */
    dispatchLoadCompleteEvent() {
        const event = new CustomEvent('preloaderComplete', {
            detail: {
                loadTime: performance.now(),
                timestamp: Date.now()
            }
        });
        document.dispatchEvent(event);
    }

    /**
     * Get loading progress
     */
    getProgress() {
        return this.progress;
    }

    /**
     * Check if loading is complete
     */
    isComplete() {
        return !this.isLoading && this.progress === 100;
    }

    /**
     * Force complete loading (for testing)
     */
    forceComplete() {
        this.completeLoading();
    }
}

/**
 * Enhanced preloader with additional features
 */
class EnhancedPreloader extends Preloader {
    constructor() {
        super();
        this.loadingAssets = new Set();
        this.loadedAssets = new Set();
        this.assetProgress = 0;
        this.initAssetTracking();
    }

    /**
     * Initialize asset tracking
     */
    initAssetTracking() {
        // Track images
        this.trackImages();
        
        // Track fonts
        this.trackFonts();
        
        // Track external scripts
        this.trackScripts();
    }

    /**
     * Track image loading
     */
    trackImages() {
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            this.loadingAssets.add(img.src || img.dataset.src);
            
            if (img.complete) {
                this.loadedAssets.add(img.src || img.dataset.src);
            } else {
                img.addEventListener('load', () => {
                    this.loadedAssets.add(img.src || img.dataset.src);
                    this.updateAssetProgress();
                });
                
                img.addEventListener('error', () => {
                    this.loadedAssets.add(img.src || img.dataset.src);
                    this.updateAssetProgress();
                });
            }
        });
    }

    /**
     * Track font loading
     */
    trackFonts() {
        if ('fonts' in document) {
            document.fonts.ready.then(() => {
                this.fontsLoaded = true;
                this.updateAssetProgress();
            });
        }
    }

    /**
     * Track script loading
     */
    trackScripts() {
        const scripts = document.querySelectorAll('script[src]');
        scripts.forEach(script => {
            this.loadingAssets.add(script.src);
            
            script.addEventListener('load', () => {
                this.loadedAssets.add(script.src);
                this.updateAssetProgress();
            });
        });
    }

    /**
     * Update asset loading progress
     */
    updateAssetProgress() {
        if (this.loadingAssets.size === 0) {
            this.assetProgress = 100;
            return;
        }

        this.assetProgress = (this.loadedAssets.size / this.loadingAssets.size) * 100;
        
        // Combine with base progress
        const combinedProgress = (this.progress + this.assetProgress) / 2;
        this.progress = Math.min(combinedProgress, 100);
        
        this.updateProgressBar();
    }
}

/**
 * Utility functions for preloader
 */
const PreloaderUtils = {
    /**
     * Create a simple preloader programmatically
     */
    createSimplePreloader(container) {
        const preloader = document.createElement('div');
        preloader.className = 'simple-preloader';
        preloader.innerHTML = `
            <div class="spinner"></div>
            <p>Loading...</p>
        `;
        
        container.appendChild(preloader);
        return preloader;
    },

    /**
     * Remove preloader with animation
     */
    removeWithAnimation(preloader, callback) {
        preloader.style.opacity = '0';
        preloader.style.transform = 'scale(0.8)';
        
        setTimeout(() => {
            preloader.remove();
            if (callback) callback();
        }, 300);
    },

    /**
     * Check if page is fully loaded
     */
    isPageLoaded() {
        return document.readyState === 'complete' && 
               (document.querySelectorAll('img[src]').length === 0 || 
                Array.from(document.querySelectorAll('img[src]')).every(img => img.complete));
    }
};

// Auto-initialize preloader when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize enhanced preloader
    window.preloader = new EnhancedPreloader();
    
    // Add global error handling for preloader
    window.addEventListener('error', (event) => {
        if (window.preloader && !window.preloader.isComplete()) {
            console.warn('Error during loading, forcing preloader completion');
            setTimeout(() => {
                window.preloader.forceComplete();
            }, 1000);
        }
    });
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { Preloader, EnhancedPreloader, PreloaderUtils };
}
