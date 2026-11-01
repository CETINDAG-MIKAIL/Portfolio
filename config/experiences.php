<?php

return [
    [
        'company' => 'ESI Informatique',
        'initials' => 'ESI',
        'location' => 'Verviers, Belgique',
        'period' => '2025',
        'duration' => '14 semaines',
        'team' => '3 stagiaires',
        'type' => 'Stage de fin d’études',
        'role' => 'Développeur full-stack',
        'project' => 'Plateforme de services web et support client',
        'summary' => 'J’ai participé au développement d’une application métier, de la base de données aux interfaces, au sein d’une équipe de trois stagiaires encadrée par le département web d’ESI.',
        'technologies' => ['PHP', 'Laravel 12', 'Livewire', 'Blade', 'Eloquent', 'SCSS', 'Alpine.js', 'Pest', 'Git / Gitea'],
        'contributions' => [
            [
                'title' => 'Interfaces dynamiques',
                'description' => 'Intégration des maquettes avec Blade et SCSS, développement de composants Livewire et correction des interactions avec Alpine.js.',
            ],
            [
                'title' => 'Back-end & données',
                'description' => 'Participation à la conception de la base relationnelle, des migrations et des modèles Eloquent, avec des relations polymorphes pour les produits.',
            ],
            [
                'title' => 'Intégration & tests',
                'description' => 'Vérification de disponibilité des domaines via Whois, tests avec Pest et préparation de données avec les seeders et Faker.',
            ],
            [
                'title' => 'Travail en équipe',
                'description' => 'Collaboration avec deux autres stagiaires : branches Git sur Gitea, résolution de conflits, répartition des tâches et réunions de suivi.',
            ],
        ],
        'context' => 'Le projet visait à réunir un catalogue de services web, un parcours d’achat et le support client dans une même application. Nous sommes partis de maquettes Figma fournies par l’entreprise pour construire les interfaces, la logique métier et la base de données.',
        'challenges' => [
            'Reprise des premiers composants Volt en Livewire classique pour adopter la séparation des responsabilités attendue par l’équipe.',
            'Résolution du clignotement des modales et des problèmes de champs obligatoires conditionnels avec Livewire et Alpine.js.',
        ],
        'result' => 'Une version avancée de l’application a été développée, avec les pages prévues, plusieurs fonctionnalités métier et des améliorations ergonomiques. Les liaisons entre les noms de domaine, les hébergements et les certificats SSL restaient à finaliser au terme du stage.',
    ],
];
