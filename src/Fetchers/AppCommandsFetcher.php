<?php

namespace ArtARTs36\ArtisanDocumentator\Fetchers;

use ArtARTs36\ArtisanDocumentator\Contracts\CommandsFetcher;
use Illuminate\Contracts\Console\Kernel;
use Symfony\Component\Console\Command\Command;

class AppCommandsFetcher implements CommandsFetcher
{
    public function __construct(private Kernel $application)
    {
        //
    }

    public function fetch(array $namespaces = []): array
    {
        if (count($namespaces) === 0) {
            return ['all' => $this->application->all()];
        }

        return $this->filterCommands($namespaces);
    }

    /**
     * @param array<string> $namespaces
     * @return array<string, array<Command>>
     */
    protected function filterCommands(array $namespaces): array
    {
        $commands = [];

        foreach ($this->application->all() as $command) {
            foreach ($namespaces as $namespace) {
                if (str_starts_with($command->getName(), $namespace)) {
                    $commands[$namespace][$command->getName()] = $command;

                    break;
                }
            }
        }

        return $commands;
    }
}
