{{-- Nitro's mark: the server (warm) and the browser (cool), overlapping where they fuse. --}}
<span {{ $attributes->class('inline-flex items-center gap-2.5') }}>
    <svg class="size-7" viewBox="0 0 32 32" fill="none" aria-hidden="true">
        <defs>
            <linearGradient id="nitro-mark" x1="4" y1="6" x2="28" y2="26" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#f59e0b"/><stop offset=".5" stop-color="#ec4899"/><stop offset="1" stop-color="#8b5cf6"/>
            </linearGradient>
        </defs>
        <circle cx="12" cy="16" r="8.5" fill="#f59e0b" fill-opacity=".9"/>
        <circle cx="20" cy="16" r="8.5" fill="#8b5cf6" fill-opacity=".9"/>
        <path d="M16 8.6a8.5 8.5 0 0 1 0 14.8 8.5 8.5 0 0 1 0-14.8Z" fill="url(#nitro-mark)"/>
    </svg>
    <span class="text-[17px] font-semibold tracking-tight text-slate-900 dark:text-white">Nitro</span>
</span>
