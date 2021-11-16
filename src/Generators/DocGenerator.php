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

    /**
     * Generate and save documentation to path
     * @return bool - is file modified
     */
    public function generate(string $documentator, string $path): bool
    {
        $content = $this
            ->documentators
            ->create($documentator)
            ->generate($this->commands->fetch($this->context->getNamespaces()), $this->context->namespacesGroups);

        $prevHash = $this->files->exists($path) ? $this->files->hash($path) : '';

        $this->files->put($path, $content);

        return $prevHash !== $this->files->hash($path);
    }
}
