<?php

namespace ArtARTs36\ArtisanDocumentator\Ports\Console;

use ArtARTs36\ArtisanDocumentator\Generators\DocGenerator;
use ArtARTs36\ArtisanDocumentator\Support\Repo;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;

class GenerateDocCommand extends Command
{
    protected $signature = 'command:doc {path} {--documentator=} {--ci}';

    protected $description = 'Generate commands documentation';

    public function handle(DocGenerator $generator, Repository $config, Repo $repo)
    {
        $modified = $generator->generate(
            $this->option('documentator') ?? $config->get('artisan_documentator.documentators.default'),
            $path = $this->argument('path')
        );

        if ($this->option('ci') && $modified) {
            $repo->commitAndPush($path);
        }
    }
}
