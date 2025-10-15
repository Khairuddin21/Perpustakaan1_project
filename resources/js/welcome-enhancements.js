// Welcome Section Enhancements

// Real-time clock for welcome section
function initializeRealTimeClock() {
    const clockElement = document.getElementById('currentTime');
    if (clockElement) {
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            clockElement.textContent = `${hours}:${minutes}`;
        }
        
        updateClock(); // Initial update
        setInterval(updateClock, 1000); // Update every second
    }
}

// Quick action handlers
function handleQuickAction(action) {
    switch(action) {
        case 'loans':
            // Navigate to loan requests page
            window.location.href = '/loan-requests';
            break;
            
        case 'reports':
            // Navigate to reports page
            window.location.href = '/reports';
            break;
            
        default:
            console.log('Action not implemented:', action);
    }
}

// Initialize welcome section features on page load
(function() {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeRealTimeClock);
    } else {
        initializeRealTimeClock();
    }
})();

// Make handleQuickAction available globally
window.handleQuickAction = handleQuickAction;
