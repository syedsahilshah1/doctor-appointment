// Main Script
document.addEventListener('DOMContentLoaded', function() {
    console.log('DocCare Loaded');
    
    // Add any specific client-side interactions here
    // e.g. fade out alerts
    setTimeout(function() {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            // Bootstrap alert close logic usually handles this, but auto-dismiss is nice
            // new bootstrap.Alert(alert).close();
        });
    }, 5000);
});
