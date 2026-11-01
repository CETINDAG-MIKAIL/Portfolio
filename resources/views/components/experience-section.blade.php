@props(['experiences'])

<section class="experience" id="experience" aria-labelledby="experience-title">
    <div class="experience-header">
        <h2 class="experience-header-title" id="experience-title">Expérience professionnelle</h2>
        <p class="experience-header-description">Une première expérience du développement full-stack en entreprise.</p>
    </div>

    <div class="experience-list">
        @foreach($experiences as $experience)
            <article class="experience-card">
                <div class="experience-card-layout">
                    <div class="experience-company">
                        <span class="experience-company-mark" aria-hidden="true">{{ $experience['initials'] }}</span>
                        <p class="experience-company-name">{{ $experience['company'] }}</p>
                        <p class="experience-company-location">{{ $experience['location'] }}</p>

                        <dl class="experience-facts">
                            <div>
                                <dt>Période</dt>
                                <dd>{{ $experience['period'] }}</dd>
                            </div>
                            <div>
                                <dt>Durée</dt>
                                <dd>{{ $experience['duration'] }}</dd>
                            </div>
                            <div>
                                <dt>Équipe projet</dt>
                                <dd>{{ $experience['team'] }}</dd>
                            </div>
                        </dl>

                        <ul class="experience-technologies" aria-label="Technologies utilisées">
                            @foreach($experience['technologies'] as $technology)
                                <li>{{ $technology }}</li>
                            @endforeach
                        </ul>

                        <p class="experience-private">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="5" y="10" width="14" height="11" rx="2" />
                                <path d="M8 10V6a4 4 0 0 1 8 0v4m-4 5v2" />
                            </svg>
                            Code source privé
                        </p>
                    </div>

                    <div class="experience-work">
                        <p class="experience-type">{{ $experience['type'] }}</p>
                        <h3 class="experience-role">{{ $experience['role'] }}</h3>
                        <p class="experience-project">{{ $experience['project'] }}</p>
                        <p class="experience-summary">{{ $experience['summary'] }}</p>

                        <h4 class="experience-contributions-title">Mes contributions</h4>
                        <ul class="experience-contributions">
                            @foreach($experience['contributions'] as $contribution)
                                <li>
                                    <span class="experience-contribution-number" aria-hidden="true">{{ sprintf('%02d', $loop->iteration) }}</span>
                                    <div>
                                        <h5>{{ $contribution['title'] }}</h5>
                                        <p>{{ $contribution['description'] }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <details class="experience-details">
                    <summary>
                        <span class="experience-details-label">
                            <span class="experience-details-closed">Voir l’étude de cas</span>
                            <span class="experience-details-open">Réduire l’étude de cas</span>
                        </span>
                        <span class="experience-details-hint">Contexte, défis et résultat</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </summary>

                    <div class="experience-case">
                        <div>
                            <h4>Le contexte</h4>
                            <p>{{ $experience['context'] }}</p>
                        </div>
                        <div>
                            <h4>Les défis techniques</h4>
                            <ul>
                                @foreach($experience['challenges'] as $challenge)
                                    <li>{{ $challenge }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="experience-result">
                            <h4>Le résultat</h4>
                            <p>{{ $experience['result'] }}</p>
                        </div>
                    </div>
                </details>
            </article>
        @endforeach
    </div>
</section>
