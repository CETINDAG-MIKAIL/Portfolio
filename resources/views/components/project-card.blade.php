
@props(['project'])

<article class="projects-grid-card">

    <div class="projects-grid-card-image">
        <img
            src="{{ asset($project['image']) }}"
            alt="{{ $project['title'] }}"
        >
    </div>

    <div class="projects-grid-card-content">

        <h3 class="projects-grid-card-content-title">
            {{ $project['title'] }}
        </h3>

        <p class="projects-grid-card-content-description">
            {{ $project['description'] }}
        </p>

        @if(!empty($project['technologies']))
            <ul class="projects-grid-card-content-tags">
                @foreach($project['technologies'] as $technology)
                    <li class="projects-grid-card-content-tags-item">
                        {{ $technology }}
                    </li>
                @endforeach
            </ul>
        @endif

        <a
            href="{{ $project['github'] }}"
            class="projects-grid-card-content-link"
            target="_blank"
            rel="noopener noreferrer"
        >
            Découvrir le projet
        </a>

    </div>

</article>
