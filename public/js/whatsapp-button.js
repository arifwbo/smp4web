document.addEventListener('DOMContentLoaded', function () {
    var trigger   = document.getElementById('waTrigger');
    var floating  = document.getElementById('waFloating');

    if (!trigger) return;

    // ── WhatsApp link opener ──
    trigger.addEventListener('click', function () {
        var phone   = trigger.getAttribute('data-wa-number') || '';
        var message = trigger.getAttribute('data-wa-message') || '';

        if (!phone) {
            console.warn('[WA] Nomor WhatsApp belum diatur.');
            return;
        }

        var waUrl = 'https://wa.me/' + phone;
        if (message) {
            waUrl += '?text=' + encodeURIComponent(message);
        }

        window.open(waUrl, '_blank', 'noopener,noreferrer');
    });

    // ── Touch-device: toggle info panel on tap (not hover) ──
    if (floating && window.matchMedia('(hover: none)').matches) {
        // On touch screens, single tap opens the info panel, double tap (second tap) opens WA
        var tapped = false;

        trigger.addEventListener('click', function (e) {
            if (!tapped) {
                e.preventDefault(); // First tap: show info
                floating.classList.toggle('wa-open');
                tapped = true;
                setTimeout(function () {
                    tapped = false;
                    floating.classList.remove('wa-open');
                }, 3000);
            }
            // Second tap within 3s: proceeds to open WhatsApp (handled by listener above)
        }, true); // Use capture to run before the main click listener
    }

    // ── Close panel when clicking outside ──
    document.addEventListener('click', function (e) {
        if (floating && !floating.contains(e.target)) {
            floating.classList.remove('wa-open');
        }
    });
});
