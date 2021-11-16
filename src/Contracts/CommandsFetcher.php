<?php

namespace ArtARTs36\ArtisanDocumentator\Contracts;

use Illuminate\Console\Command;

interface CommandsFetcher
{
    /**
     * @param array<string> $namespaces
     * @return array<string, array<Command>>
     */
    public function fetch(array $namespaces = []): array;
}
