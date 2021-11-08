<?php

namespace ArtARTs36\ArtisanDocumentator\Ports\Console;

use ArtARTs36\ArtisanDocumentator\Generators\DocGenerator;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;

class GenerateDocCommand extends Command
{
    protected $signature = 'command:doc {path} {--documentator=}';

    protected $description = 'Generate commands documentation';

    public function handle(DocGenerator $generator, Repository $config)
    {
        $generator->generate(
            $this->option('documentator') ?? $config->get('artisan_documentator.documentators.default'),
            $this->argument('path')
        );
    }
}
