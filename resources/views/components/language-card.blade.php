@props(['language'])

@php
    $scale = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];
    $isNative = $language['level'] === 'native';

    // Nombre de segments remplis : tous pour une langue maternelle
    $filled = $isNative ? count($scale) : array_search($language['level'], $scale) + 1;
    $label = $isNative ? 'Langue maternelle' : 'Niveau ' . $language['level'];
@endphp

<article class="languages-grid-card {{ $isNative ? 'languages-grid-card--native' : '' }}">

    <div class="languages-grid-card-header">

        <span class="languages-grid-card-header-flag" aria-hidden="true">
            <img
                src="{{ asset('images/flags/' . $language['flag'] . '.svg') }}"
                alt=""
                width="32"
                height="22"
            >
        </span>

        <div>
            <h3 class="languages-grid-card-header-name">
                {{ $language['name'] }}
            </h3>

            <p class="languages-grid-card-header-level">
                {{ $label }}
            </p>
        </div>

    </div>

    <div
        class="languages-grid-card-scale"
        role="img"
        aria-label="{{ $label }}, sur l'échelle A1 à C2"
    >
        @foreach($scale as $index => $step)
            <div class="languages-grid-card-scale-step {{ $index < $filled ? 'is-filled' : '' }}">
                <span class="languages-grid-card-scale-step-bar"></span>
                <span class="languages-grid-card-scale-step-label">{{ $step }}</span>
            </div>
        @endforeach
    </div>

</article>
