document.addEventListener("DOMContentLoaded", function() {
    // 1. Scroll Restoration (prevent browser from remembering scroll position on reload)
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
    // Only scroll to top on initial page load if no hash is present, 
    // to allow anchor links (like /profil#sejarah) to work correctly
    if (!window.location.hash) {
        window.scrollTo({ top: 0, behavior: 'instant' });
    }

    // 2. Initialize AOS Animation Library
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 700,
            once: true,
            offset: 80,
            easing: 'ease-out-cubic'
        });
    }

    // 3. Global Scroll Handler (Navbar, Progress Bar, Back to Top)
    const navbar = document.getElementById('mainNavbar');
    const progress = document.getElementById('scroll-progress');
    const backToTop = document.getElementById('back-to-top'); // the .fab-top button

    window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;

        // Scroll progress bar
        if (progress && docHeight > 0) {
            progress.style.width = ((scrollTop / docHeight) * 100) + '%';
        }

        // Navbar shrink
        if (navbar) {
            navbar.classList.toggle('scrolled', scrollTop > 50);
        }

        // Back to top visibility (uses .fab-top + .visible)
        if (backToTop) {
            backToTop.classList.toggle('visible', scrollTop > 300);
        }
    }, { passive: true });

    // Back to top click
    if (backToTop) {
        backToTop.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // 4. Intersection Observer for custom reveal animations
    const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible', 'is-visible');
                observer.unobserve(entry.target);
            }
        });
    };

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(observerCallback, { threshold: 0.1 });
        
        document.querySelectorAll('.fade-in-up, .reveal-segment').forEach(el => {
            observer.observe(el);
        });
    } else {
        // Fallback for older browsers
        document.querySelectorAll('.fade-in-up, .reveal-segment').forEach(el => {
            el.classList.add('visible', 'is-visible');
        });
    }

    // 5. Tab Navigation Handler (e.g. Profil Sekolah)
    const tabLinks = document.querySelectorAll('.list-group-item-action[data-bs-toggle="list"]');
    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            if (typeof bootstrap !== 'undefined') {
                const tab = new bootstrap.Tab(this);
                tab.show();
            }
        });
    });
});
