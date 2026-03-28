document.addEventListener('DOMContentLoaded', () => {

    // ===== Hamburger Mobile Menu =====
    const hamburger = document.getElementById('humburger-icon');
    const mobileMenu = hamburger ? hamburger.querySelector('ul.mobile-menu') : null;

    if (hamburger) {
        hamburger.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent click bubbling
            hamburger.classList.toggle('open');
        });
    }

    // ===== Dropdown Menu =====
    const dropdownToggle = document.getElementById('dropdown-toggle');
    const dropdownMenu = document.getElementById('dropdown-menu');

    if (dropdownToggle && dropdownMenu) {
        // Toggle dropdown on click
        dropdownToggle.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropdownMenu.classList.toggle('active');
        });

        // Prevent closing when clicking inside dropdown
        dropdownMenu.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }

    // ===== Click Outside to Close Menus =====
    document.addEventListener('click', () => {
        // Close dropdown
        if (dropdownMenu) dropdownMenu.classList.remove('active');
        // Close mobile menu
        if (hamburger && hamburger.classList.contains('open')) {
            hamburger.classList.remove('open');
        }
    });

    // Optional: Close menus on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (dropdownMenu) dropdownMenu.classList.remove('active');
            if (hamburger && hamburger.classList.contains('open')) {
                hamburger.classList.remove('open');
            }
        }
    });
});



