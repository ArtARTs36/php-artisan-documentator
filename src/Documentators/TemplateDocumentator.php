<?php

namespace ArtARTs36\ArtisanDocumentator\Documentators;

use ArtARTs36\ArtisanDocumentator\Contracts\ArtisanDocumentator;
use Illuminate\Console\Command;
use Illuminate\Contracts\View\Factory;

class TemplateDocumentator implements ArtisanDocumentator
{
    public function __construct(
        private Factory $viewer,
        private SignatureBuilder $signature,
        private Replaces $replaces,
        private string $template,
    ) {
        //
    }

    public function generate(array $commands, array $namespaceGroups): string
    {
        $prepared = [];

        foreach ($commands as $namespace => $cmd) {
            $prepared[$namespace]['name'] = $namespaceGroups[$namespace] ?? 'All Commands';
            
            /** @var Command $command */
            foreach ($cmd as $command) {
                $replace = $this->replaces->get($command::class);

                $prepared[$namespace]['commands'][] = [
                    'name' => $command->getName(),
                    'description' => $replace['description'] ?? $command->getDescription(),
                    'signature' => $this->signature->build($command),
                ];
            }
        }
        
        return $this->viewer->make($this->template, [
            'groups' => $prepared,
        ])->render();
    }
}
