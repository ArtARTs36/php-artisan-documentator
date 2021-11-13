<?php

namespace ArtARTs36\ArtisanDocumentator\Documentators;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Console\Command\Command;

class Replaces
{
    /**
     * @param array<class-string<Command>, array<string, string>> $replaces
     */
    public function __construct(private array $replaces)
    {
        //
    }

    /**
     * @param class-string<Command> $commandClass
     * @return array<string, string>
     */
    #[ArrayShape([
        'description' => 'string',
    ])]
    public function get(string $commandClass): array
    {
        return $this->replaces[$commandClass] ?? [];
    }
}
