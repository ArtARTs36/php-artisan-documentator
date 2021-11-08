<?php

namespace ArtARTs36\ArtisanDocumentator\Contexts;

class DocGenerateContext
{
    /**
     * @param array<string, string> $namespacesGroups
     */
    public function __construct(
        public array $namespacesGroups,
    ) {
        //
    }

    public function getNamespaces(): array
    {
        return array_keys($this->namespacesGroups);
    }
}
