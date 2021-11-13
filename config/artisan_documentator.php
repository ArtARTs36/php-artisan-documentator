<?php

use ArtARTs36\ArtisanDocumentator\Documentators\TemplateDocumentator;

return [
    'documentators' => [
        'default' => 'template',
        'drivers' => [
            'template' => [
                'class' => TemplateDocumentator::class,
                'view' => 'artisan_documentator::command_doc_markdown',
            ],
        ],
    ],
    'namespaces' => [
        // 'namespace:' => 'title,
        // 'app:' => 'App Commands',
        // 'make:' => 'Laravel make Commands',
    ],
    'replaces' => [
        'CommandClass' => [
            'description' => '',
        ],
    ],
];
