<?php

namespace Tests\Feature;

use DOMDocument;
use Symfony\Component\Process\Process;
use Tests\TestCase;

class StaticExportTest extends TestCase
{
    public function test_export_contains_the_built_page_and_assets_under_the_project_url(): void
    {
        if (! is_file(public_path('build/manifest.json'))) {
            $this->markTestSkipped('Run npm run build before testing the static export.');
        }

        $url = 'https://example.com/Portfolio';
        $hotFile = is_file(public_path('hot')) ? file_get_contents(public_path('hot')) : null;
        $process = new Process(
            [PHP_BINARY, base_path('scripts/export-pages.php'), $url],
            base_path(),
            ['APP_KEY' => '', 'SESSION_DRIVER' => 'database', 'CACHE_STORE' => 'database'],
        );
        $process->mustRun();

        $html = file_get_contents(base_path('dist/index.html'));
        $this->assertStringContainsString('href="'.$url.'/" class="header-left-brand"', $html);
        $this->assertStringContainsString($url.'/build/assets/', $html);
        $this->assertStringContainsString($url.'/images/flags/fr.svg', $html);
        $this->assertStringContainsString('id="experience"', $html);
        $this->assertStringNotContainsString('@vite/client', $html);
        $this->assertStringNotContainsString(':5173', $html);
        $this->assertStringNotContainsString('http://localhost', $html);
        $this->assertFileExists(base_path('dist/.nojekyll'));
        $this->assertFileDoesNotExist(base_path('dist/index.php'));
        $this->assertFileDoesNotExist(base_path('dist/.env'));
        $this->assertDirectoryDoesNotExist(base_path('dist/vendor'));

        $document = new DOMDocument;
        $document->loadHTML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);

        foreach (['img' => 'src', 'script' => 'src', 'link' => 'href'] as $tag => $attribute) {
            foreach ($document->getElementsByTagName($tag) as $element) {
                $asset = $element->getAttribute($attribute);

                if (str_starts_with($asset, $url.'/')) {
                    $relativePath = substr($asset, strlen($url));
                    $this->assertFileExists(base_path('dist'.$relativePath), $asset);
                }
            }
        }

        if ($hotFile !== null) {
            $this->assertSame($hotFile, file_get_contents(public_path('hot')));
        }
    }

    public function test_export_rejects_a_url_that_cannot_be_a_public_website(): void
    {
        $process = new Process(
            [PHP_BINARY, base_path('scripts/export-pages.php'), 'ftp://example.com/Portfolio'],
            base_path(),
        );
        $process->run();

        $this->assertSame(1, $process->getExitCode());
        $this->assertStringContainsString('Usage:', $process->getErrorOutput());
    }
}
