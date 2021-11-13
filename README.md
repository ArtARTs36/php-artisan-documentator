# Artisan Documentator

This package provides generate documentation about your app console commands.

## Installation

Run commands:

* `composer require --dev artarts36/artisan-documentator`
* `php artisan vendor:publish --provider="ArtARTs36\ArtisanDocumentator\Providers\ArtisanDocumentatorServiceProvider" --tag=config`

## Console commands

After installation, you can run command `php artisan command:doc {path}`. Example: `php artisan command:doc docs/command.md`

## Configuration

You can set command's namespaces in the file: `config/artisan_documentator.php` in section 'namespaces':

```php
    'namespaces' => [
        // 'namespace:' => 'title,
        // 'app:' => 'App Commands',
        // 'make:' => 'Laravel make Commands',
    ],
```
