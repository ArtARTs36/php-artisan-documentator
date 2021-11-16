<?php

namespace ArtARTs36\ArtisanDocumentator\Contracts;

use Symfony\Component\Console\Command\Command;

interface ArtisanDocumentator
{
    /**
     * Generate documentation content
     * @param array<string, array<Command>> $commands
     * @param array<string, string> $namespaceGroups
     */
    public function generate(array $commands, array $namespaceGroups): string;
}
