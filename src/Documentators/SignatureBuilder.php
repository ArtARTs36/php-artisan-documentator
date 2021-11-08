<?php

namespace ArtARTs36\ArtisanDocumentator\Documentators;

use Symfony\Component\Console\Command\Command;

class SignatureBuilder
{
    public function build(Command $command): string
    {
        $signature = $command->getName() ?? '';

        foreach ($command->getDefinition()->getArguments() as $argument) {
            $signature .= ' {' . $argument->getName() . '}';
        }

        foreach ($command->getDefinition()->getOptions() as $option) {
            $signature .= ' {--' . $option->getName();

            if ($option->acceptValue()) {
                $signature .= ' =';
            }

            if (! empty($option->getDescription())) {
                $signature .= ': ' . $option->getDescription();
            }

            $signature .= "}\n";
        }

        return $signature;
    }
}
