# Portfolio de Mikail Cetindag

Portfolio de développeur full-stack : projets, expérience professionnelle chez ESI Informatique, parcours, technologies et contact.

Site public : https://cetindag-mikail.github.io/Portfolio/

## Technologies

Laravel 12, Blade, SCSS, Vite et Matter.js. Le thème clair/sombre, les infobulles et les interactions fonctionnent dans le navigateur. Le formulaire de contact prépare un message dans la messagerie du visiteur.

## Développement local

Installer les dépendances avec `composer install` et `npm ci`. Lors de la première installation, copier `.env.example` vers `.env`, exécuter `php artisan key:generate`, puis `php artisan migrate`.

Lancer `php artisan serve` et `npm run dev` dans deux terminaux.

## Publication sur GitHub Pages

Le workflow `.github/workflows/static.yml` installe les dépendances, compile les ressources et génère `dist/index.html` à partir de la page Laravel. Il publie uniquement `dist/` et ses ressources publiques.

Dans **Settings → Pages**, choisir **GitHub Actions** comme source. Chaque push sur `main` relance ensuite la publication. L'URL utilisée pour les ressources est obtenue automatiquement depuis la configuration Pages, y compris le préfixe `/Portfolio/`.

GitHub Pages sert la version HTML/CSS/JavaScript générée ; aucun serveur PHP n'est nécessaire pour consulter le portfolio.

Pour générer cet export localement dans PowerShell :

```powershell
$env:ASSET_URL = "https://cetindag-mikail.github.io/Portfolio"
npm run build
npm run export:pages -- $env:ASSET_URL
Remove-Item Env:ASSET_URL
```

L'export utilise les ressources compilées même si le serveur Vite local tourne. Il ne modifie pas `.env` et ne publie ni le code PHP, ni les dépendances, ni le rapport de stage. Les sources Laravel restent dans le dépôt pour le développement.

## Modifier le contenu

- Projets : `config/projects.php`
- Expérience professionnelle : `config/experiences.php`
- Parcours : `config/timeline.php`
- Langues : `config/languages.php`
- Coordonnées : `config/contact.php`

## Vérification

```text
npm run build
php artisan test
```
