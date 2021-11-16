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
    'git' => [
        'dir' => base_path(),
        'remote' => [
            'login' => 'my-name',
            'token' => env('ARTISAN_DOCUMENTATOR_GIT_REMOTE_TOKEN'),
        ],
        'commit' => [
            'message' => '[DOCS] auto-build console documentation',
        ],
    ],
];
