document.addEventListener("DOMContentLoaded", function() {
    // Pastikan halaman selalu kembali ke atas setelah dimuat ulang
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
    window.scrollTo({ top: 0, behavior: 'instant' });
    // 1. Animasi muncul saat halaman discroll
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

    // 2. Navigasi tab (Profil Sekolah)
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

    // 3. Tombol kembali ke atas
    var backToTopBtn = document.getElementById('backToTopBtn');
    var backToTopFloating = document.querySelector('.back-to-top-floating');

    if (backToTopBtn && backToTopFloating) {
        var toggleBackToTop = function() {
            if (window.scrollY > 320) {
                backToTopFloating.classList.add('is-visible');
            } else {
                backToTopFloating.classList.remove('is-visible');
            }
        };

        toggleBackToTop();

        window.addEventListener('scroll', toggleBackToTop, { passive: true });

        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});
