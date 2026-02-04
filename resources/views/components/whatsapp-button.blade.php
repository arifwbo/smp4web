@php
    $waNumber = ($whatsappNumber ?? null) ?: config('school.whatsapp_number', '6281355577799');
    $waMessage = config('school.whatsapp_message', 'Halo Admin SMP Negeri 4 Samarinda, saya ingin bertanya informasi sekolah.');
    $waTooltip = config('school.whatsapp_tooltip', 'Hubungi Kami via WhatsApp');
    $waSchedule = config('school.whatsapp_schedule', 'Senin–Jumat | 08.00–14.00 WITA');
@endphp

@if($waNumber)
<div class="wa-floating" aria-label="{{ $waTooltip }}">
    <div class="wa-info">
        <strong>WhatsApp Sekolah</strong>
        <span>{{ $waSchedule }}</span>
    </div>
    <button
        type="button"
        class="wa-btn"
        id="waTrigger"
        data-wa-number="{{ $waNumber }}"
        data-wa-message="{{ $waMessage }}"
        data-wa-tooltip="{{ $waTooltip }}"
    >
        <svg width="28" height="28" viewBox="0 0 32 32" aria-hidden="true">
            <path fill="currentColor" d="M16 3a13 13 0 0 0-11.2 19.4L3 29l6.8-1.8A13 13 0 1 0 16 3zm0 2.4a10.6 10.6 0 0 1 9.2 16 1 1 0 0 1-.1 1.1 1 1 0 0 1-1.1.3 8.8 8.8 0 0 0-2.8-.5c-5.6 0-10.2 4.1-11.1 9.6l-.5 3.1L7 26.2a1 1 0 0 1-.4-1.2 10.6 10.6 0 0 1 9.4-19.6zm4.4 6.6c-.2-.4-.4-.3-.6-.4h-.6a1.2 1.2 0 0 0-.8.3 2.6 2.6 0 0 0-.9 1.9 4.5 4.5 0 0 0 1 2.3 8.8 8.8 0 0 0 1.8 2.1 6.9 6.9 0 0 0 2.5 1.4c.4.1.7.2 1 .2a2.2 2.2 0 0 0 1.4-.6 1.6 1.6 0 0 0 .2-1.2 7.2 7.2 0 0 0-.3-.7l-.5-1.3c-.1-.2-.2-.3-.4-.4l-1-.2-.6.2s-.3.5-.4.5-.3 0-.5-.2a4.9 4.9 0 0 1-1.5-1.2 5 5 0 0 1-1-1.4c-.2-.4 0-.5.1-.7l.3-.4.2-.5a.8.8 0 0 0-.2-.6c-.1 0-.2-.3-.4-.3z" />
        </svg>
    </button>
</div>
@endif
