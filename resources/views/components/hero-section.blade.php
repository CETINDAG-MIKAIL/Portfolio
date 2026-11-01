@props(['projects'])

@php
    $featuredProject = collect($projects)->firstWhere('featured', true) ?? ($projects[0] ?? null);
@endphp

<section class="hero" id="accueil" aria-labelledby="hero-title">
    <div class="hero-container {{ !$featuredProject ? 'hero-container--solo' : '' }}">
        <div class="hero-intro">
            <p class="hero-eyebrow">Portfolio · Développeur junior</p>

            <h1 class="hero-title" id="hero-title">
                Mikail<br>
                <span>Cetindag<span class="hero-title-dot">.</span></span>
            </h1>

            <p class="hero-role">Développeur full-stack.</p>
            <p class="hero-description">
                Je développe des applications de bout en bout, des interfaces
                aux bases de données, en passant par les API et la logique métier.
            </p>

            <div class="hero-actions">
                <a class="hero-button hero-button--primary" href="#projets">
                    Voir mes projets
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14m-6-6 6 6-6 6" />
                    </svg>
                </a>
                <a class="hero-button hero-button--secondary" href="#contact">Me contacter</a>
            </div>
        </div>

        @if($featuredProject)
            <div class="hero-showcase">
                <p class="hero-showcase-label">
                    <span aria-hidden="true"></span>
                    Un aperçu de mon travail
                </p>

                <a
                    class="hero-feature"
                    href="{{ $featuredProject['github'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Découvrir {{ $featuredProject['title'] }} (nouvel onglet)"
                >
                    <div class="hero-feature-bar">
                        <span class="hero-feature-dots" aria-hidden="true"><i></i><i></i><i></i></span>
                        <span>Projet à la une</span>
                    </div>

                    <div class="hero-feature-preview">
                        <img
                            src="{{ asset($featuredProject['image']) }}"
                            alt="Aperçu du projet {{ $featuredProject['title'] }}"
                            width="1893"
                            height="767"
                            fetchpriority="high"
                        >
                    </div>

                    <div class="hero-feature-caption">
                        <div>
                            <h2>{{ \Illuminate\Support\Str::before($featuredProject['title'], ' — ') }}</h2>
                            <p>{{ implode(' · ', $featuredProject['technologies']) }}</p>
                        </div>
                        <span class="hero-feature-arrow" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M7 17 17 7M7 7h10v10" />
                            </svg>
                        </span>
                    </div>
                </a>

                <a class="hero-journey" href="#parcours">
                    En savoir plus sur mon parcours
                    <span aria-hidden="true">↗</span>
                </a>
            </div>
        @endif
    </div>
</section>
