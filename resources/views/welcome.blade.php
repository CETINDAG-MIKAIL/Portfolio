@extends('layouts.app')

@section('content')

<x-hero-section :projects="$projects" />

<section class="projects" id="projets">
    <div class="projects-header">
        <h2 class="projects-header-title">Mes projets</h2>
        <p class="projects-header-description">Découvrez quelques applications que j'ai développées.</p>
    </div>
    
   <div class="projects-grid">

        @foreach($projects as $project)

            <x-project-card :project="$project" />

        @endforeach

    </div>

</section>

<x-experience-section :experiences="$experiences" />

<section class="timeline" id="parcours">
    <div class="timeline-header">
        <h2 class="timeline-header-title">Parcours</h2>
        <p class="timeline-header-description">Mes expériences et mes formations.</p>
    </div>

    <ol class="timeline-list">

        @foreach($timeline as $item)

            <x-timeline-item :item="$item" />

        @endforeach

    </ol>

</section>

<section class="gravity" id="competences">
    <div class="gravity-content">
        <div class="gravity-header">
            <h2 class="gravity-header-title">Compétences</h2>
            <p class="gravity-header-description">Survolez les logos pour découvrir les technologies, ou déplacez-les.</p>
        </div>

        <div class="gravity-container"></div>
    </div>
</section>

<section class="languages" id="langues">
    <div class="languages-header">
        <h2 class="languages-header-title">Langues</h2>
        <p class="languages-header-description">Les langues dans lesquelles je peux échanger.</p>
    </div>

    <div class="languages-grid">

        @foreach($languages as $language)

            <x-language-card :language="$language" />

        @endforeach

    </div>

</section>

<x-contact-section :contact="$contact" />

@endsection
