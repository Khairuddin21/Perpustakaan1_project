// Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize dashboard
    initializeDashboard();
    
    // Initialize animations
    initializeAnimations();
    
    // Initialize interactions
    initializeInteractions();
    
    // Initialize responsive features
    initializeResponsive();
});

function initializeDashboard() {
    // Add loading animation to cards
    const cards = document.querySelectorAll('.stat-card, .action-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('slide-up');
    });
    
    // Initialize counters for statistics
    animateCounters();
    
    // Add ripple effect to clickable elements
    addRippleEffect();
}

function initializeAnimations() {
    // Intersection Observer for scroll animations
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                
                // Special handling for different elements
                if (entry.target.classList.contains('stat-card')) {
                    entry.target.classList.add('scale-in');
                }
                
                if (entry.target.classList.contains('action-card')) {
                    entry.target.style.animationDelay = '0.2s';
                    entry.target.classList.add('slide-up');
                }
            }
        });
    }, observerOptions);

    // Observe all animated elements
    const animatedElements = document.querySelectorAll('.stat-card, .action-card, .recent-activity, .welcome-section');
    animatedElements.forEach(el => observer.observe(el));
}

function initializeInteractions() {
    // Sidebar toggle functionality
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    
    if (menuToggle && sidebar && mainContent) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
            mainContent.classList.toggle('expanded');
            
            // Store sidebar state in localStorage
            const isOpen = sidebar.classList.contains('open');
            localStorage.setItem('sidebarOpen', isOpen);
        });
        
        // Restore sidebar state
        const sidebarState = localStorage.getItem('sidebarOpen');
        if (sidebarState === 'true') {
            sidebar.classList.add('open');
            mainContent.classList.add('expanded');
        }
    }
    
    // Action card click handlers
    const actionCards = document.querySelectorAll('.action-card');
    actionCards.forEach(card => {
        card.addEventListener('click', function() {
            const action = this.dataset.action;
            handleActionCardClick(action);
        });
    });
    
    // Navigation item interactions
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Remove active class from all items
            navItems.forEach(nav => nav.classList.remove('active'));
            // Add active class to clicked item
            this.classList.add('active');
            
            // Add click animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
}

function initializeResponsive() {
    // Handle responsive sidebar
    function handleResize() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        if (window.innerWidth <= 768) {
            sidebar?.classList.remove('open');
            mainContent?.classList.add('expanded');
        } else {
            const sidebarState = localStorage.getItem('sidebarOpen');
            if (sidebarState !== 'false') {
                sidebar?.classList.add('open');
                mainContent?.classList.remove('expanded');
            }
        }
    }
    
    window.addEventListener('resize', debounce(handleResize, 250));
    handleResize(); // Initial call
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menuToggle');
            
            if (sidebar && !sidebar.contains(e.target) && !menuToggle?.contains(e.target)) {
                sidebar.classList.remove('open');
                document.getElementById('mainContent')?.classList.add('expanded');
            }
        }
    });
}

function animateCounters() {
    const counters = document.querySelectorAll('.stat-number');
    
    counters.forEach(counter => {
        const target = parseInt(counter.textContent.replace(/,/g, ''));
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

function addRippleEffect() {
    const rippleElements = document.querySelectorAll('.action-card, .nav-item, .stat-card');
    
    rippleElements.forEach(element => {
        element.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s ease-out;
                pointer-events: none;
            `;
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Add ripple animation CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}

function handleActionCardClick(action) {
    // Add loading state
    const card = event.target.closest('.action-card');
    if (card) {
        card.classList.add('loading');
        
        // Remove loading state after animation
        setTimeout(() => {
            card.classList.remove('loading');
        }, 1000);
    }
    
    // Handle different actions
    switch (action) {
        case 'borrow':
            // Navigate to borrow page
            showNotification('Mengarahkan ke halaman peminjaman...', 'info');
            setTimeout(() => {
                window.location.href = '/peminjaman';
            }, 1000);
            break;
        case 'return':
            // Navigate to return page
            showNotification('Mengarahkan ke halaman pengembalian...', 'info');
            setTimeout(() => {
                window.location.href = '/pengembalian';
            }, 1000);
            break;
        case 'books':
            // Navigate to books page
            showNotification('Mengarahkan ke halaman buku...', 'info');
            setTimeout(() => {
                window.location.href = '/books';
            }, 1000);
            break;
        case 'users':
            // Navigate to users page
            showNotification('Mengarahkan ke halaman anggota...', 'info');
            setTimeout(() => {
                window.location.href = '/users';
            }, 1000);
            break;
        case 'reports':
            // Navigate to reports page
            showNotification('Mengarahkan ke halaman laporan...', 'info');
            setTimeout(() => {
                window.location.href = '/reports';
            }, 1000);
            break;
        case 'categories':
            // Navigate to categories page
            showNotification('Mengarahkan ke halaman kategori...', 'info');
            setTimeout(() => {
                window.location.href = '/categories';
            }, 1000);
            break;
        default:
            showNotification('Fitur akan segera tersedia!', 'warning');
    }
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <div class="notification-icon">
                ${getNotificationIcon(type)}
            </div>
            <div class="notification-message">${message}</div>
            <button class="notification-close">&times;</button>
        </div>
    `;
    
    // Add notification styles
    const notificationStyles = `
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-left: 4px solid;
            z-index: 1000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            max-width: 400px;
        }
        
        .notification-info { border-left-color: #3b82f6; }
        .notification-success { border-left-color: #10b981; }
        .notification-warning { border-left-color: #f59e0b; }
        .notification-error { border-left-color: #ef4444; }
        
        .notification-content {
            display: flex;
            align-items: center;
            padding: 1rem;
            gap: 0.75rem;
        }
        
        .notification-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .notification-message {
            flex: 1;
            font-size: 0.875rem;
            color: #374151;
        }
        
        .notification-close {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #9ca3af;
            cursor: pointer;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .notification-close:hover {
            color: #374151;
        }
    `;
    
    // Add styles if not already added
    if (!document.getElementById('notification-styles')) {
        const styleElement = document.createElement('style');
        styleElement.id = 'notification-styles';
        styleElement.textContent = notificationStyles;
        document.head.appendChild(styleElement);
    }
    
    // Add to document
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        removeNotification(notification);
    }, 5000);
    
    // Close button handler
    notification.querySelector('.notification-close').addEventListener('click', () => {
        removeNotification(notification);
    });
}

function getNotificationIcon(type) {
    const icons = {
        info: '<svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5 text-blue-500"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>',
        success: '<svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5 text-green-500"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
        warning: '<svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5 text-yellow-500"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
        error: '<svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5 text-red-500"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>'
    };
    return icons[type] || icons.info;
}

function removeNotification(notification) {
    notification.style.transform = 'translateX(100%)';
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 300);
}

// Utility functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Real-time updates (if needed)
function initializeRealTimeUpdates() {
    // This would connect to websockets or polling for real-time data
    setInterval(() => {
        updateDashboardStats();
    }, 30000); // Update every 30 seconds
}

function updateDashboardStats() {
    // Fetch new stats from API
    fetch('/api/dashboard/stats')
        .then(response => response.json())
        .then(data => {
            // Update stat numbers with animation
            updateStatNumber('total_books', data.total_books);
            updateStatNumber('total_users', data.total_users);
            updateStatNumber('total_loans', data.total_loans);
            updateStatNumber('total_categories', data.total_categories);
        })
        .catch(error => {
            console.error('Error updating stats:', error);
        });
}

function updateStatNumber(statId, newValue) {
    const element = document.querySelector(`[data-stat="${statId}"] .stat-number`);
    if (element) {
        const currentValue = parseInt(element.textContent.replace(/,/g, ''));
        if (currentValue !== newValue) {
            // Animate the change
            animateNumberChange(element, currentValue, newValue);
        }
    }
}

function animateNumberChange(element, from, to) {
    const duration = 1000;
    const increment = (to - from) / (duration / 16);
    let current = from;
    
    const timer = setInterval(() => {
        current += increment;
        if ((increment > 0 && current >= to) || (increment < 0 && current <= to)) {
            current = to;
            clearInterval(timer);
        }
        element.textContent = Math.floor(current).toLocaleString();
    }, 16);
}

// Initialize real-time updates if needed
// initializeRealTimeUpdates();