
<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Portfolio | Mikail Cetindag</title>

    <script>
        // Restaurer le thème avant l'affichage pour éviter un flash de couleur.
        try {
            const theme = localStorage.getItem('portfolio-theme');
            if (theme === 'light' || theme === 'dark') {
                document.documentElement.dataset.theme = theme;
            }
        } catch {
            // Le thème sombre reste disponible si le stockage est bloqué.
        }
    </script>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>

    <header class="header">

        <div class="header-left">
            <a href="/" class="header-left-brand">
                Mikail Cetindag
            </a>
        </div>

        <nav class="header-center">
            <ul class="header-center-menu">

                <!-- Pastille animée placée sous le lien actif (resources/js/nav.js) -->
                <li class="header-center-menu-indicator" aria-hidden="true"></li>

                <li class="header-center-menu-item">
                    <a href="#accueil" class="header-center-menu-item-link">
                        Accueil
                    </a>
                </li>

                <li class="header-center-menu-item">
                    <a href="#projets" class="header-center-menu-item-link">
                        Projets
                    </a>
                </li>

                <li class="header-center-menu-item">
                    <a href="#experience" class="header-center-menu-item-link">
                        Expérience
                    </a>
                </li>

                <li class="header-center-menu-item">
                    <a href="#parcours" class="header-center-menu-item-link">
                        Parcours
                    </a>
                </li>

                <li class="header-center-menu-item">
                    <a href="#competences" class="header-center-menu-item-link">
                        Compétences
                    </a>
                </li>

                <li class="header-center-menu-item">
                    <a href="#langues" class="header-center-menu-item-link">
                        Langues
                    </a>
                </li>

                <li class="header-center-menu-item">
                    <a href="#contact" class="header-center-menu-item-link">
                        Contact
                    </a>
                </li>

            </ul>
        </nav>

        <div class="header-right">
            <button
                class="theme-toggle"
                type="button"
                aria-label="Activer le thème clair"
                title="Activer le thème clair"
            >
                <span class="theme-toggle-icons" aria-hidden="true">
                    <svg class="theme-toggle-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round">
                        <circle cx="12" cy="12" r="4" />
                        <path d="M12 2v2m0 16v2M2 12h2m16 0h2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42" />
                    </svg>
                    <svg class="theme-toggle-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.9 13a9 9 0 0 1-9.9-9.9A9 9 0 1 0 20.9 13Z" />
                    </svg>
                </span>
                <span class="theme-toggle-label" aria-hidden="true">Clair</span>
            </button>
        </div>

    </header>

    <main class="main">
        @yield('content')
    </main>

    <footer class="footer">
        <p class="footer-copyright">
            &copy; 2026 Mikail Cetindag. Tous droits réservés.
        </p>
    </footer>

</body>
</html>
