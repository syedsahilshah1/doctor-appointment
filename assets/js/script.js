// Main Script
document.addEventListener('DOMContentLoaded', function() {
    console.log('DocCare Loaded');
    
    // Add any specific client-side interactions here
    // Navbar Scroll Glassmorphism
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        const toggleNavbar = () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        };
        
        window.addEventListener('scroll', toggleNavbar);
        toggleNavbar(); // Check on load
    }

    setTimeout(function() {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            // Bootstrap alert close logic usually handles this, but auto-dismiss is nice
            // new bootstrap.Alert(alert).close();
        });
    }, 5000);
});
