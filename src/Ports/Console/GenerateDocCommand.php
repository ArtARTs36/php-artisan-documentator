<?php

namespace ArtARTs36\ArtisanDocumentator\Ports\Console;

use ArtARTs36\ArtisanDocumentator\Generators\DocGenerator;
use ArtARTs36\ArtisanDocumentator\Support\Ci;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;

class GenerateDocCommand extends Command
{
    protected $signature = 'command:doc {path} {--documentator=} {--ci}';

    protected $description = 'Generate commands documentation';

    public function handle(DocGenerator $generator, Repository $config, Ci $ci)
    {
        $modified = $generator->generate(
            $this->option('documentator') ?? $config->get('artisan_documentator.documentators.default'),
            $path = $this->argument('path')
        );

        if ($modified) {
            $this->info('Documentation updated');

            if ($this->option('ci')) {
                $ci->sendDoc($path);

                $this->info('Documentation was send to remote git');
            }
        } else {
            $this->info('Documentation already is actually');
        }
    }
}
