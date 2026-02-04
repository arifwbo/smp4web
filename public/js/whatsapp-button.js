document.addEventListener('DOMContentLoaded', function () {
    var trigger = document.getElementById('waTrigger');
    if (!trigger) {
        return;
    }

    var tooltip = trigger.getAttribute('data-wa-tooltip') || 'Hubungi Kami via WhatsApp';
    trigger.setAttribute('aria-label', tooltip);
    trigger.style.cursor = 'pointer';

    trigger.addEventListener('click', function () {
        var phone = trigger.getAttribute('data-wa-number') || '';
        var message = trigger.getAttribute('data-wa-message') || '';

        if (!phone) {
            console.warn('Nomor WhatsApp belum diatur.');
            return;
        }

        var encodedMsg = encodeURIComponent(message);
        var waUrl = 'https://wa.me/' + phone + (encodedMsg ? '?text=' + encodedMsg : '');
        window.open(waUrl, '_blank', 'noopener,noreferrer');
    });
});
