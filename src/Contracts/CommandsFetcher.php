<?php

namespace ArtARTs36\ArtisanDocumentator\Contracts;

use Illuminate\Console\Command;

interface CommandsFetcher
{
    /**
     * @return array<string, array<Command>>
     */
    public function fetch(array $namespaces = []): array;
}
