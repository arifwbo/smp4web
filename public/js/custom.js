document.addEventListener("DOMContentLoaded", function() {
    // 1. Scroll Reveal Animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-in-up').forEach(el => {
        observer.observe(el);
    });

    // 2. Tab Navigation (untuk Profil Sekolah)
    var tabLinks = [].slice.call(document.querySelectorAll('.list-group-item-action'));
    tabLinks.forEach(function(link) {
        if (link.getAttribute('data-bs-toggle') === 'list') {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var tab = new bootstrap.Tab(link);
                tab.show();
            });
        }
    });
});
