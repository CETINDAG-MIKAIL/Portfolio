@props(['name'])

<svg {{ $attributes->class(['contact-icon']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($name)
        @case('email')
            <rect x="3" y="5" width="18" height="14" rx="2" />
            <path d="m3 6 9 7 9-7" />
            @break
        @case('github')
            <path d="M9 19c-4.3 1.3-4.3-2.2-6-2.7M15 22v-3.9a3.4 3.4 0 0 0-.9-2.7c3-.3 6.2-1.5 6.2-6.9a5.4 5.4 0 0 0-1.5-3.7 5 5 0 0 0-.1-3.7s-1.2-.4-3.8 1.4a13 13 0 0 0-7 0C5.3.7 4.1 1.1 4.1 1.1A5 5 0 0 0 4 4.8a5.4 5.4 0 0 0-1.5 3.7c0 5.4 3.2 6.6 6.2 6.9a3.4 3.4 0 0 0-.9 2.7V22" />
            @break
        @case('linkedin')
            <rect x="3" y="3" width="18" height="18" rx="3" />
            <path d="M8 10v7m0-10h.01M12 17v-7m0 3a3 3 0 0 1 6 0v4" />
            @break
        @case('arrow')
            <path d="M7 17 17 7M7 7h10v10" />
            @break
        @case('copy')
            <rect x="8" y="8" width="12" height="13" rx="2" />
            <path d="M16 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3" />
            @break
        @case('check')
            <path d="m5 12 4 4L19 6" />
            @break
        @case('send')
            <path d="m22 2-7 20-4-9L2 9 22 2ZM11 13 22 2" />
            @break
    @endswitch
</svg>
