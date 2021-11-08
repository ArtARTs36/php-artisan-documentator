<?php

namespace ArtARTs36\ArtisanDocumentator\Generators;

use ArtARTs36\ArtisanDocumentator\Contexts\DocGenerateContext;
use ArtARTs36\ArtisanDocumentator\Contracts\CommandsFetcher;
use ArtARTs36\ArtisanDocumentator\Documentators\ConfigDocumentatorFactory;
use Illuminate\Filesystem\Filesystem;

class DocGenerator
{
    public function __construct(
        private ConfigDocumentatorFactory $documentators,
        private CommandsFetcher $commands,
        private DocGenerateContext $context,
        private Filesystem $files,
    ) {
    }

    public function generate(string $documentator, string $path): void
    {
        $content = $this
            ->documentators
            ->create($documentator)
            ->generate($this->commands->fetch($this->context->getNamespaces()), $this->context->namespacesGroups);

        $this->files->put($path, $content);
    }
}
