<?php

declare(strict_types=1);

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Vite;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

$root = dirname(__DIR__);
$targetUrl = rtrim($argv[1] ?? '', '/');
$parts = parse_url($targetUrl);

if (! filter_var($targetUrl, FILTER_VALIDATE_URL)
    || ! in_array($parts['scheme'] ?? '', ['http', 'https'], true)
    || isset($parts['user'])
    || isset($parts['pass'])
    || isset($parts['query'])
    || isset($parts['fragment'])) {
    fwrite(STDERR, "Usage: npm run export:pages -- https://cetindag-mikail.github.io/Portfolio\n");
    exit(1);
}

if (! is_file($root.'/public/build/manifest.json')) {
    fwrite(STDERR, "Build manquant : lancez npm run build avant l'export.\n");
    exit(1);
}

require $root.'/vendor/autoload.php';

try {
    $app = require $root.'/bootstrap/app.php';
    // Utiliser les valeurs publiques par défaut, comme sur un clone sans .env en CI.
    $app->loadEnvironmentFrom('.env.example');
    $origin = $parts['scheme'].'://'.$parts['host'].(isset($parts['port']) ? ':'.$parts['port'] : '');
    $request = Request::create($origin.'/', 'GET');
    $app->instance('request', $request);

    $kernel = $app->make(Kernel::class);
    $kernel->bootstrap();

    // L'export n'utilise ni la base de données ni la session de développement.
    config([
        'app.url' => $targetUrl,
        'app.debug' => false,
        'session.driver' => 'array',
        'cache.default' => 'array',
    ]);

    if (! config('app.key')) {
        config(['app.key' => 'base64:'.base64_encode(random_bytes(32))]);
    }

    $urls = $app->make(UrlGenerator::class);
    $urls->useOrigin($targetUrl);
    $urls->useAssetOrigin($targetUrl);
    $urls->forceScheme($parts['scheme']);

    // Utiliser le build même si le serveur Vite local est en cours d'exécution.
    $app->make(Vite::class)->useHotFile(storage_path('framework/static-export.hot'));

    $response = $kernel->handle($request);

    if ($response->getStatusCode() !== 200) {
        throw new RuntimeException('Le rendu de la page a retourne HTTP '.$response->getStatusCode().'.');
    }

    $html = $response->getContent();

    if (! is_string($html) || ! str_contains($html, '<html')) {
        throw new RuntimeException("Le rendu ne contient pas de page HTML.");
    }

    $files = new Filesystem;
    $destination = $root.'/dist';
    $files->ensureDirectoryExists($destination);

    // Copier uniquement les ressources publiques nécessaires au portfolio.
    foreach (['build', 'images'] as $directory) {
        if (! $files->copyDirectory($root.'/public/'.$directory, $destination.'/'.$directory)) {
            throw new RuntimeException('Impossible de copier les ressources '.$directory.'.');
        }
    }

    foreach (['favicon.ico', 'robots.txt'] as $file) {
        $source = $root.'/public/'.$file;

        if ($files->isFile($source) && ! $files->copy($source, $destination.'/'.$file)) {
            throw new RuntimeException('Impossible de copier '.$file.'.');
        }
    }

    if ($files->put($destination.'/index.html', $html) === false
        || $files->put($destination.'/.nojekyll', '') === false) {
        throw new RuntimeException("Impossible d'ecrire la page HTML exportee.");
    }
    $kernel->terminate($request, $response);

    fwrite(STDOUT, 'Portfolio exporte dans dist/index.html pour '.$targetUrl."/\n");
} catch (Throwable $exception) {
    fwrite(STDERR, 'Export impossible : '.$exception->getMessage()."\n");
    exit(1);
}
