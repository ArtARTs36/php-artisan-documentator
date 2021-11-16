<?php

namespace ArtARTs36\ArtisanDocumentator\Documentators;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

class SignatureBuilder
{
    public function build(Command $command): string
    {
        $signature = $command->getName() ?? '';

        foreach ($command->getDefinition()->getArguments() as $argument) {
            $signature .= ' {' . $argument->getName() . '}';
        }

        $signature .= $this->buildOptions($command);

        return $signature;
    }

    protected function buildOptions(Command $command): string
    {
        return implode("\n", array_map(function (InputOption $option) {
            $signature = ' {--' . $option->getName();

            if ($option->acceptValue()) {
                $signature .= '=';
            }

            if (! empty($option->getDescription())) {
                $signature .= ': ' . $option->getDescription();
            }

            return $signature . '}';
        }, $command->getDefinition()->getOptions()));
    }
}
