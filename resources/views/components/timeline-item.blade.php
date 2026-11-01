@props(['item'])

@php
    $labels = [
        'experience' => 'Expérience',
        'formation' => 'Formation',
    ];
@endphp

<li class="timeline-list-item timeline-list-item--{{ $item['type'] }}">

    <span class="timeline-list-item-period">
        {{ $item['period'] }}
    </span>

    <span class="timeline-list-item-dot" aria-hidden="true"></span>

    <div class="timeline-list-item-card">

        <h3 class="timeline-list-item-card-title">
            {{ $item['title'] }}
        </h3>

        <p class="timeline-list-item-card-description">
            {{ $item['description'] }}
        </p>

        <span class="timeline-list-item-card-badge">
            {{ $labels[$item['type']] }}
        </span>

    </div>

</li>
