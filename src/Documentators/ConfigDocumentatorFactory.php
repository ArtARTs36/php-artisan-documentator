<?php

namespace ArtARTs36\ArtisanDocumentator\Documentators;

use ArtARTs36\ArtisanDocumentator\Contracts\ArtisanDocumentator;
use Illuminate\Contracts\Container\Container;

class ConfigDocumentatorFactory
{
    /**
     * @param array<string, class-string<ArtisanDocumentator>> $classMap
     */
    public function __construct(private Container $container, private array $classMap)
    {
        //
    }

    public function create(string $type): ArtisanDocumentator
    {
        return $this->container->make(
            $this->classMap[$type] ?? throw new \RuntimeException('ArtisanDocumentator not found!')
        );
    }
}
